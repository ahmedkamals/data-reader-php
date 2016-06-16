<?php

namespace Base\ProductsQcStats\ReadModel\DataReader;

use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\Search;

/**
 * Class PoorQualityRecordReader
 */
class PoorQualityRecordReader
{
    const DB_TABLE_NAME = 'catalog_product';
    const DB_COLUMN_FK_SELLER = 'fk_seller';
    const DB_COLUMN_STATUS = 'status';
    const DB_COLUMN_APPROVAL_STATUS = 'approval_status';
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
     * @param Search\AbstractQcStatusRecordSearch $pendingStatusRecordSearch
     *
     * @throws \Zend_Db_Statement_Exception
     *
     * @return DataObject\PoorQualityStatusRecord
     */
    public function getItem(Search\AbstractQcStatusRecordSearch $pendingStatusRecordSearch)
    {
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
            ->where(static::DB_COLUMN_FK_SELLER . ' = ?', $pendingStatusRecordSearch->getSellerId()->getId())
            ->where(static::DB_COLUMN_STATUS . ' != ?', \Base_Model_Catalog_Product::STATUS_DELETED)
            ->where(static::DB_COLUMN_APPROVAL_STATUS . ' = ?', \Base_Model_Catalog_Product::QC_STATUS_REJECTED);

        $result = $this->queryBuilder->query($select)->fetch();

        return $this->getObjectFromArray($result);
    }

    /**
     * @param array $result
     *
     * @return DataObject\PoorQualityStatusRecord
     */
    private function getObjectFromArray(array $result)
    {
        return $this->productQcStatusObjectFactory->createRejectedPoorQualityFromArray($result);
    }
}
