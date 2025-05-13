<!-- Bootstrap JS (pastikan ini sebelum </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php
include "proses/connect.php";

$id_user = $_SESSION['id_decafe'] ?? null;

$data_user = null;
if ($id_user) {
    $query_user = mysqli_query($conn, "SELECT * FROM tb_user WHERE id = '$id_user'");
    if ($query_user && mysqli_num_rows($query_user) > 0) {
        $data_user = mysqli_fetch_assoc($query_user);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Decafe</title>
</head>

<body>
    <nav class="navbar navbar-expand bg-body-tertiary sticky-top">
        <div class="container-lg">
            <a class="navbar-brand" href="#">
                <img src="kefein.png" width="150px" alt="Decafe Logo">
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $hasil['username']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-2">
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalProfile">
                                    <i class="bi bi-person-circle me-1"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ModalUbahPassword">
                                    <i class="bi bi-key me-1"></i> Ubah Password
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="logout">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal Profile User -->
    <div class="modal fade" id="modalProfile" tabindex="-1" aria-labelledby="modalProfileLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <!-- Banner Background -->
                <div class="position-relative">
                    <div style="height: 150px; border-radius: 5px; background: linear-gradient(to right, #6a11cb, #2575fc);"></div>
                    <div class="position-absolute top-10 start-50 translate-middle">
                        <div class="rounded-circle border border-white overflow-hidden shadow" style="width: 100px; height: 100px;">
                            <img src="https://via.placeholder.com/100" alt="Profile" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="modal-body mt-5 pt-4 text-center">
                    <?php
                    include "proses/connect.php";

                    $id_user = $_SESSION['id_decafe'] ?? null;

                    $data_user = null;
                    if ($id_user) {
                        $query_user = mysqli_query($conn, "SELECT * FROM tb_user WHERE id = '$id_user'");
                        if ($query_user && mysqli_num_rows($query_user) > 0) {
                            $data_user = mysqli_fetch_assoc($query_user);
                        }
                    }
                    ?>

                    <h5 class="mt-2"><?= $data_user ? htmlspecialchars($data_user['nama']) : '-' ?></h5>
                    <p class="mb-4 text-muted">Level: <?= $data_user ? htmlspecialchars($data_user['level']) : '-' ?></p>

                    <table class="table table-borderless w-75 mx-auto text-start">
                        <tr>
                            <th class="w-50">email</th>
                            <td>: <?= $data_user ? htmlspecialchars($data_user['username']) : '-' ?></td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>: <?= $data_user ? htmlspecialchars($data_user['nohp']) : '-' ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Password -->
    <div class="modal fade" id="ModalUbahPassword" tabindex="-1" aria-labelledby="modalUbahPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahPasswordLabel">
                        <i class="bi bi-key me-1"></i> Ubah Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate action="proses/proses_ubah_password.php" method="POST">
                        <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" value="<?php echo $_SESSION['username_decafe'] ?>">
                                    <label for="floatingInput">Username</label>
                                    <div class="invalid-feedback">Masukkan username</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPassword" name="passwordlama" required>
                                    <label for="floatingPassword">Password lama</label>
                                    <div class="invalid-feedback">Masukkan password lama</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingInput" name="passwordbaru">
                                    <label for="floatingInput">Password Baru</label>
                                    <div class="invalid-feedback">Masukkan password baru</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPassword" name="repasswordbaru" required>
                                    <label for="floatingPassword">Ulangi Password Baru</label>
                                    <div class="invalid-feedback">Ulangi password baru</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" name="ubah_password_validate" value="1234">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>