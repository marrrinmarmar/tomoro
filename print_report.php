<?php
session_start();
include "proses/connect.php";

// Get date range from URL parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Get report data
$query = mysqli_query($conn, "SELECT 
    o.id_order,
    o.kode_order,
    o.pelanggan,
    o.meja,
    o.waktu_order,
    o.status,
    u.nama as nama_pelayan,
    SUM(lo.jumlah * dm.harga) as total_harga
FROM tb_order o
LEFT JOIN tb_user u ON o.pelayan = u.id
LEFT JOIN tb_list_order lo ON o.id_order = lo.order
LEFT JOIN tb_daftar_menu dm ON lo.menu = dm.id
WHERE DATE(o.waktu_order) BETWEEN '$start_date' AND '$end_date'
GROUP BY o.id_order
ORDER BY o.waktu_order DESC");

$total_penjualan = 0;
$total_order = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .total p {
            margin: 5px 0;
            font-size: 16px;
        }
        .total .grand-total {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="kefein.png" alt="Decafe Logo">
        <h1>Laporan Penjualan</h1>
        <p>Jl. Contoh No. 123, Jakarta</p>
        <p>Telp: (021) 123-4567</p>
    </div>

    <div class="info">
        <p><strong>Periode:</strong> <?php echo date('d/m/Y', strtotime($start_date)) . ' - ' . date('d/m/Y', strtotime($end_date)); ?></p>
        <p><strong>Tanggal Cetak:</strong> <?php echo date('d/m/Y H:i:s'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Order</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Meja</th>
                <th>Status</th>
                <th>Pelayan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($query)) {
                $total_penjualan += $row['total_harga'];
                $total_order++;
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['kode_order']; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['waktu_order'])); ?></td>
                    <td><?php echo htmlspecialchars($row['pelanggan']); ?></td>
                    <td><?php echo $row['meja']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_pelayan']); ?></td>
                    <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="total">
        <p>Total Order: <?php echo $total_order; ?> transaksi</p>
        <p class="grand-total">Total Penjualan: Rp <?php echo number_format($total_penjualan, 0, ',', '.'); ?></p>
    </div>

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh sistem</p>
        <p>© <?php echo date('Y'); ?> Decafe - All rights reserved</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #3085d6; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Print Laporan
        </button>
    </div>
</body>
</html> 