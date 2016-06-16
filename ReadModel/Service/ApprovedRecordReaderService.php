<?php

namespace Base\ProductsQcStats\ReadModel\Service;

use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\DataReader;
use Base\ProductsQcStats\ReadModel\Search;

/**
 * Class ApprovedRecordReaderService
 */
class ApprovedRecordReaderService
{
    /**
     * @var DataReader\ApprovedRecordReader
     */
    private $approvedRecordReader;

    /**
     * @param DataReader\ApprovedRecordReader $approvedRecordReader
     */
    public function __construct(DataReader\ApprovedRecordReader $approvedRecordReader)
    {
        $this->approvedRecordReader = $approvedRecordReader;
    }

    /**
     * @param Search\AbstractQcStatusRecordSearch | Search\ApprovedRecordSearch $approvedRecordSearch
     *
     * @return DataObject\ApprovedStatusRecord
     */
    public function getItem(Search\AbstractQcStatusRecordSearch $approvedRecordSearch)
    {
        return $this->approvedRecordReader->getItem($approvedRecordSearch);
    }
}
