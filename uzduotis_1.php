<?php
print_r("Įveskite failo pavadinimą:");
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
$myfile = fopen(trim($line), "r") or die("Nepavyko atidaryti failo!");
$file = fread($myfile,filesize(trim($line)));

$searchForSymbols = array("array", "(", ")", "'","\r\n",";"," ");
$rawParsedDataFromFile = explode(',',str_replace($searchForSymbols, '', $file));
print_r($rawParsedDataFromFile);

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






?>