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
        <h2 class="headline">Laporan Produk</h2>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Satuan</th>
                    <th>Katogori</th>
                    <th>Brand</th>
                    <th>Supplier</th>
                    <th>HPP</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($data as $row){ 
                    ?>
                    <tr>
                        <td><?php echo $row['product_code']; ?> </td>
                        <td><?php echo $row['product_name']; ?> </td>
                        <td><?php echo $row['unit_name']; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td><?php echo $row['brand_name']; ?></td>
                        <td><?php echo $row['product_supplier_tag']; ?></td>
                        <td><?php echo number_format($row['product_hpp']); ?></td>
                    </tr>
                    <?php 
                } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>