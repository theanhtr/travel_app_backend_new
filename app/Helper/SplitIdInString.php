<?php 

namespace App\Helper;
use Illuminate\Support\Facades\Log;

class SplitIdInString {
    public static function splitIdInString($idString)
    {
        if(!$idString) {
            return [];
        }

        $array_temp = array();
        $idTemp = "";

        for($i = 0; $i < strlen($idString); $i++) {
            if ($idString[$i] == ",") {
                $idNumber = (int)$idTemp;
                $idTemp = "";

                if($idNumber != 0) 
                array_push($array_temp, $idNumber);
            } else {
                $idTemp .= $idString[$i];
            }
        }

        $idNumber = (int)$idTemp;

        if($idNumber != 0) 
        array_push($array_temp, $idNumber);

        $array_result = array_unique($array_temp);
        return $array_result;
    }
}