<?php

namespace Base\ProductsQcStats\ReadModel\Service;

use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\DataReader;
use Base\ProductsQcStats\ReadModel\Search;

/**
 * Class ImageMissingReaderService
 */
class ImageMissingReaderService
{
    /**
     * @var DataReader\ImageMissingRecordReader
     */
    private $imageMissingRecordReader;

    /**
     * @param DataReader\ImageMissingRecordReader $imageMissingRecordReader
     */
    public function __construct(DataReader\ImageMissingRecordReader $imageMissingRecordReader)
    {
        $this->imageMissingRecordReader = $imageMissingRecordReader;
    }

    /**
     * @param Search\AbstractQcStatusRecordSearch | Search\ImageMissingRecordSearch $imageMissingRecordSearch
     *
     * @return DataObject\ImageMissingStatusRecord
     */
    public function getItem(Search\AbstractQcStatusRecordSearch $imageMissingRecordSearch)
    {
        return $this->imageMissingRecordReader->getItem($imageMissingRecordSearch);
    }
}
