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
    if(isset($_POST['delete'])){
        $id=$_POST['delete_id'];
        $delete="DELETE FROM `tbproducts` WHERE `product_id`='$id'";
        $exe=$con->query($delete);
        if($exe){
             header('Location: index.php');
        }
    }
    if(isset($_POST['btnEdit'])){
        date_default_timezone_set('Asia/Phnom_Penh');
        $id=$_POST['hide_id'];
        $name=$_POST['name'];
        $qty=$_POST['qty'];
        $price=$_POST['price'];
        $user_id=$_POST['user_id'];
        $update_at=date('y-m-d H:i:s');
        if(empty($_FILES['image']['name'])){
            $image=$_POST['old_image'];
        }else{
            $image=date('Y-m-d H-i-s').'_'.$_FILES['image']['name'];
            $tmp_name=$_FILES['image']['tmp_name'];
            $path='./uploads/'.$image;
            move_uploaded_file($tmp_name,$path);
        }
        $update="UPDATE `tbproducts` SET `product_name`='$name',`qty`='$qty',`price`='$price',
        `image`='$image',`user_id`='$user_id',`update_at`='$update_at' WHERE `product_id`='$id'";
        global $con;
        if($con->query($update)){
            header('Location: index.php');
        }
    }
?>