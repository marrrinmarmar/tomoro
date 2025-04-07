<?php
session_start(); // ✅ START SESSION HERE

include "connect.php";

$username = isset($_POST['username']) ? htmlentities($_POST['username']) : "";
$password = isset($_POST['password']) ? md5(htmlentities($_POST['password'])) : "";

if (!empty($_POST['submit_validate'])) {
    $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username' AND password = '$password'");
    $hasil = mysqli_fetch_array($query);

    if ($hasil) {
        // ✅ SET SESSION
        $_SESSION['username_decafe'] = $username;
        $_SESSION['level_decafe'] = $hasil['level'];
        
        // ✅ DEBUG: Cek apakah session berhasil diset
        if (isset($_SESSION['level_decafe'])) {
            echo "Session berhasil diset: Level = " . $_SESSION['level_decafe'];
        } else {
            echo "Gagal menyimpan session!";
        }

        // ✅ Redirect ke halaman home
        header('Location: ../home');
        exit(); // ✅ STOP EXECUTION AFTER REDIRECT
    } else {
        ?>
        <script>
            alert('Username atau password salah bang');
            window.location='../login.php';
        </script>
        <?php
    }
}
?>
