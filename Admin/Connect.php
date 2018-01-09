<?php

$dsn = 'mysql:host=localhost;dbname=shop';
$user = 'root';
$pass = '';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND =>'set names utf8' ,   
    
);

    try {
        $con = new PDO($dsn, $user, $pass, $option);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
  }
    catch (PDOException $e){
            ECHO 'FAILED TO CONNECT' . $e->getmessage();
  }
        
        ?>
        