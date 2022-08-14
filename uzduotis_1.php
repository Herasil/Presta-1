<?php

declare(strict_types=1);

class FileReader
{
    public function getDataFromFile(string $line): array
    {
        $myfile = fopen(trim($line), "r") or die("Nepavyko atidaryti failo!");
        $file = fread($myfile, filesize(trim($line)));
        $searchForSymbols = array("array", "(", ")", "'", "\r\n", ";", " ");
        $rawParsedDataFromFile = explode(',', str_replace($searchForSymbols, '', $file));
        unset($rawParsedDataFromFile[sizeof($rawParsedDataFromFile) - 1]);

        return $rawParsedDataFromFile;
    }
}

class AssociativeArrayParser
{
    public function getHeader(array $rawParsedDataFromFile): array
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

    public function getFileDataArray(array $rawParsedDataFromFile): array
    {
        $sortedWholeFileArray = [];
        foreach ($this->getHeader($rawParsedDataFromFile) as $it) {
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
}

class Printer
{
    public function printDataArrayTable(array $sortedWholeFileArray, int $totalVariablesCount): void
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
}

print_r("Įveskite failo pavadinimą:");
$handle = fopen("php://stdin", "r");
$line = fgets($handle);

$reader =  new FileReader();
$parser =  new AssociativeArrayParser();
$printer = new Printer();

$totalVariablesCount = sizeof($parser->getFileDataArray($reader->getDataFromFile($line))) / sizeof($parser->getHeader($reader->getDataFromFile($line)));

$printer->printDataArrayTable($parser->getFileDataArray($reader->getDataFromFile($line)), $totalVariablesCount);
?>