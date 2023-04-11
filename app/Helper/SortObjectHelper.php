<?php 

namespace App\Helper;
use Illuminate\Support\Facades\Log;

class SortObjectHelper {
    public static function sortObjectHelper($array_input, $property, $reverse = false)
    {
        $is_sort = false;
        
        while(!$is_sort) {
            $is_sort = true;

            for($i = 0; $i < count($array_input) - 1; $i ++) {
                if(($array_input[$i][$property] > $array_input[$i + 1][$property]) xor $reverse) {
                    $temp = $array_input[$i + 1];
                    $array_input[$i + 1] = $array_input[$i];
                    $array_input[$i] = $temp;
                    $is_sort = false;
                }
            }
        }

        return $array_input;
    }
}