<?php
include "connect.php";
$jenismenu = isset($_POST['jenismenu']) ? htmlentities($_POST['jenismenu']) : "";
$katmenu = isset($_POST['katmenu']) ? htmlentities($_POST['katmenu']) : "";

if (!empty($_POST['input_katmenu_validate'])) {
    $select = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");

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