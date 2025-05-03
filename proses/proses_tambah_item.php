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

  $cek = mysqli_query($conn, "SELECT * FROM tb_list_order WHERE `order` = '$id_order' AND menu = '$id_menu'");
  if (mysqli_num_rows($cek) > 0) {
    // Update jumlah jika item sudah ada
    mysqli_query($conn, "UPDATE tb_list_order SET jumlah = jumlah + $jumlah WHERE `order` = '$id_order' AND menu = '$id_menu'");
  } else {
    // Insert baru jika item belum ada
    mysqli_query($conn, "INSERT INTO tb_list_order (`order`, menu, jumlah) VALUES ('$id_order', '$id_menu', '$jumlah')");
  }
  
  header("Location: ../?x=orderitem&id_order=$id_order");
}
