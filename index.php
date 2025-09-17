<?php
require 'functions.php';
session_start();
// koneksi ke DBMS
// $conn=mysqli_connect("localhost","root","","todo");
$userID=$_SESSION['user_id'];

$todos=query("SELECT * FROM todos WHERE user_id='$userID'");

if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

// cek apakah tombol submit(done) ditekan atau belum
if(isset($_POST["done"])){

  // cek apakah task sudah dicentang atau belum
      if(ubah($_POST)>0){
        echo "<script>
            alert('Data berhasil diubah');
        </script>";
         header("Location: ".$_SERVER['PHP_SELF']);
         exit();
      }else{
        echo "<script>
            alert('Data gagal diubah');
        </script>";
      }
    
}


if(isset($_POST["delete"])){
      if(hapus($_POST)>0){
    echo "<script>
    alert('Data berhasil dihapus');
    document.location.href='index.php';
</script>";
}else{
    echo "<script>
    alert('Data gagal dihapus');
    document.location.href='index.php';
</script>";
}



}



// cek tombol submit sudah ditekan atau belum
if(isset($_POST["add"])){

  
    // cek apakah data berhasil ditambah atau tidak
    if(tambah($_POST)>0){

        echo "<script>
            alert('Data berhasil ditambah');
            document.location.href='index.php';
        </script>";

    }else{

        echo "<script>
            alert('Data gagal ditambahkan');
            document.location.href='index.php';
        </script>";

    }
}



?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style\index-style.css">

    <title>Dashboard</title>
  </head>
  <body>

  
  <a href="logout.php" style="font-size: 20px; padding:1rem;">Logout</a>
 
<!-- todolist -->
<div class="container">
  <div class="row justify-content-center">
  
      <!-- add -->
    <div class="add mb-3 text-center">
        <h1>Todo list</h1>
            <form action="" method="post">
                <label for="task">Add your task:</label>
                <input type="text" name="task" id="task">
                <button type="submit" name="add">ADD</button>
            </form> 
    </div>
    <!-- end add -->

    <!-- list -->
      <form action="" method="POST">
        <div class="d-flex justify-content-center">
    <div class="list-group w-50">
      <?php foreach($todos as $task):?>
      <label class="list-group-item">
    
        <input class="form-check-input me-1" type="checkbox" name="todo[]" value="<?php echo $task['task'];?>">

        <?php if($task['status']==="pending"):?>
          <?php echo $task['task'];?>
        <?php else:?>
          <?php echo '<del>'.$task['task'].'</del>';?>
        <?php endif; ?>
      </label>

      <?php endforeach;?>
 
       <div class="d-flex gap-2 mt-3 justify-content-center">
        <button type="submit" name="done" class="btn btn-success">Done</button>
        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
        </div>
    </div>
    </div>
    </form>
    <!-- list end -->
  </div>
</div>
<!-- end todolist -->


    
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>