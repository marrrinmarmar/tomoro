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
$result = [];

if (isset($_GET['order'])) {
    $order_id = $_GET['order'];

    $query = mysqli_query($conn, "
        SELECT *, SUM(harga * jumlah) AS harganya 
        FROM tb_list_order 
        LEFT JOIN tb_order ON tb_order.id_order = tb_list_order.order
        LEFT JOIN tb_daftar_menu ON tb_daftar_menu.id = tb_list_order.menu
        WHERE tb_list_order.order = '$order_id'
        GROUP BY tb_list_order.id_list_order
    ");

    if ($query) {
        while ($record = mysqli_fetch_array($query)) {
            $result[] = $record;
            $kode = $record['kode_order'];
            $meja = $record['meja'];
            $pelanggan = $record['pelanggan'];
        }
    } else {
        echo "Query gagal: " . mysqli_error($conn);
    }
} else {
    echo "Order ID tidak dikirim.";
}
?>

<div class="col-lg-9 mt-2">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      Halaman Order Item
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="kode" value="<?php echo $kode; ?>">
            <label for="uploadFoto">Kode Order</label>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="meja" value="<?php echo $meja; ?>">
            <label for="uploadFoto">Nomor Meja</label>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="pelanggan" value="<?php echo $pelanggan; ?>">
            <label for="uploadFoto">Pelanggan</label>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#ModalTambahUser">Tambah Menu</button>
      </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Menu</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Qty</th>
                  <th scope="col">Total</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total = 0 ;
                foreach ($result as $row) {
                ?>
                  <tr>

                    <td><?php echo $row['nama_menu']; ?></td>
                    <td><?php echo $row['harga']; ?></td>
                    <td><?php echo $row['jumlah']; ?></td>
                    <td><?php echo $row['harganya']; ?></td>

                    <td>
                      <div class="d-flex">

                        <!-- Tombol View -->
                        <button class="btn btn-info btn-sm me-1" data-bs-toggle="modal"
                          data-bs-target="#ModalView<?php echo $row['id_order']; ?>">
                          <i class="bi bi-eye"></i>
                        </button>

                        <!-- Tombol Edit -->
                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal"
                          data-bs-target="#ModalEdit<?php echo $row['id_order']; ?>">
                          <i class="bi bi-pencil"></i>
                        </button>

                        <!-- Tombol Hapus -->
                        <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal"
                        data-bs-target="#ModalDelete<?php echo $row['id_order']; ?>">
                        <i class="bi bi-trash"></i>
                        </button>
                        
                        </div>
                        </td>
                        </tr>
                        <?php
                        $total += $row['harganya'];
                      }
                      ?>
                      <tr>
                        <td colspan="3" class="fw-bold">
                          Total Harga
                        </td>
                        <td class="fw-bold">
                          <?php 
                          echo $total;
                          ?>
                        </td>
                      </tr>
                      </tbody>
                      </table>
                      </div>
                      </div>
                      </div>
                      <?php
                      // Bagian TAMPILAN
                      if (!empty($result)) {
                          foreach ($result as $item) {
                              echo $item['nama_menu'] . " - " . $item['jumlah'] . "x<br>";
                          }
                      } else {
                          echo "<p style='color: gray;'>Tidak ada data untuk pesanan ini.</p>";
                      }
                      ?>
                      
                      <!-- Modal tambah menu baru -->
                      <div class="modal fade" id="ModalTambahUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                      aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-md-down">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="needs-validation" novalidate action="proses/proses_input_menu.php"
                method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="input-group mb-3">
                      <input type="file" class="form-control" id="uploadFoto"
                        placeholder="Your Name" name="foto" required>
                      <label class="input-group-text" for="uploadFoto">Upload Foto Menu</label>
                      <div class="invalid-feedback">
                        Masukkan Foto Menu.
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput"
                        placeholder="Nama Menu" name="nama_menu" required>
                      <label for="floatingInput">Nama Menu</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput"
                        placeholder="Keterangan" name="keterangan" required>
                      <label for="floatingInput">Keterangan</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-floating">
                      <select class="form-select" name="kat_menu"
                        aria-label="Default select example" required>
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
                      <input type="number" class="form-control" id="floatingInput"
                        placeholder="Harga" name="harga" required>
                      <label for="floatingInput">Harga</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="floatingInput" placeholder="Stok"
                      name="stok" required>
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
    <!-- Modal tambah menu baru END -->

    <?php
    foreach ($result as $row) {
    ?>
      <!-- Modal VIEW-->
      <div class="modal fade" id="ModalView<?php echo $row['id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <div class="menu-image-container" style="width: 200px; height: 200px;">
                        <img src="assets/img/<?php echo $row['foto']; ?>" class="menu-image"
                          alt="...">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput"
                        placeholder="Nama Menu" name="nama_menu"
                        value="<?php echo $row['nama_menu']; ?>" readonly>
                      <label for="floatingInput">Nama Menu</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput"
                        placeholder="Keterangan" name="kat_menu"
                        value="<?php echo $row['keterangan']; ?>" readonly>
                      <label for="floatingInput">Keterangan</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-floating">
                      <select class="form-select" name="kat_menu" aria-label="Default select example"
                        disabled>
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
                      <input type="number" class="form-control" id="floatingInput" placeholder="Harga"
                        name="harga" value="<?php echo $row['harga']; ?>" readonly>
                      <label for="floatingInput">Harga</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="floatingInput" placeholder="Stok"
                      name="stok" value="<?php echo $row['stok']; ?>" readonly>
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
  <div class="modal fade" id="ModalEdit<?php echo $row['id']; ?>" tabindex="-1" role="dialog"
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
<div class="modal fade" id="ModalDelete<?php echo $row['id']; ?>" tabindex="-1"
  aria-labelledby="modalDeleteLabel<?php echo $row['id']; ?>" aria-hidden="true">
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

    if (empty($result)) {
      echo  "Data user tidak ada";
    }
?>

</div>
</div>
</div>
</body>

</html>