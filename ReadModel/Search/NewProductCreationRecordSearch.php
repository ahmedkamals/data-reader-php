<?php

namespace Base\ProductsQcStats\ReadModel\Search;

use Base\ProductsQcStats\Domain\Model\Seller\SellerId;

/**
 * Class NewProductCreationRecordSearch
 */
class NewProductCreationRecordSearch extends AbstractQcStatusRecordSearch
{
    /**
     * @var \DatePeriod
     */
    private $period;

    /**
     * @param SellerId $sellerId
     * @param \DatePeriod $period
     */
    public function __construct(SellerId $sellerId, \DatePeriod $period)
    {
        parent::__construct($sellerId);
        $this->period = $period;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStart()
    {
        return $this->period->start;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEnd()
    {
        return $this->period->end;
    }
}
