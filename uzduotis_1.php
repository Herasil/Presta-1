<?php

use function PHPSTORM_META\type;

print_r("Įveskite failo pavadinimą:");
$handle = fopen("php://stdin", "r");
$line = fgets($handle);
$myfile = fopen(trim($line), "r") or die("Nepavyko atidaryti failo!");
$file = fread($myfile, filesize(trim($line)));
$searchForSymbols = array("array", "(", ")", "'", "\r\n", ";", " ");
$rawParsedDataFromFile = explode(',', str_replace($searchForSymbols, '', $file));
unset($rawParsedDataFromFile[sizeof($rawParsedDataFromFile) - 1]);

$totalVariablesCount = sizeof(getFileDataArray($rawParsedDataFromFile)) / sizeof(getHeader($rawParsedDataFromFile));

printDataArrayTable(getFileDataArray($rawParsedDataFromFile), $totalVariablesCount);


function getHeader($rawParsedDataFromFile): array
{
    $arrHeader = [];
    foreach ($rawParsedDataFromFile as $item) {
        $singleParsedDataLine = explode('=>', $item);
        array_push($arrHeader, $singleParsedDataLine[0]);
    }
    unset($arrHeader[sizeof($arrHeader) - 1]);
    $headerFull = array_unique($arrHeader);
    return $headerFull;
}

function getFileDataArray($rawParsedDataFromFile): array
{
    $sortedWholeFileArray = [];

    foreach (getHeader($rawParsedDataFromFile) as $it) {
        array_push($sortedWholeFileArray, $it);
        foreach ($rawParsedDataFromFile as $item) {
            $singleParsedDataLine = explode('=>', $item);
            if ($singleParsedDataLine[0] == $it) {
                array_push($sortedWholeFileArray, $singleParsedDataLine[1]);
            }
        }
    }
    return $sortedWholeFileArray;
}

function printDataArrayTable($sortedWholeFileArray, $totalVariablesCount): void
{
    $variablesCheckCount = 0;
    print_r("+------------+-------+---------+---------+\n");
    print_r("| ");
    for ($i = 0; $i <= sizeof($sortedWholeFileArray) + 2; $i += $totalVariablesCount) {
        if ($variablesCheckCount == $totalVariablesCount) {
            $i -= sizeof($sortedWholeFileArray) - 1;
            $variablesCheckCount = 0;
            print_r("\n| ");
        }
        print_r($sortedWholeFileArray[$i]);
        print_r(" | ");
        if ($i == sizeof($sortedWholeFileArray) - $totalVariablesCount) {
            print_r("\n+------------+-------+---------+---------+");
        }
        $variablesCheckCount++;
    }
    print_r("\n+------------+-------+---------+---------+\n");
}

function getDataFromFile(){}
