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
        <h2 class="headline">Laporan Piutang Jatuh Tempo</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Tanggal Jatuh Tempo</th>
                    <th>Tanggal Penjualan</th>
                    <th>Pelanggan</th>
                    <th>No Telpon</th>
                    <th>Total Nota</th>
                    <th>DP 1</th>
                    <th>Sisa Hutang</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $row){ ?>
                    <tr>
                        <td><?php echo $row['hd_sales_inv']; ?> </td>
                        <td><?php echo $row['hd_sales_due_date']; ?></td>
                        <td><?php echo $row['hd_sales_date']; ?></td>
                        <td><?php echo $row['customer_name']; ?> </td>
                        <td><?php echo $row['customer_phone']; ?></td>
                        <td>Rp. <?php echo number_format($row['hd_sales_total']); ?></td>
                        <td>Rp. <?php echo number_format($row['hd_sales_dp']); ?></td>
                        <td>Rp. <?php echo number_format($row['hd_sales_remaining_debt']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>