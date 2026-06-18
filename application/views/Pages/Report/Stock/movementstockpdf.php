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
        <h2 class="headline">Laporan Stok</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kode Barang</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Stok Awal</th>
                    <th>Qty</th>
                    <th>Stok Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $row){ ?>
                    <tr>
                        <?php 
                        if($row['stock_movement_calculate'] == 'Plus'){
                                $status = '+';
                        }else{
                                $status = '-';
                        }    
                        ?>
                        <td><?php echo $row['product_name']; ?> </td>
                        <td><?php echo $row['product_code']; ?></td>
                        <td><?php echo $row['stock_movement_date']; ?></td>
                        <td><?php echo $row['stock_movement_desc'].'-'.$row['stock_movement_inv']; ?> </td>
                        <td><?php echo $row['stock_movement_before_stock']; ?> </td>
                        <td><?php echo $status. $row['stock_movement_qty']; ?> </td>
                        <td><?php echo $row['stock_movement_new_stock']; ?> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>