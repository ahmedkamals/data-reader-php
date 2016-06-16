<?php

namespace Base\ProductsQcStats\ReadModel\DataReader;

use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\Search;

/**
 * Class ImageMissingRecordReader
 */
class ImageMissingRecordReader
{
    const DB_TABLE_CATALOG_PRODUCT = 'catalog_product';
    const DB_TABLE_CATALOG_PRODUCT_IMAGE = 'catalog_product_image';
    const DB_COLUMN_ID_CATALOG_PRODUCT_IMAGE = 'id_catalog_product_image';
    const DB_COLUMN_FK_CATALOG_PRODUCT_SET = 'fk_catalog_product_set';
    const DB_COLUMN_DELETED = 'deleted';
    const DB_COLUMN_STATUS = 'status';
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
     * @param Search\AbstractQcStatusRecordSearch | Search\ImageMissingRecordSearch $imageMissingRecordSearch
     *
     * @throws \Zend_Db_Statement_Exception
     *
     * @return DataObject\PoorQualityStatusRecord
     */
    public function getItem(Search\AbstractQcStatusRecordSearch $imageMissingRecordSearch)
    {
        $queryBuilder = $this
            ->queryBuilder
            ->select()
            ->from(static::DB_TABLE_CATALOG_PRODUCT, '');

        $columns = [
            static::DB_COLUMN_COUNT_ALIAS => new \Zend_Db_Expr(
                'COUNT(*)'
            ),
        ];

        $select = $queryBuilder
            ->columns($columns)
            ->joinLeft(
                static::DB_TABLE_CATALOG_PRODUCT_IMAGE,
                static::DB_TABLE_CATALOG_PRODUCT_IMAGE . '.' . static::DB_COLUMN_FK_CATALOG_PRODUCT_SET
                . ' = '
                . static::DB_TABLE_CATALOG_PRODUCT . '.' . static::DB_COLUMN_FK_CATALOG_PRODUCT_SET
                . ' AND ' . static::DB_TABLE_CATALOG_PRODUCT_IMAGE . '.' . static::DB_COLUMN_DELETED
                . ' = '
                . \Base_Model_Catalog_Product_Image::STATE_NOT_DELETED,
                null
            )
            ->where(static::DB_COLUMN_STATUS . ' != ?', \Base_Model_Catalog_Product::STATUS_DELETED)
            ->where(static::DB_COLUMN_FK_SELLER . ' = ?', $imageMissingRecordSearch->getSellerId()->getId())
            ->where(static::DB_COLUMN_ID_CATALOG_PRODUCT_IMAGE . ' IS NULL');

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
        return $this->productQcStatusObjectFactory->createImageMissingFromArray($result);
    }
}
