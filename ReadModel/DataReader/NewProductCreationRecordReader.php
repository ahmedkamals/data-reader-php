<?php

namespace Base\ProductsQcStats\ReadModel\DataReader;

use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\Search;
use Base\SharedKernel\Infrastructure\Repository\DataSetRepository;

/**
 * Class NewProductCreationRecordReader
 */
class NewProductCreationRecordReader
{
    const DB_TABLE_NAME = 'catalog_product';
    const DB_COLUMN_FK_SELLER = 'fk_seller';
    const DB_COLUMN_CREATED_AT = 'created_at';
    const DB_COLUMN_COUNT_ALIAS = 'alias_count';

    /**
     * @var \Base_Dataset
     */
    private $queryBuilder;

    /**
     * @var DataObject\Factory\ProductsQcStatsFactory
     */
    private $productQcStatusObjectFactory;

    /**
     * @param \Base_Dataset $dataset
     * @param DataObject\Factory\ProductsQcStatsFactory $productQcStatusObjectFactory
     */
    public function __construct(
        \Base_Dataset $dataset,
        DataObject\Factory\ProductsQcStatsFactory $productQcStatusObjectFactory
    ) {
        $this->queryBuilder = $dataset->getReadAdapter();
        $this->productQcStatusObjectFactory = $productQcStatusObjectFactory;
    }

    /**
     * @param Search\AbstractQcStatusRecordSearch $newProductCreationRecordSearch
     *
     * @throws \Zend_Db_Statement_Exception
     *
     * @return DataObject\NewProductCreationRecord
     */
    public function getItem(Search\AbstractQcStatusRecordSearch $newProductCreationRecordSearch)
    {
        $startDate = $newProductCreationRecordSearch->getStart();
        $endDate = $newProductCreationRecordSearch->getEnd();

        $queryBuilder = $this
            ->queryBuilder
            ->select()
            ->from(static::DB_TABLE_NAME, '');

        $columns = [
            static::DB_COLUMN_COUNT_ALIAS => new \Zend_Db_Expr(
                sprintf(
                    'COUNT(%s)',
                    static::DB_COLUMN_FK_SELLER
                )
            ),
        ];

        $select = $queryBuilder
            ->columns($columns)
            ->where(static::DB_COLUMN_FK_SELLER . ' = ?', $newProductCreationRecordSearch->getSellerId()->getId())
            ->where(static::DB_COLUMN_CREATED_AT . ' >= ?', $startDate->format(DataSetRepository::SQL_DATETIME_FORMAT))
            ->where(static::DB_COLUMN_CREATED_AT . ' <= ?', $endDate->format(DataSetRepository::SQL_DATETIME_FORMAT));

        $result = $this->queryBuilder->query($select)->fetch();

        return $this->getObjectsFromArray($result);
    }

    /**
     * @param array $result
     *
     * @return DataObject\NewProductCreationRecord
     */
    private function getObjectsFromArray(array $result)
    {
        return $this->productQcStatusObjectFactory->createNewProductCreationFromArray($result);
    }
}
