<?php
include "../proses/connect.php";
session_start();

$id_order = isset($_POST['id_order']) ? htmlentities($_POST['id_order']) : "";
$pelanggan = isset($_POST['pelanggan']) ? htmlentities($_POST['pelanggan']) : "";
$meja = isset($_POST['meja']) ? htmlentities($_POST['meja']) : "";
$status = isset($_POST['status']) ? htmlentities($_POST['status']) : "";

// Validasi form (field harus diisi)
if (!empty($_POST['edit_order_validate'])) {
    if ($id_order == "" || $pelanggan == "" || $meja == "" || $status == "") {
        $message = '<script>alert("Semua data harus diisi!"); window.location="../order";</script>';
    } else {
        // Update data ke database
        $query = mysqli_query($conn, "UPDATE tb_order SET 
            pelanggan = '$pelanggan', 
            meja = '$meja', 
            status = '$status' 
            WHERE id_order = '$id_order'
        ");

        if ($query) {
            $message = '<script>alert("Order berhasil diupdate."); window.location="../order";</script>';
        } else {
            $message = '<script>alert("Gagal update order: '.mysqli_error($conn).'"); window.location="../order";</script>';
        }
    }
    echo $message;
}
?>
