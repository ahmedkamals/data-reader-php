<?php

namespace Base\ProductsQcStats\ReadModel\Search;

use Base\ProductsQcStats\Domain\Model\Seller\SellerId;

/**
 * Class AbstractQcStatusRecordSearch
 */
abstract class AbstractQcStatusRecordSearch
{
    /**
     * @var SellerId
     */
    private $sellerId;

    /**
     * @param SellerId $sellerId
     */
    public function __construct(SellerId $sellerId)
    {
        $this->sellerId = $sellerId;
    }

    /**
     * @return SellerId
     */
    public function getSellerId()
    {
        return $this->sellerId;
    }
}
