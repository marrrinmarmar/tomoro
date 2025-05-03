<?php
include "connect.php";
session_start();

$kode_order = htmlentities($_POST['kode-order'] ?? "");
$meja = htmlentities($_POST['meja'] ?? "");
$pelanggan = htmlentities($_POST['pelanggan'] ?? "");
$pelayan = $_SESSION['id_decafe'];
$status = "pending";
$waktu_order = date("Y-m-d H:i:s");

// Cek customer
$cek_customer = mysqli_query($conn, "SELECT * FROM tb_customer WHERE nama = '$pelanggan'");
$customer_data = mysqli_fetch_assoc($cek_customer);

if ($customer_data) {
    $id_customer = $customer_data['id_customer'];
    mysqli_query($conn, "UPDATE tb_customer SET jumlah_kunjungan = jumlah_kunjungan + 1 WHERE id_customer = '$id_customer'");
} else {
    mysqli_query($conn, "INSERT INTO tb_customer (nama, jumlah_kunjungan, total_transaksi) VALUES ('$pelanggan', 1, 0)");
    $id_customer = mysqli_insert_id($conn);
}

// Pastikan form dikirim
if (!empty($_POST['input_order_validate'])) {
    $select = mysqli_query($conn, "SELECT * FROM tb_order WHERE kode_order = '$kode_order'");
    if (mysqli_num_rows($select) > 0) {
        echo '<script>alert("Kode Order yang dimasukkan telah ada"); window.location="../order";</script>';
    } else {
        $query = mysqli_query($conn, "INSERT INTO tb_order (kode_order, id_customer, meja, pelanggan, pelayan, status, waktu_order, tanggal) 
        VALUES ('$kode_order', '$id_customer', '$meja', '$pelanggan', '$pelayan', '$status', '$waktu_order', CURDATE())");

        if ($query) {
            $id_order = mysqli_insert_id($conn);
            echo '<script>alert("Data berhasil masuk"); window.location="../?x=orderitem&id_order='.$id_order.'";</script>';
        } else {
            echo '<script>alert("Data gagal masuk: '.mysqli_error($conn).'"); window.location="../order";</script>';
        }
    }
}

?>
