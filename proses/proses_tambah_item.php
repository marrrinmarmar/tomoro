<?php
include "../proses/connect.php";

if (isset($_POST['tambah_item_validate'])) {
  $id_order = $_POST['id_order'];
  $id_menu = $_POST['id_menu'];
  $jumlah = $_POST['jumlah'];

  // Validasi order
  $check_order = mysqli_query($conn, "SELECT id_order FROM tb_order WHERE id_order = '$id_order'");
  if (mysqli_num_rows($check_order) == 0) {
      die("ID Order tidak ditemukan di tb_order: $id_order");
  }

  // Cek stok menu
  $query = mysqli_query($conn, "SELECT stok FROM tb_daftar_menu WHERE id = '$id_menu'");
  if (mysqli_num_rows($query) == 0) {
      die("Menu tidak ditemukan");
  }

  $menu = mysqli_fetch_assoc($query);
  $stok = $menu['stok'];

  // Cek apakah stok cukup
  if ($stok < $jumlah) {
      die("Stok tidak mencukupi! Stok tersedia: $stok");
  }

  // Cek apakah menu sudah ada di order
  $cek = mysqli_query($conn, "SELECT * FROM tb_list_order WHERE `order` = '$id_order' AND menu = '$id_menu'");
  if (mysqli_num_rows($cek) > 0) {
    // Update jumlah jika item sudah ada
    mysqli_query($conn, "UPDATE tb_list_order SET jumlah = jumlah + $jumlah WHERE `order` = '$id_order' AND menu = '$id_menu'");
  } else {
    // Insert baru jika item belum ada
    mysqli_query($conn, "INSERT INTO tb_list_order (`order`, menu, jumlah) VALUES ('$id_order', '$id_menu', '$jumlah')");
  }

  // Kurangi stok menu
  $stok_baru = $stok - $jumlah;
  mysqli_query($conn, "UPDATE tb_daftar_menu SET stok = '$stok_baru' WHERE id = '$id_menu'");
  
  header("Location: ../?x=orderitem&id_order=$id_order");
}
