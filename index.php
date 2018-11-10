<?php
/**
 * Vehicle Validation Class Document
 *
 * @category Class
 * @package  VersionOne
 * @author   Joshua Malan <mtech801@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://customapplicationdesign.com
 */

ini_set('memory_limit', -1);
ini_set('max_execution_time', 0); //No Limit

require "src/Validation.php";

use RoadVantage\Validation;

// vehicle model years to test
$years = [
    [ "modelyear" => 2003, "suffix1" => 15 ],
    [ "modelyear" => 2004, "suffix1" => 14 ],
    [ "modelyear" => 2005, "suffix1" => 13 ],
    [ "modelyear" => 2006, "suffix1" => 12 ],
    [ "modelyear" => 2007, "suffix1" => 11 ],
    [ "modelyear" => 2008, "suffix1" => 10 ],
    [ "modelyear" => 2009, "suffix1" => 9 ],
    [ "modelyear" => 2010, "suffix1" => 8 ],
    [ "modelyear" => 2011, "suffix1" => 7 ],
    [ "modelyear" => 2012, "suffix1" => 6 ],
    [ "modelyear" => 2013, "suffix1" => 5 ],
    [ "modelyear" => 2014, "suffix1" => 4 ],
    [ "modelyear" => 2015, "suffix1" => 3 ],
    [ "modelyear" => 2016, "suffix1" => 2 ],
    [ "modelyear" => 2017, "suffix1" => 1 ],
    [ "modelyear" => 2018, "suffix1" => 0 ],
    [ "modelyear" => 2019, "suffix1" => 0 ]
];

// Assumed base warranty of the vehicle make being tested. Both makes should be tested
$base_warranty = [
    [ "make" => "BMW", "term" => 36, "miles" => 48000 ],
    [ "make" => "Volkswagen", "term" => 72, "miles" => 100000 ]
];

echo PHP_EOL . PHP_EOL;
echo "Processing......" . PHP_EOL . PHP_EOL;
$ln = 0;

foreach ($base_warranty as $bw) {
    foreach ($years as $year => $yrArr) {
        $miles = 0;
        while ( $miles <= 150000 ) {
            foreach (Validation::getCoveragesFromAPI() as $coverageArr) {
                echo $bw[ "make" ];
                echo "\t" . $yrArr['modelyear'];
                echo "\t" . $miles;
                echo "\t" . Validation::newOrUsedStatus($miles, $bw['miles']);
                echo "\t" . $coverageArr['name'];
                echo "\t" . "suffix1:" . sprintf("%02d", $yrArr['suffix1']);
                echo "\t" . "suffix2:" . Validation::getSuffix2($miles);
                $rs = Validation::getCoverage($yrArr['modelyear'], $miles, $coverageArr['name'], $bw['miles'], $bw['term']);
                echo "\t" .  $rs;
                //echo " EOL" . $ln . "<br>";
                echo PHP_EOL;
                $ln++;
            }
            $miles += 1000;
        }
    }
}