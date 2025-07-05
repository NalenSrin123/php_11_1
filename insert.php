<?php 
    include 'connection.php';
    global $con;
    $name=$_POST['name'];
    $price=$_POST['price'];
    $time=$_POST['time'];
    $session=$_POST['session'];
    $image=$_POST['image'];
    $insert="INSERT INTO `tb_courses`(`course_name`, `price`, `times`, `session`, `image`) 
    VALUES ('$name','$price','$time','$session','$image')";
    $con->query($insert);
    $select_id="SELECT `id` FROM `tb_courses` ORDER BY `id` DESC LIMIT 1";
    $id=$con->query($select_id)->fetch_assoc()['id'];
    echo $id;
?>