<?php
function getBalanceByDate($date, $url){
    //print_r($date);
    $format = 'd.m.Y'; //30.08.2021

    $savedStrategy = file_get_contents($url);
    //$filename = "./logs/".date("Y.m.d_h.i.s");
    //file_put_contents($filename.".json", $savedStrategy);
    $savedStrategyArray = json_decode($savedStrategy, true); //теперь это массив

    foreach ($savedStrategyArray['periods'] as $period){
        $weeksArr = $period['weeks'];

        foreach ($weeksArr as $week){
            $currBalance = $week['balance'];

            //$stringToLog =  "Date ".$week['date']. "   balance: ". $week['balance']. "\n";
            //file_put_contents($filename.".balances", $stringToLog, FILE_APPEND);

            $weekStartDate = DateTime::createFromFormat($format, $week['date']);
            $weekEndDate = clone $weekStartDate;
            $weekEndDate->add(new DateInterval('P6D')); // P1D means a period of 1 day

            if ($date >= $weekStartDate and $date <= $weekEndDate) {
                //Если искомая дата в текущей неделе, значит мы нашли нужную неделю
                return($currBalance);
            }
        }
    }
    return false;
}

$url = 'https://calc.superkopilka.com/export.php?id=310521-1093';
//$url = './logs/2021.08.19_04.19.25.json';
$format2 = 'Y-m-d'; //2021-08-04
$date = DateTime::createFromFormat($format2, "2021-08-30");

echo getBalanceByDate($date, $url);
