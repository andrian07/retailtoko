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
        <h2 class="headline">Laporan PO</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Cabang</th>
                    <th>Supplier</th>
                    <th>Tax</th>
                    <th>TOP</th>
                    <th>Payment</th>
                    <th>Diskon</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $row){ ?>
                    <tr>
                        <td><?php echo $row['hd_po_invoice']; ?> </td>
                        <td><?php echo $row['hd_po_date']; ?></td>
                        <td><?php echo $row['warehouse_name']; ?> </td>
                        <td><?php echo $row['supplier_name']; ?></td>
                        <td><?php echo $row['hd_po_tax']; ?></td>
                        <td><?php echo $row['hd_po_top']; ?></td>
                        <td><?php echo $row['payment_name']; ?></td>
                        <td>Rp. <?php echo number_format($row['hd_po_total_discount']); ?></td>
                        <td>Rp. <?php echo number_format($row['hd_po_grand_total']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>