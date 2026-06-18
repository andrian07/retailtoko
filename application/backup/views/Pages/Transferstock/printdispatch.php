<!DOCTYPE html>

<html>
<head>
    <title>Surat Jalan</title>
    <style>
        body{
            font-family: "Courier New", monospace;
            font-size:13px;
            margin:0;
            padding:0;
        }

    .container{
        width:900px;
        margin:auto;
    }

    table{
        width:100%;
        border-collapse:collapse;
    }

    td,th{
        padding:4px;
    }

    .text-right{ text-align:right; }
    .text-center{ text-align:center; }

    .box{
        border:1px solid #000;
        padding:8px;
    }

    .table-item{
        border:1px solid #000;
    }

    .table-item th{
        border-bottom:1px solid #000;
        border-right:1px solid #000;
    }

    .table-item td{
        border-right:1px dotted #000;
    }

    .table-item th:last-child,
    .table-item td:last-child{
        border-right:none;
    }

    .page-break{
        page-break-after:always;
    }

    @media print{
        @page{
            margin:5mm;
        }
    }
</style>

</head>

<body>

<div class="container">
<!-- HEADER -->
<table>
    <tr>
        <td width="60%">
            <b style="font-size:20px;">TOKO PIONIR SUDIRMAN</b><br>
            JL NUSA INDAH 2 BLOCK D5 NO.10-11<br>
            PONTIANAK<br>
            (0561) 731219
        </td>

        <td width="40%">
            <div class="box">
                <b>SURAT JALAN</b><br><br>
                Tanggal : <?php echo $data['header_transfer'][0]->hd_transfer_stock_date; ?><br>
                No : <?php echo $data['header_transfer'][0]->hd_transfer_stock_code; ?>
            </div>
        </td>
    </tr>
</table>

<br>

<!-- TABLE -->
<table class="table-item">
    <thead>
        <tr>
            <th>NO</th>
            <th>KODE</th>
            <th>NAMA BARANG</th>
            <th>Satuan</th>
            <th>QTY</th>
            <th>Dari</th>
            <th>Ke</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>

        <?php $no=1; foreach($data['detail_transfer'] as $row){ ?>
        <tr>
            <td class="text-center"><?php echo $no++; ?></td>
            <td><?php echo $row['product_code']; ?></td>
            <td><?php echo $row['product_name']; ?></td>
            <td><?php echo $row['unit_name']; ?></td>
            <td class="text-center"><?php echo $row['dt_transfer_stock_qty']; ?></td>
            <td><?php echo $row['from']; ?></td>
            <td><?php echo $row['to']; ?></td>
            <td><?php echo $row['dt_transfer_stock_note']; ?></td>
        </tr>
        <?php } ?>

    </tbody>
</table>

<br>

<!-- FOOTER -->
<table>
    <tr>
        <td width="33%" class="text-center">
            Harmat Kami<br><br><br><br>
            (....................)
        </td>
        <td width="33%" class="text-center">
            Penerima<br><br><br><br>
            (....................)
        </td>
        <td width="33%" class="text-center">
            Driver<br><br><br><br>
            (....................)
        </td>
    </tr>
</table>
</div>

</body>
</html>
