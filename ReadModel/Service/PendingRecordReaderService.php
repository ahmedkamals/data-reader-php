<?php

namespace Base\ProductsQcStats\ReadModel\Service;

use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\DataReader;
use Base\ProductsQcStats\ReadModel\Search;

/**
 * Class PendingRecordReaderService
 */
class PendingRecordReaderService
{
    /**
     * @var DataReader\PendingRecordReader
     */
    private $pendingRecordReader;

    /**
     * @param DataReader\PendingRecordReader $pendingRecordReader
     */
    public function __construct(DataReader\PendingRecordReader $pendingRecordReader)
    {
        $this->pendingRecordReader = $pendingRecordReader;
    }

    /**
     * @param Search\AbstractQcStatusRecordSearch | Search\PendingRecordSearch $pendingRecordSearch
     *
     * @return DataObject\PendingStatusRecord
     */
    public function getItem(Search\AbstractQcStatusRecordSearch $pendingRecordSearch)
    {
        return $this->pendingRecordReader->getItem($pendingRecordSearch);
    }
}
