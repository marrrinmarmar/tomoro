<?php
include "connect.php";
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";


if (!empty($_POST['hapus_kategori_validate'])) {
    $select = mysqli_query($conn, "SELECT kategori FROM tb_daftar_menu WHERE kategori = '$id'");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Kategori yang dimasukkan telah ada");
        window.location="../katmenu"</script>';
    } else {

        $query = mysqli_query($conn, "DELETE FROM tb_kategori_menu WHERE id = '$id'");

        if (!$query) {
            $message = '<script>alert("data gagal dihapus");
        window.location="../katmenu"</script>';
        } else {
            $message = '<script>alert("data berhasil dihapus");
         window.location="../katmenu"</script>';
        }
    }
    echo $message;
}
