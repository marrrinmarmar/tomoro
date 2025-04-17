<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom CSS untuk gambar menu -->
<style>
  .menu-image-container {
    width: 100px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .menu-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 5px;
  }
</style>

<?php
include "proses/connect.php";
date_default_timezone_set('Asia/Jakarta');
$query = mysqli_query($conn, "SELECT tb_order.*, nama, SUM(harga*jumlah) AS harganya FROM tb_order 
LEFT JOIN tb_user ON tb_user.id = tb_order.pelayan LEFT JOIN tb_list_order ON tb_list_order.order = tb_order.id_order LEFT JOIN tb_daftar_menu ON tb_daftar_menu.id = tb_list_order.menu
GROUP BY id_order");
$result = [];
while ($record = mysqli_fetch_array($query)) {
  $result[] = $record; //menampung data 
}

// $select_kat_menu = mysqli_query($conn, "SELECT id,kategori_menu FROM tb_kategori_menu");

?>
<div class="col-lg-9 mt-2">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      Halaman Order
      <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#ModalTambahUser">Tambah
        Menu</button>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Kode Order</th>
                  <th scope="col">Pelanggan</th>
                  <th scope="col">Meja</th>
                  <th scope="col">Total Harga</th>
                  <th scope="col">Pelayan</th>
                  <th scope="col">Status</th>
                  <th scope="col">Waktu Order</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($result as $row) {
                ?>
                  <tr>
                    <th scope="row">
                      <?php echo $no++; ?></th>
                    <td><?php echo $row['kode_order']; ?></td>
                    <td><?php echo $row['pelanggan']; ?></td>
                    <td><?php echo $row['meja']; ?></td>
                    <td><?php echo $row['harganya']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['waktu_order']; ?></td>

                    <td>
                      <div class="d-flex">

                        <!-- Tombol View -->
                        <button class="btn btn-info btn-sm me-1" data-bs-toggle="modal"
                          data-bs-target="#ModalView<?php echo $row['id_order']; ?>">
                          <i class="bi bi-eye"></i>
                        </button>

                        <!-- Tombol Edit -->
                        <a href="order_item.php?id=<?php echo $row['id_order']; ?>" class="btn btn-warning btn-sm me-1">
                          <i class="bi bi-pencil"></i>
                        </a>


                        <!-- Tombol Hapus -->
                        <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal"
                          data-bs-target="#ModalDelete<?php echo $row['id_order']; ?>">
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
      <?php
      if (empty($result)) {
        echo  "Data Order tidak ada";
      }
      ?>
      <!-- Modal tambah order baru -->
      <div class="modal fade" id="ModalTambahUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Order</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" novalidate action="proses/proses_input_order.php"
                method="POST">
                <div class="row">
                  <div class="col-lg-3">
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="floatinginput" name="kode-order" value="<?php echo date('ymdHi') . rand(100, 999) ?>" readonly>
                      <label for="floatinginput">Kode Order</label>
                      <div class="invalid-feedback">
                        Masukkan Kode Order!
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="meja"
                        placeholder="Nomor" name="meja" required>
                      <label for="meja">Meja</label>
                      <div class="invalid-feedback">
                        Masukkan Nomor Meja!
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-7">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="pelanggan" name="pelanggan" placeholder="nama" required>
                      <label for="pelanggan">Nama Pelanggan</label>
                      <div class="invalid-feedback">
                        Masukkan Nama Pelanggan!
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="catatan"
                        placeholder="catatan" name="catatan">
                      <label for="catatan">Catatan</label>
                    </div>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="input_order_validate" value="1234">Buat Order</button>
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
        <?php
        $id_order = $row['id_order'];
        $detail_query = mysqli_query($conn, "SELECT tb_list_order.*, tb_daftar_menu.nama_menu, tb_daftar_menu.harga 
  FROM tb_list_order 
  LEFT JOIN tb_daftar_menu ON tb_daftar_menu.id = tb_list_order.menu 
  WHERE tb_list_order.order = '$id_order'");
        ?>

<div class="modal fade" id="ModalView<?php echo $row['id_order']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-fullscreen-md-down">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Pesanan Order #<?= $row['id_order']; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>Menu</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $id_order = $row['id_order'];
            $detail_query = mysqli_query($conn, "SELECT tb_list_order.*, tb_daftar_menu.nama_menu, tb_daftar_menu.harga 
              FROM tb_list_order 
              LEFT JOIN tb_daftar_menu ON tb_daftar_menu.id = tb_list_order.menu 
              WHERE tb_list_order.`order` = '$id_order'");

            while ($item = mysqli_fetch_assoc($detail_query)) {
              $total = $item['harga'] * $item['jumlah'];
              echo "<tr>
                <td>{$item['nama_menu']}</td>
                <td>Rp " . number_format($item['harga']) . "</td>
                <td>{$item['jumlah']}</td>
                <td>Rp " . number_format($total) . "</td>
              </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

          <!-- end view -->

          <!-- Modal Edit-->
          <div class="modal fade" id="ModalEdit<?php echo $row['id_order']; ?>" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-fullscreen-md-down">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form class="needs-validation" novalidate action="proses/proses_edit_menu.php" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="input-group mb-3">
                          <input type="file" class="form-control" id="uploadFoto" placeholder="Your Name"
                            name="foto">
                          <label class="input-group-text" for="uploadFoto">Upload Foto Menu (Opsional)</label>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" id="floatingInput" placeholder="Nama Menu"
                            name="nama_menu" value="<?php echo $row['nama_menu']; ?>" required>
                          <label for="floatingInput">Nama Menu</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" id="floatingInput" placeholder="Keterangan"
                            name="keterangan" value="<?php echo $row['keterangan']; ?>" required>
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
                          <input type="number" class="form-control" id="floatingInput" placeholder="Harga"
                            name="harga" value="<?php echo $row['harga']; ?>" required>
                          <label for="floatingInput">Harga</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="Stok"
                          name="stok" value="<?php echo $row['stok']; ?>" required>
                        <label for="floatingInput">Stok</label>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="input_menu_validate" value="1234">Save
                    changes</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end edit modal -->


        <!-- Modal Delete -->
        <div class="modal fade" id="ModalDelete<?php echo $row['id_order']; ?>" tabindex="-1"
          aria-labelledby="modalDeleteLabel<?php echo $row['id_order']; ?>" aria-hidden="true">
          <div class="modal-dialog modal-md modal-fullscreen-md-down">
            <div class="modal-content">

              <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalDeleteLabel<?php echo $row['id_order']; ?>">Hapus Data Menu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/proses_delete_menu.php" method="POST">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                  <div class="col-lg-12 mb-3">
                    Apakah Anda ingin menghapus menu <b><?php echo htmlspecialchars($row['nama_menu']); ?></b>?
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="input_menu_validate"
                      value="1234">Hapus</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
        <!-- end delete -->
      <?php
      }
      ?>


    </div>
  </div>
</div>
</body>

</html>