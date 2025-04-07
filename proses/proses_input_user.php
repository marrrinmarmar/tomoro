<?php
include "connect.php";
$name = isset($_POST['nama']) ? htmlentities($_POST['nama']) : "";
$username = isset($_POST['username']) ? htmlentities($_POST['username']) : "";
$level = isset($_POST['level']) ? htmlentities($_POST['level']) : "";
$nohp = isset($_POST['nohp']) ? htmlentities($_POST['nohp']) : "";
$alamat = isset($_POST['alamat']) ? htmlentities($_POST['alamat']) : "";
$password = isset($_POST['password']) ? md5(htmlentities($_POST['password'])) : "";

if (!empty($_POST['input_user_validate'])) {
    $selectt = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");

    if(mysqli_num_rows($select) > 0){
        $message = '<script>alert("USERNAME yang dimasukkan telah ada");
        window.location="../user"
        </script>';
    }else{
        $query = mysqli_query($conn, "INSERT INTO tb_user (nama, username, level, nohp, alamat, password) 
    VALUES ('$nama', '$username', '$level', '$nohp', '$alamat', '$password')");
    if($query){
        $message = '<script>alert("data berhasil masuk");
        window.location="../user"
        </script>';
    }else{
        $message = '<script>alert("data gagal masuk");</script>';
    }}
    echo $message;
}
?>
