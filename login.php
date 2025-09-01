<?php

require 'functions.php';
session_start();


// cek cookie
if(isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
    $id=$_COOKIE['id'];
    $key=$_COOKIE['key'];
    $_SESSION['user_id']=$id;

    // ambil username berdasarkan id
    $result =mysqli_query($conn,"SELECT username FROM users WHERE id=$id ");
    $row=mysqli_fetch_assoc($result);

    // cek cookie dan username 
    if($key===hash('sha256',$row['username']) ){
        $_SESSION['login']=true;
    }
   
}


if(isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}



if(isset($_POST["login"])){
    $username=$_POST["username"];
    $password=$_POST["password"];
    
    $result=mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    
    // cek username
    if(mysqli_num_rows($result) === 1 ){

        // cek password
        $row=mysqli_fetch_assoc($result);

        if(password_verify($password,$row["password"])){

            // set session 
            $_SESSION["login"]=true;
            $_SESSION["user_id"]=$row['id'];

            // cek remember me
            if(isset($_POST["remember"])){
                // buat cookie
                
                setcookie('id',$row['id'],time()+60);
                
                setcookie('key',hash('sha256',$row['username']),time()+(60*60*24*3));



            }

            header("Location: index.php");
            exit;
        }

    }

    $error=true;


}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="style\style.css">

  <title>Login</title>
</head>
<body>

  <!-- login -->
  <div class="container-login">

        <form action="" method="post">    
          <h1>Login</h1>
            
          <?php if(isset($error)):?>

          <p style="color:red; font-style:italic;">Username atau password salah</p>

            <?php endif;?>
           <div class="content">
            <label for="">Silahkan register terlebih dahulu jika belum</label>
            <a href="registrasi.php">REGISTRASI</a>
            </div>

           <div class="content">
            <label for="username">Username: </label>
            <input type="text" name="username" id="username">
            </div>

            <div class="content">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password">
            </div>

            <div class="content">
              <input type="checkbox" name="remember" id="remember">
                 <label for="remember">Remember me:</label>
            </div>

            <button type="submit" name="login">Login</button>
     
        </form>
    

  </div>
  <!-- end login -->




  
</body>
</html>