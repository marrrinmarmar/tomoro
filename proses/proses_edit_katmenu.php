<?php
include "connect.php";
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$jenismenu = isset($_POST['jenismenu']) ? htmlentities($_POST['jenismenu']) : "";
$katmenu = isset($_POST['katmenu']) ? htmlentities($_POST['katmenu']) : "";

if (!empty($_POST['edit_katmenu_validate'])) {
    // Check if the category name already exists (excluding current record)
    $select = mysqli_query($conn, "SELECT kategori_menu FROM tb_kategori_menu WHERE kategori_menu = '$katmenu' AND id != '$id'");

    if(mysqli_num_rows($select) > 0){
        $message = '<script>alert("Kategori Menu sudah ada!");
        window.location="../katmenu"</script>';
    } else {
        $query = mysqli_query($conn, "UPDATE tb_kategori_menu SET jenis_menu='$jenismenu', kategori_menu='$katmenu' WHERE id='$id'");
        
        if (!$query) {
            $message = '<script>alert("Data gagal diedit");
            window.location="../katmenu"</script>';
        } else {
            $message = '<script>alert("Data berhasil diedit");
            window.location="../katmenu"</script>';
        }
    }
    echo $message;
}