<?php
$lines = file('address_sub_districts_2.txt');

$arr = [];

foreach($lines as $line) {
    array_push($arr, $line);
}

foreach($arr as $ele) {
    $content_left = '';
    $content_right = '';
    $count_left = 0;
    $count_right = 0;
    for($i = 0; $i < strlen($ele); $i++) {
        //left
        if($count_left < 2) {
            $content_left = $content_left . $ele[$i];
        } 

        if($ele[$i] == '\'') {
            $count_left++;
        } 

        //right
        if($count_right < 2) {
            $content_right = $ele[strlen($ele) - 1- $i] . $content_right;
        } 

        if($ele[strlen($ele) - 1- $i] == ',') {
            $count_right++;
        } 
    }
    
    file_put_contents('address_sub_districts_output.txt', $content_left . $content_right, FILE_APPEND);

}
?>