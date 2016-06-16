<?php

namespace Base\ProductsQcStats\ReadModel\DataObject\Factory;

use Base\ProductsQcStats\ReadModel;

/**
 * Class ProductsQcStatsFactory
 */
class ProductsQcStatsFactory
{
    /**
     * @param array $attributes
     *
     * @return ReadModel\DataObject\NewProductCreationRecord
     */
    public function createNewProductCreationFromArray(array $attributes)
    {
        return new ReadModel\DataObject\NewProductCreationRecord(
            $attributes[ReadModel\DataReader\NewProductCreationRecordReader::DB_COLUMN_COUNT_ALIAS]
        );
    }

    /**
     * @param array $attributes
     *
     * @return ReadModel\DataObject\PendingStatusRecord
     */
    public function createPendingFromArray(array $attributes)
    {
        return new ReadModel\DataObject\PendingStatusRecord(
            $attributes[ReadModel\DataReader\PendingRecordReader::DB_COLUMN_COUNT_ALIAS]
        );
    }

    /**
     * @param array $attributes
     *
     * @return ReadModel\DataObject\ApprovedStatusRecord
     */
    public function createApprovedFromArray(array $attributes)
    {
        return new ReadModel\DataObject\ApprovedStatusRecord(
            $attributes[ReadModel\DataReader\ApprovedRecordReader::DB_COLUMN_COUNT_ALIAS]
        );
    }

    /**
     * @param array $attributes
     *
     * @return ReadModel\DataObject\PoorQualityStatusRecord
     */
    public function createRejectedPoorQualityFromArray(array $attributes)
    {
        return new ReadModel\DataObject\PoorQualityStatusRecord(
            $attributes[ReadModel\DataReader\PoorQualityRecordReader::DB_COLUMN_COUNT_ALIAS]
        );
    }
    /**
     * @param array $attributes
     *
     * @return ReadModel\DataObject\ImageMissingStatusRecord
     */
    public function createImageMissingFromArray(array $attributes)
    {
        return new ReadModel\DataObject\ImageMissingStatusRecord(
            $attributes[ReadModel\DataReader\ImageMissingRecordReader::DB_COLUMN_COUNT_ALIAS]
        );
    }
}
