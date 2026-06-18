<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <style type="text/css">
    body{
        margin: 0 !important;
        padding: 0 !important;
    }
    .headline{
        text-align: center;
        border-bottom: double;
    }

    table, td, th {  
        border: 1px solid #000;
        text-align: left;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 5px;
    }

    th{
        background-color: #D3D0C8;
        text-align: center;
    }

    td{
     font-size: 14px;
 }

 @page { margin: 10px; }
 body { margin: 10px; }

</style>
</head>
<body>
    <div class="container">
        <h2 class="headline">Laporan Pengajuan</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>Stock Terakhir</th>
                    <th>Status</th>
                    <th>Urgensi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($data as $row){ 
                    ?>
                    <tr>
                        <td><?php echo $row['submission_invoice']; ?> </td>
                        <td><?php echo $row['submission_date']; ?></td>
                        <td><?php echo $row['product_code']; ?> </td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['submission_qty']; ?></td>
                        <td><?php echo $row['last_stock']; ?></td>
                        <td><?php echo $row['submission_status']; ?></td>
                        <td><?php echo $row['submission_desc']; ?></td>
                        <td><?php echo $row['submission_text']; ?></td>
                    </tr>
                    <?php 
                    } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>