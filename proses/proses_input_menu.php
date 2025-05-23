<?php
include "connect.php";
$nama_menu = isset($_POST['nama_menu']) ? htmlentities($_POST['nama_menu']) : "";
$keterangan = isset($_POST['keterangan']) ? htmlentities($_POST['keterangan']) : "";
$kat_menu = isset($_POST['kat_menu']) ? htmlentities($_POST['kat_menu']) : "";
$harga = isset($_POST['harga']) ? htmlentities($_POST['harga']) : "";
$stok = isset($_POST['stok']) ? htmlentities($_POST['stok']) : "";

$kode_rand = rand(10000,999999)."-";
$target_dir = "../assets/img/".$kode_rand;
$target_file = $target_dir . basename($_FILES['foto']['name']);
$imageType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (!empty($_POST['input_menu_validate'])) {
    // Check if file is an image
    $cek = getimagesize($_FILES['foto']['tmp_name']);
    if ($cek === false) {
        $message = "Ini bukan gambar";
        $statusupload = 0;
    } else {
        $statusupload = 1;
        if (file_exists($target_file)) {
            $message = "File ini sudah ada!";
            $statusupload = 0;
        } elseif ($_FILES['foto']['size'] > 500000) { // 500kb
            $message = "File yang diupload terlalu besar";
            $statusupload = 0;
        } elseif (!in_array($imageType, ['jpg', 'png', 'jpeg', 'gif'])) {
            $message = "Maaf, file yang bisa diinput hanyalah png, jpg, jpeg, dan gif!";
            $statusupload = 0;
        }
    }
    if ($statusupload == 0) {
        echo '<script>alert("' . $message . ', Gambar tidak dapat diupload ");
        window.location="../menu"
        </script>';
    } else {
        $select = mysqli_query($conn, "SELECT * FROM tb_daftar_menu WHERE nama_menu = '$nama_menu'");
        if(mysqli_num_rows($select) > 0){
        $message = '<script>alert("Nama menu sudah ada");
             window.location="../menu"</script>';
        }else{
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {  
                $query = mysqli_query($conn, "INSERT INTO tb_daftar_menu(nama_menu, keterangan, kategori, harga, stok, foto) VALUES ('$nama_menu', '$keterangan', '$kat_menu', '$harga', '$stok', '".$kode_rand. $_FILES['foto']['name']."')");
                if($query){
                    $message = '<script>alert("Data dan gambar berhasil diupload");
                    window.location="../menu"</script>';
                    echo $message;
                }else{
                    $message = '<script>alert("menu gagal masuk");
                    window.location="../menu"</script>';
                    echo $message;
                }
            }else{
                $message = '<script>alert("terjadi kesalahan file tidak dapat diupload");
                    window.location="../menu"</script>';
                echo $message;
            }
        }
    }
}