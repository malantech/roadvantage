<?php
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
