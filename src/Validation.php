<?php
/**
 * Vehicle Validation Class Document
 *
 * @category Class
 * @package  VersionOne
 * @author   Joshua Malan <mtech801@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://customapplicationdesign.com *
 */
namespace RoadVantage;

use DateTime;

/**
 * Main validation class
 */
class Validation
{
    public $coverage = [];
    public $issue_mileage = [];
    public $maximum_miles = 153000;

    /**
     * Constructing $coverage array
     */
    public function __construct()
    {
        $this->coverage = $this->getCoveragesFromAPI();
    }

    /**
     * Simulate API JSON payload, convert to array so we
     * can do magic
     * 
     * @return coverage.json file
     */
    public static function getCoveragesFromAPI()
    {
        //simulate API JSON payload, convert to array
        $jsonCoverages = file_get_contents("coverage.json");

        return json_decode($jsonCoverages, true);
    }

    /**
     * Mileage of the vehicle at the time the contract is rated
     * 
     * @return Array
     */
    public static function getIssueMileage()
    {
        $issue_mileage = [
            [ "min" => 0, "max" => 12000, "suffix2" => "A" ],
            [ "min" => 12001, "max" => 24000, "suffix2" => "A" ],
            [ "min" => 24001, "max" => 36000, "suffix2" => "B" ],
            [ "min" => 36001, "max" => 48000, "suffix2" => "C" ],
            [ "min" => 48001, "max" => 60000, "suffix2" => "D" ],
            [ "min" => 60001, "max" => 72000, "suffix2" => "E" ],
            [ "min" => 72001, "max" => 84000, "suffix2" => "F" ],
            [ "min" => 84001, "max" => 96000, "suffix2" => "G" ],
            [ "min" => 96001, "max" => 108000, "suffix2" => "H" ],
            [ "min" => 108001, "max" => 120000, "suffix2" => "I" ],
            [ "min" => 120001, "max" => 132000, "suffix2" => "J" ],
            [ "min" => 132001, "max" => 144000, "suffix2" => "K" ],
            [ "min" => 144001, "max" => 150000, "suffix2" => "L" ]
        ];

        return $issue_mileage;
    }

    /**
     * Get Age in Months of Vehicle
     * 
     * @return age in months from year
     */
    public static function getAgeInMonths($year)
    {
        $myDate = new DateTime($year . "-01-01");
        $myNowDate = new DateTime("2018-01-01");

        $interval = $myDate->diff($myNowDate);

        $ageInMonths = $interval->m + ( $interval->y * 12 );

        return $ageInMonths;
    }

    /**
     * 
     */
    public static function isAgeValid($year)
    {
        if (self::getAgeInMonths($year) > 147) {
            return false;
        }
        return true;
    }

    /**
     * 
     */
    public static function getSuffix2($miles = 0)
    {
        $issue_mileage = self::getIssueMileage();

        foreach ($issue_mileage as $typeVal) {
            if ($miles <= $typeVal['max'] &&  $miles >= $typeVal['min']) {
                $suff2 = $typeVal['suffix2'];
            }
        }

        return $suff2;
    }

    /**
     * 
     */
    public static function newOrUsedStatus($miles, $base_warranty_miles)
    {
        if ($miles < $base_warranty_miles) {
            return "NEW";
        }
        return "USED";
    }

    /**
     * 
     */
    public static function underMaxMileage($mileage)
    {
        if ($mileage < 153000) {
            return true;
        }
        return false;
    }

    /**
     * 
     */
    public static function getCoverage($yr, $currMileage, $coverageName, $bwM, $bwT)
    {
        $coverage = self::getCoveragesFromAPI();
        $age = self::getAgeInMonths($yr);
        //print_r($coverage);
        //exit;
        foreach ($coverage as $c) {
            if ($c['name'] == $coverageName) {
                $coverTotal = $c['miles'] + $currMileage;
                $success = true;
                //check mileage
                if ($coverTotal >= 153000) {
                    $result[] = "Exceeds 153000 before contract expires";
                    $success = false;
                }

                //$coverTotal < $bwM

                //check age
                $chkAge = $age + $c['terms'];
                if ($chkAge > 147) {
                    $result[] = "Age is > than 147 months before contract expires (" . $chkAge . ")";
                    $success = false;
                }

                //check term on coverage
                if ($c['terms'] < $bwT) {
                    $result[] = "Term expires before warranty";
                    $success = false;
                }

                //check miles on coverage
                if ($c['miles'] < $coverTotal) {
                    $result[] = "Miles expires before warranty";
                    $success = false;
                }
                
                if ($success == true) {
                    $rs = "SUCCESS";
                } else {
                    if (is_array($result)) {
                        $resultPrint = implode("','", $result);
                        $rs = "FAILURE: array('" . $resultPrint . "')";
                    } else {
                        $rs = "FAILURE";
                    }
                }
                //$rs .= "\nAge(" . $yr . "): " . $age . "\n" . $c['name'] . "\n" . $coverageName . "\n\n";
                //$rs .= " TTL M: " . $coverTotal . " TTL TERMS: " . $c['terms'] . "<" . $baseTerm . "<br>";
                return $rs;
            }
        }
    }
}