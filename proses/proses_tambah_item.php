<?php
include "../proses/connect.php";

if (isset($_POST['tambah_item_validate'])) {
  $id_order = $_POST['id_order'];
  $id_menu = $_POST['id_menu'];
  $jumlah = $_POST['jumlah'];

  mysqli_query($conn, "INSERT INTO tb_list_order (`order`, menu, jumlah) VALUES ('$id_order', '$id_menu', '$jumlah')");
  header("Location: ../order_item.php?id=$id_order");
}
