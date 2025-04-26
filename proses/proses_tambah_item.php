<?php
include "../proses/connect.php";

if (isset($_POST['tambah_item_validate'])) {
  $id_order = $_POST['id_order'];
  $id_menu = $_POST['id_menu'];
  $jumlah = $_POST['jumlah'];
  $check_order = mysqli_query($conn, "SELECT id_order FROM tb_order WHERE id_order = '$id_order'");
  if (mysqli_num_rows($check_order) == 0) {
      die("ID Order tidak ditemukan di tb_order: $id_order");
  }
  
  mysqli_query($conn, "INSERT INTO tb_list_order (`order`, menu, jumlah) VALUES ('$id_order', '$id_menu', '$jumlah')");
  header("Location: ../order_item.php?id=$id_order");
}
