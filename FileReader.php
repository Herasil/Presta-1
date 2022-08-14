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
?>