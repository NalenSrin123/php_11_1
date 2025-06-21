<?php
include 'connection.php';
global $con;
    session_start();
    if(isset($_POST['btnSave'])){
        $name=$_POST['name'];
        $qty=$_POST['qty'];
        $price=$_POST['price'];
        $image=date('Y-m-d H-i-s').'_'.$_FILES['image']['name'];
        $tmp_name=$_FILES['image']['tmp_name'];
        $path='./uploads/'.$image;
        move_uploaded_file($tmp_name,$path);
        $email=$_SESSION['is_login'];
        $select_user_id="SELECT `userID` FROM `tbusers` WHERE `email`='$email'";
        $res=$con->query($select_user_id);
        $userID=$res->fetch_assoc()['userID'];
        $insertProduct="INSERT INTO `tbproducts`(`product_name`, `qty`, `price`, `image`, `user_id`) 
        VALUES ('$name','$qty','$price','$image','$userID')";
        $res=$con->query($insertProduct);
        if($res){
            header('Location: index.php');
        }

    }
?>