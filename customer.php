<?php
include "proses/connect.php";
?>
<div class="col-lg-9 mt-2">
  <div class="card">
<div class="container py-4">
  <h3 class="mb-4">Data Pelanggan</h3>

  <!-- Tabel Daftar Pelanggan -->
  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Nama</th>
        <th>No. HP</th>
        <th>Total Transaksi</th>
        <th>Jumlah Kunjungan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $pelanggan = mysqli_query($conn, "SELECT * FROM tb_customer");
      while ($p = mysqli_fetch_assoc($pelanggan)) {
        echo "<tr>
                <td>{$p['nama']}</td>
                <td>{$p['no_hp']}</td>
                <td>Rp " . number_format($p['total_transaksi']) . "</td>
                <td>{$p['jumlah_kunjungan']}</td>
                <td><button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#riwayat{$p['id_customer']}'>Lihat Riwayat</button></td>
              </tr>";
      }
      ?>
    </tbody>
  </table>

  <!-- Modal Riwayat (satu per pelanggan) -->
  <?php
  $pelanggan = mysqli_query($conn, "SELECT * FROM tb_customer");
  while ($p = mysqli_fetch_assoc($pelanggan)) {
    $id_cust = $p['id_customer'];
    $riwayat = mysqli_query($conn, "SELECT * FROM tb_order WHERE id_customer = '$id_cust' AND status = 'dibayar'");
  ?>
  
    <div class="modal fade" id="riwayat<?= $id_cust ?>" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Riwayat Transaksi - <?= $p['nama'] ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nomor Order</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($r = mysqli_fetch_assoc($riwayat)) { ?>
                  <tr>
                    <td><?= date('d/m/Y', strtotime($r['waktu_order'])) ?></td>
                    <td>#<?= $r['id_order'] ?></td>
                    <td>Rp <?= number_format($r['total']) ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
</div>
