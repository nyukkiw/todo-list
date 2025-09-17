<?php
//koneksi ke data base
//host name,username,pass,database name
$conn=mysqli_connect("mysql.railway.internal","root","ZetBrQBgrTZoqDCddVZNVrWPzHvvGVkt","railway");

function query($query){
    global $conn;
    $result = mysqli_query($conn,$query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[]=$row;
    }

    return $rows;

}

function tambah($data){
    global $conn;

    // ambil data dari tiap elemen dalam form
    $id=$_SESSION["user_id"];
    $todos=htmlspecialchars($data["task"]);
    $stat="pending";

      // query insert data
      $query="INSERT INTO todos (user_id, task, status) VALUES('$id','$todos','$stat')";
  
      mysqli_query($conn,"$query");
  
    return mysqli_affected_rows($conn);



}

function hapus($id){
    global $conn;
    $target=$id['todo'];
    $conver="'".implode("','",$target)."'";

    mysqli_query($conn,"DELETE FROM todos WHERE task IN ($conver)");
    return mysqli_affected_rows($conn);

}

function ubah($data){
    global $conn;

  // Ambil semua ID yang dicentang
    $ids = $data['todo']; 
    $conver="'".implode("','",$ids)."'";


    // $result=query("SELECT user_id FROM todos WHERE task IN ($conver)");

    $query="UPDATE todos SET status='done' WHERE task IN ($conver)";

     mysqli_query($conn,"$query");

      // Cek apakah ada baris yang berubah
    return mysqli_affected_rows($conn);

}


function cari($keyword){
    $query="SELECT * FROM mahasiswa WHERE nama LIKE '%$keyword%' OR nim LIKE '%$keyword%' OR email LIKE '%$keyword%' OR jurusan LIKE '%$keyword%' ";

    return query($query);

}


function registrasi($data){
    global $conn;
    $username=strtolower(stripslashes($data["username"]));
    $password=mysqli_real_escape_string($conn,$data["password"]);
    $password2=mysqli_real_escape_string($conn,$data["password2"]);

    // cek apakah username sudah ada atau belum
    $result=mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>
         alert('username yang dipilih sudah terdaftar')
        </script>";
        return false;
    }


    // cek konfirmasi password
    if($password !== $password2){
        echo "<script>
            alert('konfirmasi password tidak sesuai')
        </>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password,PASSWORD_DEFAULT);
    



    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");

    return mysqli_affected_rows($conn);






}






?>