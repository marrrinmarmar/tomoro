<?php
include "../proses/connect.php";

$id_order = $_POST['id_order'];

// Ambil data order untuk dapatkan id_customer
$order = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_customer FROM tb_order WHERE id_order = '$id_order'"));
$id_customer = $order['id_customer'];

if (isset($_POST['update_status'])) {
    $status = $_POST['status'];
    mysqli_query($conn, "UPDATE tb_order SET status = '$status' WHERE id_order = '$id_order'");
    header("Location:../?x=orderitem&id_order=$id_order");
    exit;
}

if (isset($_POST['bayar'])) {
    $total = $_POST['total']; // ini dikirim dari form hidden input
    $id_customer = $_POST['id_customer'];

    // Update status order jadi 'dibayar' dan total transaksi
    mysqli_query($conn, "UPDATE tb_order SET status = 'dibayar', total = '$total' WHERE id_order = '$id_order'");

    // Update data customer jika ada id_customer
    if (!empty($id_customer)) {
        mysqli_query($conn, "UPDATE tb_customer 
            SET total_transaksi = total_transaksi + $total, 
                jumlah_kunjungan = jumlah_kunjungan + 1 
            WHERE id_customer = '$id_customer'");
    }

    echo "<script>alert('Pembayaran berhasil!'); window.location='../order';</script>";
    exit;
}
