<?php
include "connect.php";
session_start();
$kode_order = isset($_POST['kode-order']) ? htmlentities($_POST['kode-order']) : "";
$meja = isset($_POST['meja']) ? htmlentities($_POST['meja']) : "";
$pelanggan = isset($_POST['pelanggan']) ? htmlentities($_POST['pelanggan']) : "";
$pelayan = $_SESSION['id_decafe']; // pastikan ini diset saat login
$status = "pending"; // atau status default lainnya
$waktu_order = date("Y-m-d H:i:s");


if (!empty($_POST['input_order_validate'])) {
    $select = mysqli_query($conn, "SELECT * FROM tb_order WHERE kode_order = $kode_order");

    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Kode Order yang dimasukkan telah ada");
        window.location="../order";
        </script>';
    } else {
        $query = mysqli_query($conn, "INSERT INTO tb_order (kode_order, meja, pelanggan, pelayan, status, waktu_order) 
        VALUES ('$kode_order', '$meja', '$pelanggan', '$pelayan', '$status', '$waktu_order')");
        
        if ($query) {
            $message = '<script>alert("Data berhasil masuk");
            ../?x=orderitem&order='.$kode_order.'"</script>';
        } else {
            $message = '<script>alert("Data gagal masuk: '.mysqli_error($conn).'");
            window.location="../order";
            </script>';
        }
    }
    echo $message;
}
?>
