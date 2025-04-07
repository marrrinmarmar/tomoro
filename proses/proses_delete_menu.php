<?php
include "connect.php";
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$foto = isset($_POST['foto']) ? htmlentities($_POST['foto']) : "";

if (!empty($_POST['input_menu_validate'])) {
    // Cek apakah menu ada di database
    $check = mysqli_query($conn, "SELECT * FROM tb_daftar_menu WHERE id = '$id'");
    if(mysqli_num_rows($check) == 0) {
        $message = '<script>alert("Menu tidak ditemukan"); 
        window.location="../menu"</script>';
    } else {
        // Hapus file foto jika ada
        $foto_path = "../assets/img/" . $foto;
        if(file_exists($foto_path)) {
            unlink($foto_path);
        }
        
        // Hapus data dari database
        $query = mysqli_query($conn, "DELETE FROM tb_daftar_menu WHERE id = '$id'");
        
        if (!$query) {
            $message = '<script>alert("Data gagal dihapus"); 
            window.location="../menu"</script>';
        } else {
            $message = '<script>alert("Data berhasil dihapus");
            window.location="../menu"</script>';
        }
    }
    echo $message;
}
?>