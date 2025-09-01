<?php
require 'functions.php';

if(isset($_POST["registrasi"])){
    if(registrasi($_POST)>0){
        echo " <script> alert('user baru berhasil ditambahkan')</script> ";
        header("Location: login.php");
        exit;
        
    }else{
        echo mysqli_error($conn);
    }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="style\style.css">

  <title>Registrasi</title>
</head>
<body>

  <!-- login -->
  <div class="container-login">

        <form action="" method="post">    
          <h1>Registrasi</h1>

           <div class="content">
            <label for="username">Username: </label>
            <input type="text" name="username" id="username">
            </div>

            <div class="content">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password">
            </div>

            <div class="content">
            <label for="password2">Konfirmasi password: </label>
            <input type="password" name="password2" id="password2">
            </div>

            <button type="submit" name="registrasi">Registrasi</button>

            
        </form>
    

  </div>
  <!-- end login -->




  
</body>
</html>