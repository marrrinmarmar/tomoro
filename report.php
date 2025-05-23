<?php
include "proses/connect.php";

// Validasi dan sanitasi input tanggal
$tanggal_awal = isset($_GET['dari']) ? date('Y-m-d', strtotime($_GET['dari'])) : date('Y-m-01');
$tanggal_akhir = isset($_GET['sampai']) ? date('Y-m-d', strtotime($_GET['sampai'])) : date('Y-m-d');

// Pastikan tanggal awal tidak lebih besar dari tanggal akhir
if ($tanggal_awal > $tanggal_akhir) {
    $temp = $tanggal_awal;
    $tanggal_awal = $tanggal_akhir;
    $tanggal_akhir = $temp;
}

// Total Pendapatan & Jumlah Transaksi
$total_query = mysqli_query($conn, "
  SELECT 
    COALESCE(SUM(tb_list_order.jumlah * tb_daftar_menu.harga), 0) AS total_pendapatan,
    COUNT(DISTINCT tb_order.id_order) AS jumlah_transaksi
  FROM tb_order
  JOIN tb_list_order ON tb_order.id_order = tb_list_order.order
  JOIN tb_daftar_menu ON tb_list_order.menu = tb_daftar_menu.id
  WHERE tb_order.status = 'dibayar'
    AND DATE(tb_order.tanggal) BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
");

if (!$total_query) {
    die("Error: " . mysqli_error($conn));
}

$total_data = mysqli_fetch_assoc($total_query);

// Menu Terlaris
$menu_terlaris = mysqli_query($conn, "
  SELECT 
    tb_daftar_menu.nama_menu, 
    COALESCE(SUM(tb_list_order.jumlah), 0) AS total_terjual
  FROM tb_list_order
  JOIN tb_order ON tb_list_order.order = tb_order.id_order
  JOIN tb_daftar_menu ON tb_list_order.menu = tb_daftar_menu.id
  WHERE tb_order.status = 'dibayar'
    AND DATE(tb_order.tanggal) BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
  GROUP BY tb_list_order.menu, tb_daftar_menu.nama_menu
  ORDER BY total_terjual DESC
  LIMIT 5
");

if (!$menu_terlaris) {
    die("Error: " . mysqli_error($conn));
}

// Data per hari untuk grafik
$chart_query = mysqli_query($conn, "
  SELECT 
    DATE(tb_order.tanggal) AS tanggal, 
    COALESCE(SUM(tb_list_order.jumlah * tb_daftar_menu.harga), 0) AS total_harian
  FROM tb_order
  JOIN tb_list_order ON tb_order.id_order = tb_list_order.order
  JOIN tb_daftar_menu ON tb_list_order.menu = tb_daftar_menu.id
  WHERE tb_order.status = 'dibayar'
    AND DATE(tb_order.tanggal) BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
  GROUP BY DATE(tb_order.tanggal)
  ORDER BY tanggal
");

if (!$chart_query) {
    die("Error: " . mysqli_error($conn));
}

$tanggal_chart = [];
$total_chart = [];
while ($c = mysqli_fetch_assoc($chart_query)) {
  $tanggal_chart[] = date('d/m/Y', strtotime($c['tanggal']));
  $total_chart[] = (int)$c['total_harian'];
}
?>

<!-- Filter Tanggal -->
<div class="col-lg-9 mt-2">
<div class="card">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Laporan Penjualan</h3>
    <button onclick="printReport()" class="btn btn-primary">
      <i class="bi bi-printer"></i> Print Laporan
    </button>
  </div>
  <form class="row g-3 mb-4" method="GET">
    <input type="hidden" name="x" value="report">
    <div class="col-md-3">
      <label class="form-label">Dari Tanggal</label>
      <input type="date" name="dari" class="form-control" value="<?= $tanggal_awal ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Sampai Tanggal</label>
      <input type="date" name="sampai" class="form-control" value="<?= $tanggal_akhir ?>">
    </div>
    <div class="col-md-3 d-flex align-items-end">
      <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Tampilkan</button>
    </div>
  </form>

  <!-- Ringkasan -->
  <div class="row mb-4">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Total Pendapatan</h5>
          <h3>Rp <?= number_format($total_data['total_pendapatan'], 0, ',', '.') ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Jumlah Transaksi</h5>
          <h3><?= number_format($total_data['jumlah_transaksi'], 0, ',', '.') ?></h3>
        </div>
      </div>
    </div>
  </div>

  <!-- Menu Terlaris -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white fw-bold">
      <i class="bi bi-star-fill me-1"></i> Menu Terlaris
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead class="table-light">
          <tr>
            <th>Menu</th>
            <th>Jumlah Terjual</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if (mysqli_num_rows($menu_terlaris) > 0) {
            while ($m = mysqli_fetch_assoc($menu_terlaris)) { 
          ?>
            <tr>
              <td><?= htmlspecialchars($m['nama_menu']) ?></td>
              <td><?= number_format($m['total_terjual'], 0, ',', '.') ?></td>
            </tr>
          <?php 
            }
          } else {
          ?>
            <tr>
              <td colspan="2" class="text-center">Tidak ada data penjualan</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Grafik -->
  <div class="card shadow-sm">
    <div class="card-header bg-success text-white fw-bold">
      <i class="bi bi-bar-chart-line me-1"></i> Grafik Penjualan Harian
    </div>
    <div class="card-body">
      <canvas id="salesChart" height="100"></canvas>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('salesChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?= json_encode($tanggal_chart) ?>,
      datasets: [{
        label: 'Pendapatan Harian',
        data: <?= json_encode($total_chart) ?>,
        backgroundColor: 'rgba(0, 123, 255, 0.2)',
        borderColor: 'rgba(0, 123, 255, 1)',
        borderWidth: 2,
        fill: true,
        tension: 0.3,
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return 'Rp ' + value.toLocaleString('id-ID');
            }
          }
        }
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              return 'Rp ' + context.raw.toLocaleString('id-ID');
            }
          }
        }
      }
    }
  });

  function printReport() {
    const startDate = document.querySelector('input[name="dari"]').value;
    const endDate = document.querySelector('input[name="sampai"]').value;
    window.open(`print_report.php?start_date=${startDate}&end_date=${endDate}`, '_blank');
  }
</script>
