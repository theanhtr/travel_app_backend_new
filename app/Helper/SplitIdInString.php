<?php 

namespace App\Helper;
use Illuminate\Support\Facades\Log;

class SplitIdInString {
    public static function splitIdInString(String $idString)
    {
        $array_result = array();
        $idTemp = "";

        for($i = 0; $i < strlen($idString); $i++) {
            if ($idString[$i] == ",") {
                $idNumber = (int)$idTemp;
                $idTemp = "";
                array_push($array_result, $idNumber);
            } else {
                $idTemp .= $idString[$i];
            }
        }

        $idNumber = (int)$idTemp;
        $idTemp = "";
        array_push($array_result, $idNumber);

        return $array_result;
    }
}