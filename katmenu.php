<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php
include "proses/connect.php";
$query = mysqli_query($conn, "SELECT * FROM tb_kategori_menu");
while ($record = mysqli_fetch_array($query)) {
    $result[] = $record; //menampung data 
}
?>
<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            Halaman Daftar Menu
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#ModalTambahKatMenu">Tambah Kategori
                Menu</button>
        </div>
        <div class="card-body">
    <div class="row">
        <div class="col d-flex justify-content-end">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Jenis Menu</th>
                        <th scope="col">Kategori Menu</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1; // Inisialisasi variabel $no
                    foreach ($result as $row) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $no++; ?></th>
                            <td><?php echo ($row['jenis_menu']==1) ? "Makanan" : "Minuman" ; ?></td>
                            <td><?php echo $row['kategori_menu']; ?></td>
                            <td>
                                <!-- Tombol View -->
                                <button class="btn btn-info btn-sm me-1" data-bs-toggle="modal"
                                    data-bs-target="#ModalView<?php echo $row['id']; ?>">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <!-- Tombol Edit -->
                                <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal"
                                    data-bs-target="#ModalEdit<?php echo $row['id']; ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal"
                                    data-bs-target="#ModalDelete<?php echo $row['id']; ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

            <!-- Modal tambah user -->
            <div class="modal fade" id="ModalTambahUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Menu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="proses/proses_input_katmenu.php"
                                method="POST">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="jenismenu" id="">
                                                <option value="1">Makanan</option>
                                                <option value="2">Minuman</option>
                                            </select>
                                            <label for="floatingInput">Jenis Menu</label>
                                            <div class="invalid-feedback">
                                                Please input Jenis Menu
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input  type="email" class="form-control"
                                                id="floatingInput" placeholder="Kategori Menu" name="katmenu"
                                                required>
                                            <label for="floatingInput">Kategori Menu</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_katmenu_validate"
                                        value="1234">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal tambah user baru END -->

            <!-- Modal VIEW-->
            <div class="modal fade" id="ModalView<?php echo $row['id'] ?>" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detail Data User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="proses/proses_input_user.php"
                                method="POST">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput"
                                                placeholder="Your Name" name="nama" value="<?php echo $row['nama'] ?>">
                                            <label for="floatingInput">Nama</label>
                                            <div class="invalid-feedback">
                                                Masukkan Nama.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input disabled type="email" class="form-control" id="floatingInput"
                                                placeholder="name@example.com" name="username"
                                                value="<?php echo $row['username'] ?>">
                                            <label for="floatingInput">Username</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select disabled class="form-select" aria-label="Default select example"
                                                name="level" required>
                                                <?php
                                                $data = array("Admin", "Kasir", "Pelayan", "Dapur");
                                                foreach ($data as $key => $value) {
                                                    if ($row['level'] == $key + 1) {
                                                        echo "<option selected value='$key'>$value</option>";
                                                    } else {
                                                        echo "<option value='$key'>$value</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <label for="floatingInput">Pilih Level User</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-floating mb-3">
                                            <input disabled type="number" class="form-control" id="floatingInput"
                                                placeholder="08XXXXXXXXX" name="nohp" required
                                                value="<?php echo $row['nohp'] ?>">
                                            <label for="floatingInput">No HP</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-4">
                                    <textarea disabled class="form-control" id="" style="height: 100px;"
                                        name="alamat"><?php echo $row['username'] ?></textarea>
                                    <label for="floatingInput">Alamat</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_user_validate"
                                        value="1234">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end view -->

            <!-- Modal Edit-->
            <div class="modal fade" id="ModalEdit<?php echo $row['id'] ?>" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detail Data User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="proses/proses_edit_user.php"
                                method="POST">
                                <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput"
                                                placeholder="Your Name" name="nama" value="<?php echo $row['nama'] ?>"
                                                required>
                                            <label for="floatingInput">Nama</label>
                                            <div class="invalid-feedback">
                                                Masukkan Nama.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="floatingInput"
                                                placeholder="name@example.com" name="username"
                                                value="<?php echo $row['username'] ?>" required>
                                            <label for="floatingInput">Username</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-floating">
                                            <select class="form-select" aria-label="Default select example" name="level"
                                                required>
                                                <?php
                                                $data = array("Admin", "Kasir", "Pelayan", "Dapur");
                                                foreach ($data as $key => $value) {
                                                    if ($row['level'] == $key + 1) {
                                                        echo "<option selected value=" . ($key + 1) . ">$value</option>";
                                                    } else {
                                                        echo "<option value=" . ($key + 1) . ">$value</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <label for="floatingInput">Pilih Level User</label>
                                            <div class="invalid-feedback">
                                                Pilih Level User
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="floatingInput"
                                                placeholder="08XXXXXXXXX" name="nohp" required
                                                value="<?php echo $row['nohp'] ?>">
                                            <label for="floatingInput">No HP</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mt-4">
                                    <textarea class="form-control" id="" style="height: 100px;"
                                        name="alamat"><?php echo $row['username'] ?></textarea>
                                    <label for="floatingInput">Alamat</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_user_validate"
                                        value="1234">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end edit modal -->


            <!-- Modal delete-->
            <div class="modal fade" id="ModalDelete<?php echo $row['id'] ?>" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="proses/proses_delete_user.php"
                                method="POST">
                                <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                                <div class="col-lg-12">
                                    <?php
                                    if ($row['username'] == $_SESSION['username_decafe']) {
                                        echo "<div class='alert alert-danger'>Jangan hapus diri sendiri</div>";
                                    } else {
                                        echo "Mau hapus User <b> $row[username]</b>";
                                    }
                                    ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger" name="input_user_validate" value="1234"
                                        <?php echo ($row['username'] == $_SESSION['username_decafe']) ? 'disabled' : ''; ?>>Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end delete modal -->

        </div>
    </div>
</div>
</div>
</body>

</html>