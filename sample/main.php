<?php

require __DIR__ . '/../vendor/autoload.php';

use gan068\MacOsFinderNasFixer;

$path = '.';
$target_time_str = '1984-01-24 16:00:00';
if (isset($argv[1])) {
    $path = $argv[1];
}
if (isset($argv[2])) {
    $target_time_str = $argv[2];
}

date_default_timezone_set('Asia/Taipei');
$fixer = new MacOsFinderNasFixer();
$fixer->setTargetTimeStr($target_time_str);
$fixer->travelDir($path);
