<?php

namespace BaseTest\ProductsQcStats\ReadModel;

use Base\ProductsQcStats\Domain\Model\Seller;
use Base\ProductsQcStats\ReadModel\DataObject;
use Base\ProductsQcStats\ReadModel\Search;

/**
 * Class ImageMissingRecordReaderTest
 */
class ImageMissingRecordReaderTest extends \BaseTest_Db_ProtectedTestCase
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
     * @dataProvider imageMissingRecordDataProvider
     *
     * @param Search\AbstractQcStatusRecordSearch | Search\ImageMissingRecordSearch $imageMissingRecordSearch
     * @param $expectedResult
     */
    public function testImageMissingRecordReaderSuccess(Search\AbstractQcStatusRecordSearch $imageMissingRecordSearch, $expectedResult)
    {
        $reader = $this->getProductQcStatusReaderServiceFactory()->getImageMissingRecordReaderService();

        $actualResult = $reader->getItem($imageMissingRecordSearch);

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @return array
     */
    public function imageMissingRecordDataProvider()
    {
        $searchFactory = $this->getProductQcStatusReaderServiceFactory()->getProductsQcSearchObjectFactory();
        $sellerId = new Seller\SellerId(2909);

        return [
            'Fetching results.' => [
                'imageMissingRecordSearch' => $searchFactory->createNewImageMissingRecordSearch(
                    $sellerId
                ),
                'expectedResult' => new DataObject\ImageMissingStatusRecord(1),
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
