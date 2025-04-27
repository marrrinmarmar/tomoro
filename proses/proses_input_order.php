<?php
include "connect.php";
session_start();

// Ambil data dari form
$kode_order = isset($_POST['kode-order']) ? htmlentities($_POST['kode-order']) : "";
$meja = isset($_POST['meja']) ? htmlentities($_POST['meja']) : "";
$pelanggan = isset($_POST['pelanggan']) ? htmlentities($_POST['pelanggan']) : "";
$pelayan = $_SESSION['id_decafe'];
$status = "pending";
$waktu_order = date("Y-m-d H:i:s");

// Pastikan form dikirim
if (!empty($_POST['input_order_validate'])) {
    // Cek kalau KODE_ORDER sudah ada
    $select = mysqli_query($conn, "SELECT * FROM tb_order WHERE kode_order = '$kode_order'");

    if (mysqli_num_rows($select) > 0) {
        // Kalau ada, tolak
        echo '<script>alert("Kode Order yang dimasukkan telah ada"); window.location="../order";</script>';
    } else {
        // Kalau belum ada, INSERT
        $query = mysqli_query($conn, "INSERT INTO tb_order (kode_order, meja, pelanggan, pelayan, status, waktu_order) 
            VALUES ('$kode_order', '$meja', '$pelanggan', '$pelayan', '$status', '$waktu_order')");

        if ($query) {
            // Ambil ID order terakhir
            $id_order = mysqli_insert_id($conn);

            // Redirect ke halaman order item
            echo '<script>alert("Data berhasil masuk"); window.location="../?x=orderitem&order='.$id_order.'";</script>';
        } else {
            echo '<script>alert("Data gagal masuk: '.mysqli_error($conn).'"); window.location="../order";</script>';
        }
    }
}
?>
