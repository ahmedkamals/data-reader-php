<?php

namespace Base\ProductsQcStats\ReadModel\Service;

use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\DataReader;
use Base\ProductsQcStats\ReadModel\Search;

/**
 * Class PoorQualityRecordReaderService
 */
class PoorQualityRecordReaderService
{
    /**
     * @var DataReader\PoorQualityRecordReader
     */
    private $poorQualityRecordReader;

    /**
     * @param DataReader\PoorQualityRecordReader $poorQualityRecordReader
     */
    public function __construct(DataReader\PoorQualityRecordReader $poorQualityRecordReader)
    {
        $this->poorQualityRecordReader = $poorQualityRecordReader;
    }

    /**
     * @param Search\AbstractQcStatusRecordSearch | Search\PoorQualityRecordSearch $poorQualityRecordSearch
     *
     * @return DataObject\PoorQualityStatusRecord
     */
    public function getItem(Search\AbstractQcStatusRecordSearch $poorQualityRecordSearch)
    {
        return $this->poorQualityRecordReader->getItem($poorQualityRecordSearch);
    }
}
