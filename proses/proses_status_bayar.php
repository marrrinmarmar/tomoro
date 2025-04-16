<?php
include "../proses/connect.php";

$id_order = $_POST['id_order'];

if (isset($_POST['update_status'])) {
  $status = $_POST['status'];
  mysqli_query($conn, "UPDATE tb_order SET status = '$status' WHERE id_order = '$id_order'");
  header("Location: ../order_item.php?id=$id_order");

} elseif (isset($_POST['bayar'])) {
  $total = $_POST['total'];
  mysqli_query($conn, "UPDATE tb_order SET status = 'dibayar' WHERE id_order = '$id_order'");
  // bisa juga simpan ke tabel transaksi di sini
  header("Location: ../order");
}
