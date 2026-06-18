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
        <h2 class="headline">Laporan Pembayaran Hutang</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Nama Supplier</th>
                    <th>Tgl Pembayaran</th>
                    <th>Metode Pembayaran</th>
                    <th>Jlh Nota</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $row){ ?>
                    <tr>
                        <td><?php echo $row['payment_debt_invoice']; ?> </td>
                        <td><?php echo $row['supplier_name']; ?></td>
                        <td><?php echo $row['payment_debt_date']; ?></td>
                        <td><?php echo $row['payment_name']; ?> </td>
                        <td><?php echo $row['payment_debt_total_nota']; ?></td>
                        <td>Rp. <?php echo number_format($row['payment_debt_total_pay']); ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>