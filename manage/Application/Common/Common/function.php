<?php 
function getNodeTree($arr,$pid=0){
    static $result = array();
    foreach($arr as $value){
        if ($value['pid'] == $pid){
            $result[] = $value;
            getNodeTree($arr,$value['mid']);
        }
    }
    return $result;
}

?>