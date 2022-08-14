<?php
declare(strict_types=1);
require_once('./Services/Printer.php');
require_once('./Services/AssociativeArrayParser.php');
require_once('./Services/FileReader.php');

print_r("Įveskite failo pavadinimą:");
$handle = fopen("php://stdin", "r");
$line = fgets($handle);

$reader =  new FileReader();
$parser =  new AssociativeArrayParser();
$printer = new Printer();

$totalVariablesCount = sizeof($parser->getFileDataArray($reader->getDataFromFile($line))) / sizeof($parser->getHeader($reader->getDataFromFile($line)));

$printer->printDataArrayTable($parser->getFileDataArray($reader->getDataFromFile($line)), $totalVariablesCount);
?>