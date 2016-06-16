<?php

namespace Base\ProductsQcStats\ReadModel\DataObject;

/**
 * Class ApprovedStatusRecord
 */
class ApprovedStatusRecord
{
    /**
     * @var int
     */
    private $count;

    /**
     * @param int $count
     */
    public function __construct($count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }
}
