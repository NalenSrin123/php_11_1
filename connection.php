<?php 
    try{
        $con=new mysqli('localhost','root','','db_php_11_1_ajax',3308);
    }catch(Exception $e){
        echo 'Connection failed :'.$e;
    }
?>