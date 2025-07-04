<?php 
date_default_timezone_set('Asia/Phnom_Penh');
    include 'connection.php';
    global $con;
    $id=$_POST['id'];
    $name=$_POST['name'];
    $price=$_POST['price'];
    $time=$_POST['time'];
    $session=$_POST['session'];
    $image=$_POST['image'];
    $update_at=date('y-m-d H:i:s');
    $update="UPDATE `tb_courses` SET `course_name`='$name',`price`='$price',`times`='$time'
    ,`session`='$session',`image`='$image',`update_at`='$update_at' WHERE `id`='$id'";
    $res=$con->query($update);
    if($res){
        echo $image;
    }
    
?>