<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login</title>
</head>
<style>
    form{
        width: 400px;
        padding: 30px;
        border-radius: 10px;
        margin: 70px auto;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        
    }
</style>
<body>
    <form action="" method="post" >
        <h2 class="text-center">Login</h2>
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group mt-2 d-flex justify-content-center">
            <a href="register.php">Create an account?</a>
        </div>
        <div class="form-group mt-3 ">
            <button class="btn btn-primary w-100">Login</button>
        </div>
    </form>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
session_start();
    include 'connection.php';
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $email=$_POST['email'];
        $pass=$_POST['password'];
        global $con;
        $select="SELECT `email`, `password` FROM `tbusers` WHERE `email`='$email' AND `password` ='$pass' ";
        $res=$con->query($select);
        if($res->num_rows>0){
            $_SESSION['is_login']=$email;
            header('location: index.php');
        }else{
            echo '
                <script>
                    Swal.fire({
                        title: "Error!",
                        text: "Invalid email or password!",
                        icon: "error"
                    });
                </script>
            ';
        }

    }
?>