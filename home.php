<?php
include "proses/connect.php";

// Tanggal hari ini
$today = date('Y-m-d');

// Ringkasan Hari Ini
$summary_query = mysqli_query($conn, "
  SELECT 
    COALESCE(SUM(tb_list_order.jumlah * tb_daftar_menu.harga), 0) AS total_pendapatan,
    COUNT(DISTINCT tb_order.id_order) AS jumlah_transaksi,
    COALESCE(SUM(tb_list_order.jumlah), 0) AS menu_terjual
  FROM tb_order
  JOIN tb_list_order ON tb_order.id_order = tb_list_order.order
  JOIN tb_daftar_menu ON tb_list_order.menu = tb_daftar_menu.id
  WHERE tb_order.status = 'dibayar'
    AND DATE(tb_order.tanggal) = '$today'
");

$summary = mysqli_fetch_assoc($summary_query);

// Customer baru (hari ini)
$customer_query = mysqli_query($conn, "
  SELECT COUNT(*) AS total_customer
  FROM tb_customer
  WHERE DATE(tanggal_kunjungan_terakhir) = '$today'
");
$customer_today = mysqli_fetch_assoc($customer_query);

// Data grafik penjualan 7 hari terakhir
$chart_query = mysqli_query($conn, "
  SELECT DATE(tanggal) AS tanggal, 
         COALESCE(SUM(tb_list_order.jumlah * tb_daftar_menu.harga), 0) AS total
  FROM tb_order
  JOIN tb_list_order ON tb_order.id_order = tb_list_order.order
  JOIN tb_daftar_menu ON tb_list_order.menu = tb_daftar_menu.id
  WHERE tb_order.status = 'dibayar'
    AND tanggal >= CURDATE() - INTERVAL 6 DAY
  GROUP BY DATE(tanggal)
  ORDER BY tanggal
");

$tanggal_chart = [];
$total_chart = [];
while ($row = mysqli_fetch_assoc($chart_query)) {
    $tanggal_chart[] = date('d M', strtotime($row['tanggal']));
    $total_chart[] = (int)$row['total'];
}

// Menu stok rendah
$stok_query = mysqli_query($conn, "
  SELECT nama_menu, stok 
  FROM tb_daftar_menu 
  WHERE stok <= 5
  ORDER BY stok ASC
");

// Transaksi terbaru
$order_query = mysqli_query($conn, "
  SELECT tb_order.id_order, tb_order.pelanggan, tb_order.meja, tb_order.status, 
         SUM(tb_list_order.jumlah * tb_daftar_menu.harga) AS total
  FROM tb_order
  JOIN tb_list_order ON tb_order.id_order = tb_list_order.order
  JOIN tb_daftar_menu ON tb_list_order.menu = tb_daftar_menu.id
  WHERE tb_order.status = 'dibayar'
  GROUP BY tb_order.id_order
  ORDER BY tb_order.tanggal DESC
  LIMIT 5
");
?>
<div class="col-lg-9 mt-2">
  <div class="card">
<div class="container py-4">
<div class="container py-4">
  <h3>Dashboard</h3>
  <div class="row mt-3">
    <div class="col-md-3">
      <div class="card text-white bg-success mb-3">
        <div class="card-body">
          <h6>Total Pendapatan Hari Ini</h6>
          <h4>Rp <?= number_format($summary['total_pendapatan'], 0, ',', '.') ?></h4>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-primary mb-3">
        <div class="card-body">
          <h6>Jumlah Transaksi</h6>
          <h4><?= $summary['jumlah_transaksi'] ?></h4>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-warning mb-3">
        <div class="card-body">
          <h6>Menu Terjual</h6>
          <h4><?= $summary['menu_terjual'] ?> pcs</h4>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-info mb-3">
        <div class="card-body">
          <h6>Customer Baru</h6>
          <h4><?= $customer_today['total_customer'] ?></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Grafik Penjualan -->
  <div class="card mb-4">
    <div class="card-header bg-secondary text-white fw-bold">
      <i class="bi bi-graph-up"></i> Grafik 7 Hari Terakhir
    </div>
    <div class="card-body">
      <canvas id="chart7" height="80"></canvas>
    </div>
  </div>

  <!-- Stok Menipis -->
  <div class="card mb-4">
    <div class="card-header bg-danger text-white fw-bold">
      <i class="bi bi-exclamation-triangle"></i> Menu Stok Hampir Habis
    </div>
    <div class="card-body">
      <ul>
        <?php while ($stok = mysqli_fetch_assoc($stok_query)) { ?>
          <li><?= htmlspecialchars($stok['nama_menu']) ?> - <?= $stok['stok'] ?> pcs</li>
        <?php } ?>
      </ul>
    </div>
  </div>

  <!-- Transaksi Terakhir -->
  <div class="card">
    <div class="card-header bg-dark text-white fw-bold">
      <i class="bi bi-clock-history"></i> Transaksi Terakhir
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered">
        <thead class="table-light">
          <tr>
            <th>ID Order</th>
            <th>Nama</th>
            <th>Meja</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($o = mysqli_fetch_assoc($order_query)) { ?>
            <tr>
              <td><?= $o['id_order'] ?></td>
              <td><?= htmlspecialchars($o['pelanggan']) ?></td>
              <td><?= $o['meja'] ?></td>
              <td>Rp <?= number_format($o['total'], 0, ',', '.') ?></td>
              <td><span class="badge bg-success"><?= $o['status'] ?></span></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chart7').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($tanggal_chart) ?>,
    datasets: [{
      label: 'Pendapatan',
      data: <?= json_encode($total_chart) ?>,
      borderColor: 'rgba(75, 192, 192, 1)',
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
      borderWidth: 2,
      tension: 0.3,
      fill: true
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: value => 'Rp ' + value.toLocaleString('id-ID')
        }
      }
    }
  }
});
</script>
</div>
  </div>
</div>
