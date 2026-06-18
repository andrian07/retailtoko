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
        <h2 class="headline">Laporan Pembelian</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Supplier</th>
                    <th>Cabang</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $row){ ?>
                    <tr>
                        <td><?php echo $row['hd_purchase_invoice']; ?> </td>
                        <td><?php echo $row['supplier_name']; ?></td>
                        <td><?php echo $row['warehouse_name']; ?></td>
                        <td><?php echo $row['hd_purchase_date']; ?> </td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['dt_purchase_qty']; ?></td>
                        <td>Rp. <?php echo number_format($row['dt_purchase_total']); ?></td>
                        <td>Rp. <?php echo number_format($row['hd_purchase_grand_total']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>