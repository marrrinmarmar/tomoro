<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- http://localhost/decafe/?x=orderitem&order=19 -->
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

// Ambil ID order dari URL
$id_order = isset($_GET['order']) ? $_GET['order'] : null;

// Kalau kosong, hentikan dan redirect
if (!$id_order) {
    echo "<script>alert('Order tidak ditemukan.'); window.location='order';</script>";
    exit;
}

// Query dengan KUTIP di nilai
$order_query = mysqli_query($conn, "SELECT * FROM tb_list_order WHERE `order` = '$id_order'");

if (!$order_query) {
    echo "Query error: " . mysqli_error($conn);
    exit;
}
?>


// Ambil item-item pesanan
$item_query = mysqli_query($conn, "
    SELECT tb_list_order.*, tb_daftar_menu.nama_menu, tb_daftar_menu.harga 
    FROM tb_list_order 
    LEFT JOIN tb_daftar_menu ON tb_list_order.menu = tb_daftar_menu.id 
    WHERE tb_list_order.order = '$id_order'
");

$items = [];
while ($item = mysqli_fetch_assoc($item_query)) {
    $items[] = $item;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container py-4">
    <h3 class="mb-4">Order #<?= $id_order ?> - <?= $order['pelanggan'] ?> (Meja <?= $order['meja'] ?>)</h3>

    <!-- Form Tambah Item -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-success text-white">
        <strong><i class="bi bi-plus-circle me-1"></i>Tambah Item Pesanan</strong>
      </div>
      <div class="card-body">
        <form action="proses/proses_tambah_item.php" method="POST" class="row g-3">
          <input type="hidden" name="id_order" value="<?= $id_order; ?>">

          <div class="col-md-6">
            <label class="form-label">Menu</label>
            <select name="id_menu" class="form-select" required>
              <option selected disabled>Pilih Menu</option>
              <?php
              $menu = mysqli_query($conn, "SELECT * FROM tb_daftar_menu");
              while ($m = mysqli_fetch_assoc($menu)) {
                echo "<option value='{$m['id']}'>{$m['nama_menu']} - Rp {$m['harga']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
          </div>

          <div class="col-md-3 d-flex align-items-end">
            <button type="submit" name="tambah_item_validate" value="123" class="btn btn-success w-100">
              <i class="bi bi-plus-lg me-1"></i>Tambah
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Tabel Item -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-primary text-white">
        <strong><i class="bi bi-list-ul me-1"></i> Daftar Item Pesanan</strong>
      </div>
      <div class="card-body p-0">
        <table class="table table-bordered mb-0">
          <thead class="table-light">
            <tr>
              <th>Nama Menu</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $total = 0;
            foreach ($items as $item) {
              $sub_total = $item['harga'] * $item['jumlah'];
              $total += $sub_total;
              echo "<tr>
        <td>{$item['nama_menu']}</td>
        <td>Rp {$item['harga']}</td>
        <td>{$item['jumlah']}</td>
        <td>Rp $sub_total</td>
      </tr>";
            }
            ?>
            <tr class="fw-bold table-secondary">
              <td colspan="3" class="text-end">Total Harga</td>
              <td>Rp <?= $total; ?></td>
            </tr>
          </tbody>

        </table>
      </div>
    </div>

    <!-- Form Update Status dan Bayar -->
    <div class="card mb-4 shadow-sm">
      <div class="card-body">
        <form action="proses/proses_status_bayar.php" method="POST" class="row g-2">
          <input type="hidden" name="id_order" value="<?= $id_order; ?>">
          <input type="hidden" name="total" value="<?= $total; ?>">

          <div class="col-md-4">
            <label class="form-label">Status Order</label>
            <select name="status" class="form-select">
              <option <?= $order['status'] == "diproses" ? "selected" : ""; ?>>diproses</option>
              <option <?= $order['status'] == "diantar" ? "selected" : ""; ?>>diantar</option>
              <option <?= $order['status'] == "dibayar" ? "selected" : ""; ?>>dibayar</option>
            </select>
          </div>

          <div class="col-md-4 d-flex align-items-end">
            <button type="submit" name="update_status" value="1" class="btn btn-warning w-100">
              <i class="bi bi-pencil-square me-1"></i>Update Status
            </button>
          </div>

          <div class="col-md-4 d-flex align-items-end">
            <button type="submit" name="bayar" value="1" class="btn btn-primary w-100">
              <i class="bi bi-cash me-1"></i>Bayar & Selesai
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</body>

</html>