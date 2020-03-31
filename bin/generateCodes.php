<?php

require 'bootstrap.php';

use App\Utils\Command\ParamsRecognizer;
use App\Service\Generator\CodesGenerator;
use App\Service\Generator\GenerateStrategies\AlphaNumericCodesGenerator;


// read parameters
$params = ParamsRecognizer::recognize($argv);
$numberOfCodes = intval(($params['numberOfCodes'] ?? null));
$lengthOfCode  = intval(($params['lengthOfCode'] ?? null));
$file  = filter_var(($params['file'] ?? null), FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

// verify
$errors = [];
if ($numberOfCodes <= 0 && $numberOfCodes <= CodesGenerator::MAX_COUNT) {
    $errors[] = 'Number of codes (numberOfCodes) should be greather then 0 and lower then ' . CodesGenerator::MAX_COUNT . '.';
}
if ($lengthOfCode <= 0 && $lengthOfCode <= CodesGenerator::MAX_LENGTH) {
    $errors[] = 'Number of codes (lengthOfCode) should be greather then 0 and lower then ' . CodesGenerator::MAX_LENGTH . '.';
}
if (!$file) {
    $errors[] = 'File path (file) is required';
}

if (!empty($errors)) {
    echo "Errors:\r\n" . implode("\r\n", $errors);
    die;
}

// process
$memoryStart = memory_get_usage();
$timeStart = microtime(true);

$generatorHandler = new CodesGenerator($numberOfCodes, $lengthOfCode, $file, new AlphaNumericCodesGenerator());
try {
    $generatorHandler->generate();
} catch (\InvalidArgumentException $ex) {
    echo "Error:\r\n" . $ex->getMessage();
    die;
}
$generatorHandler->saveToFile();

$memoryDiff = (memory_get_usage() - $memoryStart) / 1024 / 1024;
$timeDiff = (microtime(true) - $timeStart);

// result
echo 'Finish! (memory: ' . number_format($memoryDiff, 4) . 'MB, time: ' . number_format($timeDiff, 4) . 's)';
