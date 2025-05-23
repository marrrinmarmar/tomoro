<?php
session_start();
include "proses/connect.php";

// Get order ID from URL parameter
$order_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$order_id) {
    die("Order ID tidak ditemukan");
}

// Get order details
$query_order = mysqli_query($conn, "SELECT o.*, u.nama as nama_pelanggan 
                                   FROM tb_order o 
                                   LEFT JOIN tb_user u ON o.id_user = u.id 
                                   WHERE o.id = '$order_id'");
$order = mysqli_fetch_assoc($query_order);

// Get order items
$query_items = mysqli_query($conn, "SELECT oi.*, m.nama_menu 
                                   FROM tb_order_item oi 
                                   JOIN tb_menu m ON oi.id_menu = m.id 
                                   WHERE oi.id_order = '$order_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Order #<?php echo $order_id; ?></title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .info {
            margin-bottom: 20px;
        }
        .items {
            width: 100%;
            margin-bottom: 20px;
        }
        .items th {
            text-align: left;
            border-bottom: 1px dashed #000;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.8em;
        }
        @media print {
            body {
                width: 80mm;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="kefein.png" alt="Decafe Logo">
        <h2>Decafe</h2>
        <p>Jl. Contoh No. 123<br>Telp: (021) 123-4567</p>
    </div>

    <div class="info">
        <p>No. Order: <?php echo $order_id; ?><br>
        Tanggal: <?php echo date('d/m/Y H:i', strtotime($order['tanggal'])); ?><br>
        Pelanggan: <?php echo htmlspecialchars($order['nama_pelanggan']); ?></p>
    </div>

    <table class="items">
        <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
        <?php
        $total = 0;
        while ($item = mysqli_fetch_assoc($query_items)) {
            $subtotal = $item['jumlah'] * $item['harga'];
            $total += $subtotal;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item['nama_menu']); ?></td>
                <td><?php echo $item['jumlah']; ?></td>
                <td><?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                <td><?php echo number_format($subtotal, 0, ',', '.'); ?></td>
            </tr>
        <?php } ?>
    </table>

    <div class="total">
        <p>Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></p>
    </div>

    <div class="footer">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()">Print Struk</button>
    </div>
</body>
</html>