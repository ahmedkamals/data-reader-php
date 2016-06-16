<?php

namespace BaseTest\ProductsQcStats\ReadModel;

use Base\ProductsQcStats\Domain\Model\Seller;
use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\Search;

/**
 * Class NewProductCreationRecordReaderTest
 */
class NewProductCreationRecordReaderTest extends \BaseTest_Db_ProtectedTestCase
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
     * @dataProvider newProductCreationRecordDataProvider
     *
     * @param Search\AbstractQcStatusRecordSearch | Search\NewProductCreationRecordSearch $newProductCreationRecordSearch
     * @param $expectedResult
     */
    public function testImageMissingRecordReaderSuccess(Search\AbstractQcStatusRecordSearch $newProductCreationRecordSearch, $expectedResult)
    {
        $reader = $this->getProductQcStatusReaderServiceFactory()->getNewProductCreationRecordReaderService();

        $actualResult = $reader->getItem($newProductCreationRecordSearch);

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @return array
     */
    public function newProductCreationRecordDataProvider()
    {
        $searchFactory = $this->getProductQcStatusReaderServiceFactory()->getProductsQcSearchObjectFactory();
        $sellerId = new Seller\SellerId(2909);

        return [
            'Fetching results results for the exact 14 days..' => [
                'newProductCreationRecordSearch' => $searchFactory->createNewProductCreationRecordSearch(
                    $sellerId,
                    new \DatePeriod(
                        new \DateTimeImmutable('2016-03-01'),
                        new \DateInterval('P14D'),
                        new \DateTimeImmutable('2016-03-15')
                    )
                ),
                'expectedResult' => new DataObject\NewProductCreationRecord(1),
            ],
            'Fetching results for overlapped 14 days.' => [
                'newProductCreationRecordSearch' => $searchFactory->createNewProductCreationRecordSearch(
                    $sellerId,
                    new \DatePeriod(
                        new \DateTimeImmutable('2016-03-02'),
                        new \DateInterval('P14D'),
                        new \DateTimeImmutable('2016-03-16')
                    )
                ),
                'expectedResult' => new DataObject\NewProductCreationRecord(1),
            ],
            'No results when out of range.' => [
                'newProductCreationRecordSearch' => $searchFactory->createNewProductCreationRecordSearch(
                    $sellerId,
                    new \DatePeriod(
                        new \DateTimeImmutable('2016-03-17'),
                        new \DateInterval('P14D'),
                        new \DateTimeImmutable('2016-03-31')
                    )
                ),
                'expectedResult' => new DataObject\NewProductCreationRecord(0),
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
