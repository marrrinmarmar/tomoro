<?php
include "connect.php";
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$foto = isset($_POST['id']) ? htmlentities($_POST['foto']) : "";

if (!empty($_POST['input_menu_validate'])) {
    $query = mysqli_query($conn, "DELETE FROM tb_daftar_menu WHERE id = '$id'");
    unlink("../assets/img/$foto");
    if (!$query) {
        $message = '<script>alert("data gagal dihapus"); 
        window.location="../menu"</script>';
    } else {
        $message = '<script>alert("data berhasil dihapus");
         window.location="../menu"</script>
        </script>';
    }
    echo $message;
}
?>
