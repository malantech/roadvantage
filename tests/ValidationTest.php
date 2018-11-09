<?php
use PHPUnit\Framework\TestCase;
use RoadVantage\Validation;

/**
 * 
 */
class ValidationTest extends TestCase
{
    /**
     * Comparing json file with supplied coverage array
     */
    public function testGetCoveragesFromAPI()
    {
        $coverage = array(
            array("name" => "3 Months/3,000 Miles", "terms" => 3, "miles" => 3000),
            array("name" => "6 Months/12,000 Miles", "terms" => 6, "miles" => 12000),
            array("name" => "12 Months/24,000 Miles", "terms" => 12, "miles" => 24000),
            array("name" => "24 Months/30,000 Miles", "terms" => 24, "miles" => 30000),
            array("name" => "24 Months/36,000 Miles", "terms" => 24, "miles" => 36000),
            array("name" => "36 Months/36,000 Miles", "terms" => 36, "miles" => 36000),
            array("name" => "36 Months/45,000 Miles", "terms" => 36, "miles" => 45000),
            array("name" => "36 Months/50,000 Miles", "terms" => 36, "miles" => 50000),
            array("name" => "48 Months/50,000 Miles", "terms" => 48, "miles" => 50000),
            array("name" => "48 Months/60,000 Miles", "terms" => 48, "miles" => 60000),
            array("name" => "60 Months/72,000 Miles", "terms" => 60, "miles" => 72000),
            array("name" => "60 Months/75,000 Miles", "terms" => 60, "miles" => 75000),
            array("name" => "72 Months/100,000 Miles", "terms" => 72, "miles" => 100000),
            array("name" => "84 Months/84,000 Miles", "terms" => 84, "miles" => 84000),
            array("name" => "84 Months/96,000 Miles", "terms" => 84, "miles" => 96000),
            array("name" => "100 Months/100,000 Miles", "terms" => 100, "miles" => 100000),
            array("name" => "100 Months/120,000 Miles", "terms" => 100, "miles" => 120000),
            array("name" => "120 Months/120,000 Miles", "terms" => 120, "miles" => 120000)
        );

        $this->assertEquals($coverage, Validation::getCoveragesFromAPI());
    }

    /**
     * 
     */
    public function testGetIssueMileage()
    {
        $this->assertArrayHasKey("0", Validation::getIssueMileage());
        $this->assertCount(13, Validation::getIssueMileage());
    }

    /**
     * 
     */
    public function testGetAgeInMonths()
    {
        //for ($i = 2003;$i <= 2019;$i++) {
        //    $yrDiff = date("Y")-$i;
        //    $moDiff = $yrDiff*12;
        //    if ($moDiff == -12) {
        //        $moDiff = 12;
        //    }
        //    $this->assertEquals($moDiff, Validation::getAgeInMonths($i));
        //}
        $this->assertEquals(180, Validation::getAgeInMonths(2003));
    }

    /**
     * 
     */
    public function testIsAgeValid()
    {
        $this->assertTrue(Validation::isAgeValid(2016));
        $this->assertFalse(Validation::isAgeValid(2003));
    }

    /**
     * 
     */
    public function testGetSuffix2()
    {
        $this->assertEquals("A", Validation::getSuffix2(0));
    }

    /**
     * 
     */
    public function testNewOrUsedStatus()
    {
        $this->assertEquals("NEW", Validation::newOrUsedStatus(0, 48000));
        $this->assertEquals("USED", Validation::newOrUsedStatus(48001, 48000));
    }

    /**
     * 
     */
    public function testUnderMaxMileage()
    {
        $this->assertTrue(Validation::underMaxMileage(152999));
        $this->assertFalse(Validation::underMaxMileage(153000));
    }

    /**
     * 
     * $currMileage, $coverageName, $baseTerm, $baseMiles
     */
    public function testGetCoverage1()
    {
        $currMileage = 0;
        $coverageName = "3 Months/3,000 Miles";
        $baseTerm = 36;
        $baseMiles = 100000;

        $this->assertEquals("SUCCESS", Validation::getCoverage($currMileage, $coverageName, $baseTerm, $baseMiles));
    }

    /**
     * 
     * $currMileage, $coverageName, $baseTerm, $baseMiles
     */
    public function testGetCoverage2()
    {
        $currMileage = 48000;
        $coverageName = "3 Months/3,000 Miles";
        $baseTerm = 36;
        $baseMiles = 48000;

        $this->assertEquals("SUCCESS", Validation::getCoverage($currMileage, $coverageName, $baseTerm, $baseMiles));
    }
}