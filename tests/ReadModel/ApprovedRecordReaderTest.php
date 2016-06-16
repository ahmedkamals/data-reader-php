<?php

namespace BaseTest\ProductsQcStats\ReadModel;

use Base\ProductsQcStats\Domain\Model\Seller;
use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\Search;

/**
 * Class ApprovedRecordReaderTest
 */
class ApprovedRecordReaderTest extends \BaseTest_Db_ProtectedTestCase
{
    /**
     * @return \PHPUnit_Extensions_Database_DataSet_MysqlXmlDataSet
     */
    public static function getClassDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_MysqlXmlDataSet(
            static::getDataPath(
                'dumps/Base/ProductsQcStats/quality-control-fixture.xml'
            )
        );
    }

    /**
     * @dataProvider approvedStatsRecordDataProvider
     *
     * @param Search\AbstractQcStatusRecordSearch | Search\ApprovedRecordSearch $searchRecord
     * @param array $expectedResult
     */
    public function testApprovedStatsRecordSuccess(Search\AbstractQcStatusRecordSearch $searchRecord, $expectedResult)
    {
        $reader = $this->getProductQcStatusReaderServiceFactory()->getApprovedRecordReaderService();

        $actualResult = $reader->getItem($searchRecord);

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @return array
     */
    public function approvedStatsRecordDataProvider()
    {
        $searchFactory = $this->getProductQcStatusReaderServiceFactory()->getProductsQcSearchObjectFactory();
        $sellerId = new Seller\SellerId(2909);

        return [
            'Fetching results.' => [
                'searchRecord' => $searchFactory->createNewApprovedRecordSearch(
                    $sellerId
                ),
                'expectedResult' => new DataObject\ApprovedStatusRecord(2),
            ],
        ];
    }

    /**
     * @return \Default_Service_ReaderServiceFactory
     */
    private function getProductQcStatusReaderServiceFactory()
    {
        return new \Default_Service_ReaderServiceFactory();
    }
}
