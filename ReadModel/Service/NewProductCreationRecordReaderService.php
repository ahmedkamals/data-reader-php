<?php

namespace Base\ProductsQcStats\ReadModel\Service;

use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\DataReader;
use Base\ProductsQcStats\ReadModel\Search;

/**
 * Class NewProductCreationRecordReaderService
 */
class NewProductCreationRecordReaderService
{
    /**
     * @var DataReader\NewProductCreationRecordReader
     */
    private $newProductCreationRecordReader;

    /**
     * @param DataReader\NewProductCreationRecordReader $newProductCreationRecordReader
     */
    public function __construct(DataReader\NewProductCreationRecordReader $newProductCreationRecordReader)
    {
        $this->newProductCreationRecordReader = $newProductCreationRecordReader;
    }

    /**
     * @param Search\AbstractQcStatusRecordSearch | Search\NewProductCreationRecordSearch $newProductCreationRecordSearch
     *
     * @return DataObject\NewProductCreationRecord
     */
    public function getItem(Search\AbstractQcStatusRecordSearch $newProductCreationRecordSearch)
    {
        return $this->newProductCreationRecordReader->getItem($newProductCreationRecordSearch);
    }
}
