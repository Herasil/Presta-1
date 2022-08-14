<?php
print_r("Įveskite failo pavadinimą:");
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
$myfile = fopen(trim($line), "r") or die("Nepavyko atidaryti failo!");
$file = fread($myfile,filesize(trim($line)));

$searchForSymbols = array("array", "(", ")", "'","\r\n",";"," ");
$rawParsedDataFromFile = explode(',',str_replace($searchForSymbols, '', $file));
unset($rawParsedDataFromFile[sizeof($rawParsedDataFromFile)-1]);
//print_r($rawParsedDataFromFile);







function getHeader(): array {
    $arrHeader = [];
    foreach($rawParsedDataFromFile as $item){
        $singleParsedDataLine = explode('=>',$item);
        array_push($arrHeader,$singleParsedDataLine[0]);
    }
    unset($arrHeader[sizeof($arrHeader)-1]);
    $headerFull = array_unique($arrHeader);
    return $headerFull;
}

function getFileDataArray(): array {
    $sortedWholeFileArray = [];

    foreach($headerFull as $it){
        array_push($sortedWholeFileArray,$it);
        foreach($rawParsedDataFromFile as $item){
            $singleParsedDataLine = explode('=>',$item);
            if($singleParsedDataLine[0]==$it){
            array_push($sortedWholeFileArray,$singleParsedDataLine[1]);
            }
        }
    }
    return $sortedWholeFileArray;
}




?>