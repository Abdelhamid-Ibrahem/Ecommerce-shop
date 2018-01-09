<?php
function lang ($phrase){
    static $lang=array(
    "message"=>'welcome in arabic',
    "admin"=>'arabic admin'  
    );
    return $lang[$phrase];
    
    }

?>