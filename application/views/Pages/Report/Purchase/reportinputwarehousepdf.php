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
        <h2 class="headline">Laporan Penginputan Gudang</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Gudang</th>
                    <th>No PO</th>
                    <th>Status Input Pemebelian</th>
                    <th>Keterangan</th>
                    <th>Dibuat Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($data as $row){ 
                    ?>
                    <tr>
                        <td><?php echo $row['hd_input_stock_inv']; ?> </td>
                        <td><?php echo $row['hd_input_stock_date']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['warehouse_name']; ?> </td>
                        <td><?php echo $row['hd_po_invoice']; ?></td>
                        <td><?php echo $row['hd_input_stock_status']; ?></td>
                        <td><?php echo $row['hd_input_stock_desc']; ?></td>
                        <td><?php echo $row['user_name']; ?></td>
                    </tr>
                    <?php 
                    } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>