<?php
    define('DB_HOST','localhost'); 
    define('DB_USER','root'); 
    define('DB_PASS',''); 
    define('DB_NAME','bd_empresa');

    try{
        $connect = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }catch(PDOException $e){
        exit('Error: '. $e->getMessage());
    }
?>