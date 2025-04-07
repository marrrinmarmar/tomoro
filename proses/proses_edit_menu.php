<?php
include "connect.php";
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$nama_menu = isset($_POST['nama_menu']) ? htmlentities($_POST['nama_menu']) : "";
$keterangan = isset($_POST['keterangan']) ? htmlentities($_POST['keterangan']) : "";
$kat_menu = isset($_POST['kat_menu']) ? htmlentities($_POST['kat_menu']) : "";
$harga = isset($_POST['harga']) ? htmlentities($_POST['harga']) : "";
$stok = isset($_POST['stok']) ? htmlentities($_POST['stok']) : "";
$foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : "";

if (!empty($_POST['input_menu_validate'])) {
    // Cek apakah menu ada di database
    $check = mysqli_query($conn, "SELECT * FROM tb_daftar_menu WHERE id = '$id'");
    if(mysqli_num_rows($check) == 0) {
        $message = '<script>alert("Menu tidak ditemukan"); 
        window.location="../menu"</script>';
    } else {
        $menu = mysqli_fetch_array($check);
        
        // Jika ada foto baru
        if($foto) {
            $target_dir = "../assets/img/";
            $target_file = $target_dir . basename($foto);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES['foto']['tmp_name']);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $message = '<script>alert("File is not an image.")</script>';
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES['foto']['size'] > 500000) {
                $message = '<script>alert("Sorry, your file is too large.")</script>';
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $message = '<script>alert("Sorry, only JPG, JPEG, & PNG files are allowed.")</script>';
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $message = '<script>alert("Sorry, your file was not uploaded.")</script>';
            } else {
                // Hapus foto lama jika ada
                if($menu['foto'] && file_exists("../assets/img/" . $menu['foto'])) {
                    unlink("../assets/img/" . $menu['foto']);
                }
                
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                    $query = mysqli_query($conn, "UPDATE tb_daftar_menu SET nama_menu='$nama_menu', keterangan='$keterangan', kategori='$kat_menu', harga='$harga', stok='$stok', foto='$foto' WHERE id='$id'");
                } else {
                    $message = '<script>alert("Sorry, there was an error uploading your file.")</script>';
                }
            }
        } else {
            // Update tanpa foto
            $query = mysqli_query($conn, "UPDATE tb_daftar_menu SET nama_menu='$nama_menu', keterangan='$keterangan', kategori='$kat_menu', harga='$harga', stok='$stok' WHERE id='$id'");
        }
        
        if (!$query) {
            $message = '<script>alert("Data gagal diedit"); 
            window.location="../menu"</script>';
        } else {
            $message = '<script>alert("Data berhasil diedit");
            window.location="../menu"</script>';
        }
    }
    echo $message;
}
?>
