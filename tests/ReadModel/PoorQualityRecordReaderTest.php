<?php

namespace BaseTest\ProductsQcStats\ReadModel;

use Base\ProductsQcStats\Domain\Model\Seller;
use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\Search;

/**
 * Class PoorQualityRecordReaderTest
 */
class PoorQualityRecordReaderTest extends \BaseTest_Db_ProtectedTestCase
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
     * @dataProvider rejectedPoorQualityStatsRecordDataProvider
     *
     * @param Search\AbstractQcStatusRecordSearch | Search\PoorQualityRecordSearch $poorQualityRecordSearch
     * @param $expectedResult
     */
    public function testRejectedPoorQualityStatsRecordReaderSuccess(Search\AbstractQcStatusRecordSearch $poorQualityRecordSearch, $expectedResult)
    {
        $reader = $this->getProductQcStatusReaderServiceFactory()->getPoorQualityRecordReaderService();

        $actualResult = $reader->getItem($poorQualityRecordSearch);

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @return array
     */
    public function rejectedPoorQualityStatsRecordDataProvider()
    {
        $searchFactory = $this->getProductQcStatusReaderServiceFactory()->getProductsQcSearchObjectFactory();
        $sellerId = new Seller\SellerId(2909);

        return [
            'Fetching results.' => [
                'poorQualityRecordSearch' => $searchFactory->createNewRejectedPoorQualityRecordSearch(
                    $sellerId
                ),
                'expectedResult' => new DataObject\PoorQualityStatusRecord(1),
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
