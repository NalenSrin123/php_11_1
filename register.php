<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Register</title>
</head>
<style>
    form{
        width: 450px;
        padding: 30px;
        border-radius: 10px;
        margin: 50px auto;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }
</style>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <h2 class="text-center">Register</h2>
        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="profile" class="form-label">Profile</label>
            <input type="file" name="profile" id="profile" class="form-control">
        </div>
        <div class="form-group mt-2 d-flex justify-content-center">
            <a href="login.php">Already have account?</a>
        </div>
        <div class="form-group mt-3 ">
            <button class="btn btn-primary w-100">Register</button>
        </div>
    </form>
</body>
</html>
<?php 
include 'connection.php';
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        global $con;
        if(empty($_FILES['profile']['name'])){
           $insert="INSERT INTO `tbusers`( `userName`, `email`, `password`)
            VALUES ('$name','$email','$password')";
            $con->query($insert);
        }else{
            $profile=date('y-m-d_h-i-s').'_'.$_FILES['profile']['name'];
            $tmp_name=$_FILES['profile']['tmp_name'];
            $path='./uploads/'.$profile;
            move_uploaded_file($tmp_name,$path);
            $insert="INSERT INTO `tbusers`( `userName`, `email`, `password`, `profile`) 
            VALUES ('$name','$email','$password','$profile')";
            $con->query($insert);
        }
        header('location: login.php');
    }
?>