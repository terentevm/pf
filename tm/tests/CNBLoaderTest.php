<?php
/**
 * Created by PhpStorm.
 * User: zaich
 * Date: 13.04.2019
 * Time: 21:04
 */

namespace tm\tests;

use tm\rates\CNBLoader;
use tm\rates\RateData;
use tm\rates\RatesLoaderException;
use PHPUnit\Framework\TestCase;

class CNBLoaderTest extends TestCase
{
    private $loader;

    protected function setUp()
    {
        $this->loader = new CNBLoader();
    }

    protected function tearDown()
    {
        $this->loader = NULL;
    }

    /**
     * @dataProvider loadDataProvider
     */
    public function testLoad($code, $date1, $date2)
    {
        $result = $this->loader->load($code, $date1, $date2);
        $this->assertInstanceOf(RateData::class, $result);
    }

    public function loadDataProvider()
    {
        return [
            ['RUB', '2019-01-01', '2019-01-15'],
            ['USD', '2019-01-01', '2019-01-15'],
            ['EUR', '2019-01-01', '2019-01-15']
        ];
    }

    /**
     * @expectedException tm\rates\RatesLoaderException
     */
    public function testInitFakeConfig()
    {
        $result = $this->loader->load('RUB', '2019-03-01', '2019-01-15');
    }


}
