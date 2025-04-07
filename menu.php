<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php
include "proses/connect.php";
$query = mysqli_query($conn, "SELECT * FROM tb_daftar_menu
LEFT JOIN tb_kategori_menu ON tb_kategori_menu.id = tb_daftar_menu.kategori
"); //hubungin database
$result = [];
while ($record = mysqli_fetch_array($query)) {
  $result[] = $record; //menampung data 
}

$select_kat_menu = mysqli_query($conn, "SELECT id,kategori_menu FROM tb_kategori_menu");

?>
<div class="col-lg-9 mt-2">
  <div class="card">
    <div class="card-header">
      Halaman Daftar Menu
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col d-flex justify-content-end">
          <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#ModalTambahUser">Tambah Menu</button>

        </div>
      </div>

      <!-- Modal tambah menu baru -->
      <div class="modal fade" id="ModalTambahUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-md-down">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" novalidate action="proses/proses_input_menu.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="input-group mb-3">
                      <input type="file" class="form-control" id="uploadFoto" placeholder="Your Name" name="foto" required>
                      <label class="input-group-text" for="uploadFoto">Upload Foto Menu</label>
                      <div class="invalid-feedback">
                        Masukkan Foto Menu.
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput" placeholder="Nama Menu" name="nama_menu" required>
                      <label for="floatingInput">Nama Menu</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput" placeholder="Keterangan" name="keterangan" required>
                      <label for="floatingInput">Keterangan</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-floating">
                      <select class="form-select" name="kat_menu" aria-label="Default select example" required>
                        <?php
                        foreach ($select_kat_menu as $value) {
                          echo "<option value=" . $value['id'] . ">$value[kategori_menu]</option>";
                        }
                        ?>
                      </select>
                      <label for="floatingInput">Pilih Menu</label>
                      <div class="invalid-feedback">
                        Pilih Menu
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="floatingInput" placeholder="Harga" name="harga" required>
                      <label for="floatingInput">Harga</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="floatingInput" placeholder="Stok" name="stok" required>
                    <label for="floatingInput">Stok</label>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="input_menu_validate" value="1234">Save changes</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal tambah menu baru END -->

    <?php
    foreach ($result as $row) {
    ?>
      <!-- Modal VIEW-->
      <div class="modal fade" id="ModalView<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-md-down">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">View Menu</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" novalidate>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="input-group mb-3">
                      <img src="assets/img/<?php echo $row['foto']; ?>" class="img-thumbnail" alt="...">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput" placeholder="Nama Menu" name="nama_menu" value="<?php echo $row['nama_menu']; ?>" readonly>
                      <label for="floatingInput">Nama Menu</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput" placeholder="Keterangan" name="kat_menu" value="<?php echo $row['keterangan']; ?>" readonly>
                      <label for="floatingInput">Keterangan</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-floating">
                      <select class="form-select" name="kat_menu" aria-label="Default select example" disabled>
                        <?php
                        foreach ($select_kat_menu as $value) {
                          echo "<option value=" . $value['id'] . " " . ($value['id'] == $row['kategori'] ? 'selected' : '') . ">$value[kategori_menu]</option>";
                        }
                        ?>
                      </select>
                      <label for="floatingInput">Pilih Menu</label>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="floatingInput" placeholder="Harga" name="harga" value="<?php echo $row['harga']; ?>" readonly>
                      <label for="floatingInput">Harga</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="floatingInput" placeholder="Stok" name="stok" value="<?php echo $row['stok']; ?>" readonly>
                    <label for="floatingInput">Stok</label>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
          </div>
        </div>
      </div>
  </div>
  <!-- end view -->

  <!-- Modal Edit-->
  <div class="modal fade" id="ModalEdit<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" novalidate action="proses/proses_edit_menu.php" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-6">
                <div class="input-group mb-3">
                  <input type="file" class="form-control" id="uploadFoto" placeholder="Your Name" name="foto">
                  <label class="input-group-text" for="uploadFoto">Upload Foto Menu</label>
                  <div class="invalid-feedback">
                    Masukkan Foto Menu.
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" placeholder="Nama Menu" name="nama_menu" value="<?php echo $row['nama_menu']; ?>" required>
                  <label for="floatingInput">Nama Menu</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" placeholder="Keterangan" name="keterangan" value="<?php echo $row['keterangan']; ?>" required>
                  <label for="floatingInput">Keterangan</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-floating">
                <select class="form-select" name="kat_menu" aria-label="Default select example">
                        <?php
                        foreach ($select_kat_menu as $value) {
                          echo "<option value=" . $value['id'] . " " . ($value['id'] == $row['kategori'] ? 'selected' : '') . ">$value[kategori_menu]</option>";
                        }
                        ?>
                      </select>
                  <label for="floatingInput">Pilih Menu</label>
                  <div class="invalid-feedback">
                    Pilih Menu
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-floating mb-3">
                  <input type="number" class="form-control" id="floatingInput" placeholder="Harga" name="harga" value="<?php echo $row['harga']; ?>" required>
                  <label for="floatingInput">Harga</label>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-floating mb-3">
                <input type="number" class="form-control" id="floatingInput" placeholder="Stok" name="stok" value="<?php echo $row['stok']; ?>" required>
                <label for="floatingInput">Stok</label>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="input_menu_validate" value="1234">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- end edit modal -->


<!-- Modal Delete -->
<div class="modal fade" id="ModalDelete<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="modalDeleteLabel<?php echo $row['id']; ?>" aria-hidden="true">
  <div class="modal-dialog modal-md modal-fullscreen-md-down">
    <div class="modal-content">
      
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalDeleteLabel<?php echo $row['id']; ?>">Hapus Data Menu</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form class="needs-validation" novalidate action="proses/proses_delete_menu.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
          <input type="hidden" name="foto" value="<?php echo $row['foto']; ?>">
          <div class="col-lg-12 mb-3">
            Apakah Anda ingin menghapus menu <b><?php echo $row['nama_menu']; ?></b>?
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" name="input_menu_validate" value="1234">Hapus</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<!-- end delete -->

<?php
    }

    if (empty($result)) {
      echo  "Data user tidak ada";
    } else {
?>

  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Foto Menu</th>
          <th scope="col">Nama</th>
          <th scope="col">Keterangan</th>
          <th scope="col">Jenis Menu</th>
          <th scope="col">Kategori</th>
          <th scope="col">Harga</th>
          <th scope="col">Stok</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php
    }
    $no = 1;
    foreach ($result as $row) {
      ?>
        <tr>
          <th scope="row">
            <?php echo $no++; ?></th>
          <td>
            <div style="width: 90px;">

            </div>
            <img src="assets/img/<?php echo $row['foto']; ?>" class="img-thumbnail" alt="...">
          </td>
          <td><?php echo $row['nama_menu']; ?></td>
          <td><?php echo $row['keterangan']; ?></td>
          <td><?php echo ($row['jenis_menu'] == 1) ? "Makanan" : "Minuman" ?></td>
          <td><?php echo $row['kategori_menu']; ?></td>
          <td><?php echo $row['harga']; ?></td>
          <td><?php echo $row['stok']; ?></td>

          <td>
            <div class="d-flex">

              <!-- Tombol View -->
              <button class="btn btn-info btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalView<?php echo $row['id']; ?>">
                <i class="bi bi-eye"></i>
              </button>

              <!-- Tombol Edit -->
              <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalEdit<?php echo $row['id']; ?>">
                <i class="bi bi-pencil"></i>
              </button>

              <!-- Tombol Hapus -->
              <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo $row['id']; ?>">
                <i class="bi bi-trash"></i>
              </button>

            </div>
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
  </div>
  </body>


  </html>