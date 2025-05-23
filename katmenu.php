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
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#ModalTambahKatMenu">Tambah Kategori Menu</button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
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
                            $no = 1;
                            foreach ($result as $row) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo $no++; ?></th>
                                <td><?php echo ($row['jenis_menu'] == 1) ? "Makanan" : "Minuman"; ?></td>
                                <td><?php echo $row['kategori_menu']; ?></td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalEdit<?php echo $row['id']; ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo $row['id']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($result as $row) { ?>
<div class="modal fade" id="ModalEdit<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kategori Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/proses_edit_katmenu.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="jenismenu" required>
                                    <?php
                                    $data = array("Makanan", "Minuman");
                                    foreach ($data as $key => $value) {
                                        $selected = ($row['jenis_menu'] == $key + 1) ? "selected" : "";
                                        echo "<option value='" . ($key + 1) . "' $selected>$value</option>";
                                    }
                                    ?>
                                </select>
                                <label for="jenismenu">Jenis Menu</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="katmenu" placeholder="Kategori Menu" value="<?php echo $row['kategori_menu']; ?>" required>
                                <label for="katmenu">Kategori Menu</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit_katmenu_validate" value="1234">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="ModalDelete<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Kategori Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/proses_delete_katmenu.php" method="POST">
                    <input type="hidden" value="<?php echo $row['id']; ?>" name="id">
                    <div class="col-lg-12">
                        Apakah anda yakin ingin menghapus kategori menu <b><?php echo $row['kategori_menu']; ?></b>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" name="delete_katmenu_validate" value="1234">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<!-- Modal Tambah Kategori Menu -->
<div class="modal fade" id="ModalTambahKatMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/proses_input_katmenu.php" method="POST">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="jenismenu" required>
                                    <option value="1">Makanan</option>
                                    <option value="2">Minuman</option>
                                </select>
                                <label for="jenismenu">Jenis Menu</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="katmenu" placeholder="Kategori Menu" required>
                                <label for="katmenu">Kategori Menu</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="input_katmenu_validate" value="1234">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>