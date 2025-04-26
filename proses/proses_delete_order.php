<?php
include "../proses/connect.php";

if (isset($_POST['id_order'])) {
    $id_order = $_POST['id_order'];

    // Pertama, hapus dulu list_order yang terkait
    $hapus_list = mysqli_query($conn, "DELETE FROM tb_list_order WHERE `order` = '$id_order'");

    // Kalau berhasil hapus list_order, lanjut hapus order utamanya
    if ($hapus_list) {
        $hapus_order = mysqli_query($conn, "DELETE FROM tb_order WHERE id_order = '$id_order'");

        if ($hapus_order) {
            header("Location: ../order?msg=success");
            exit();
        } else {
            header("Location: ../order?msg=error_delete_order");
            exit();
        }
    } else {
        header("Location: ../order?msg=error_delete_list");
        exit();
    }
} else {
    header("Location: ../order?msg=invalid_request");
    exit();
}
?>
