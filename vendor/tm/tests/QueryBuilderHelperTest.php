<?php
// declare(strict_types=1);

namespace tm\tests;

use PHPUnit\Framework\TestCase;
use tm\helpers\QueryBuilderHelper;

class QueryBuilderHelperTest extends TestCase
{
    private function functionGetArrayOfValues()
    {
        return ["Value1", "Value2", "Value3", "Value4"];
    }

    public function testCreateInParamString()
    {
        
        $values = $this->functionGetArrayOfValues();
        
        $prefix = "p";

        $expectedString = ":p0,:p1,:p2,:p3";
        
        $expectedParamArr = [
            "p0"=>"Value1",
            "p1"=>"Value2",
            "p2"=>"Value3",
            "p3"=>"Value4",
        ];

        list($paramString, $paramsArr) = QueryBuilderHelper::createInParamString($values, $prefix);

        $this->assertEquals($expectedString, $paramString);

        $this->assertSame($expectedParamArr, $paramsArr);
    }

    public function testInCondition()
    {
        list($paramString, $paramsArr) = QueryBuilderHelper::InCondition("testField", $this->functionGetArrayOfValues(), "p");
        
        $expectedParamArr = [
            "p0"=>"Value1",
            "p1"=>"Value2",
            "p2"=>"Value3",
            "p3"=>"Value4",
        ];

        $expectedStr = "testField IN (:p0,:p1,:p2,:p3)";

        $this->assertEquals($expectedStr, $paramString);

        $this->assertSame($expectedParamArr, $paramsArr);

    }
}