<?php
include "connect.php";
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$jenismenu = isset($_POST['jenismenu']) ? htmlentities($_POST['jenismenu']) : "";
$katmenu = isset($_POST['katmenu']) ? htmlentities($_POST['katmenu']) : "";


if (!empty($_POST['input_user_validate'])) {
    $select = mysqli_query($conn, "SELECT kategori_menu FROM tb_kategori_menu WHERE kategori_menu = '$katmenu'");

    if(mysqli_num_rows($select) > 0){
        $message = '<script>alert("Kategori Menu sudah dipakai user lain!");
        window.location="../user"</script>';
    } else {
        $query = mysqli_query($conn, "UPDATE tb_user SET nama='$nama', username='$username', level='$level', nohp='$nohp', alamat='$alamat' WHERE id='$id'");
        
        if (!$query) {
            $message = '<script>alert("Data gagal diedit")</script>';
        } else {
            $message = '<script>alert("Data berhasil diedit");
            window.location="../user"</script>';
        }
    }
    echo $message;
}
?>