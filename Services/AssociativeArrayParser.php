<?php

declare(strict_types=1);

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
?>