<?php

declare(strict_types=1);

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
?>