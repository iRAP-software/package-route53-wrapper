<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../src/Route53Client.php');
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/settings.php');

$classDirs = array(__DIR__, __DIR__ . '/tests');
$autoloader = new \iRAP\Autoloader\Autoloader($classDirs);


$testFiles = \iRAP\CoreLibs\Filesystem::getDirContents(__DIR__ . '/tests');
$region = \iRAP\Route53Wrapper\Objects\AwsRegion::create_EU_W1();
$client = new \iRAP\Route53Wrapper\Route53Client(AWS_KEY, AWS_SECRET, $region);

foreach ($testFiles as $testFile)
{
    $testFile = basename($testFile);
    $nameOfTest = substr($testFile, 0, -4); // remove .php extension
    $test = new $nameOfTest($client);
    $test->run();
}
