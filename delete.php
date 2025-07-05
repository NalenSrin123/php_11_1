<?php 
include './connection.php';
global $con;
    $id=$_POST['delete_id'];
    $delete="UPDATE `tb_courses` SET `status`=0 WHERE `id`='$id'";
    $result=$con->query($delete);
    if($result){
        echo 'Success';
    }
?>