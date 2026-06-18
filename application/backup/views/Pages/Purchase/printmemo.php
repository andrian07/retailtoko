<!DOCTYPE html>
<html>
<head>
    <title>Memo</title>

    <style>

        @page{
            size: 21.59cm 13.97cm;
            margin:0;
        }

        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:12px;
            margin:0;
            padding:30px;
            background:#808080;
        }

/* halaman tengah */
.page{
    display:flex;
    justify-content:center;
    margin-bottom:30px;
}

.container{
    width:21.59cm;
    min-height:13.97cm;
    background:#fff;
    border:2px solid #000;
    padding:15px;
    box-sizing:border-box;

    display:flex;
    flex-direction:column;
}

/* isi utama */
.content{
    flex:1;
}

.footer-wrapper{
    margin-top:auto;
}

table{
    border-collapse:collapse;
    width:100%;
}

td,th{
    padding:4px;
}

.header-table td{
    vertical-align:top;
}

.info-table{
    border:1px solid #000;
}

.info-table td{
    border:1px solid #000;
    text-align:center;
}

.item-table th,
.item-table td{
    border:1px solid #000;
}

.item-table th{
    background:#f2f2f2;
}

.text-center{
    text-align:center;
}

.text-left{
    text-align:left;
}

.footer-table{
    border:1px solid #000;
}

.footer-table td{
    border:1px solid #000;
    text-align:center;
}

.page-break{
    page-break-before: always;
}

@media print{

    body{
        background:none;
        padding:0;
    }

    .page{
        margin:0;
    }

    .container{
        border:none;
        padding:0;
    }

}

</style>

</head>

<body>

    <?php
        $limit = 5;
        $total = count($data['detail_po']);
        $pages = ceil($total / $limit);
        $number = 1;
    ?>

    <?php for($p=0; $p<$pages; $p++){ ?>

        <div class="page">

            <div class="container">

                <div class="content">

<!-- HEADER -->
<table class="header-table">
    <tr>

        <td width="20%" align="center">
            <img src="<?php echo base_url(); ?>assets/logo.png" width="80">
        </td>

        <td width="40%">
            <span style="color:#FE0000;font-size:24px;font-weight:bold;">TOKO PIONIR</span><br>
            Jl. Sungai Raya Dalam 1 No A2<br>
            Kabupaten Kubu Raya, Kalimantan Barat<br>
            Telp: 0812-3456-7890 Email: pionir.toko@gmail.com
        </td>

        <td width="40%">
            <table class="info-table">
                <tr>
                    <td colspan="2">
                        Pionir <?php echo $data['header_po'][0]->hd_po_invoice; ?>
                    </td>
                </tr>

                <tr>
                    <td width="30%">Tgl</td>
                    <td width="70%">
                        <?php 
                            $date = $data['header_po'][0]->hd_po_date;
                            echo date('d F Y', strtotime($date)); 
                        ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2"><b>PIONIR</b></td>
                </tr>
            </table>
        </td>

    </tr>
</table>

<hr>

<!-- TITLE -->
<table>
    <tr>
        <td align="center">
            <b style="font-size:15px;">MEMO PENGAMBILAN BARANG</b>
        </td>
    </tr>
</table>

<br>

<!-- FROM TO -->
<table>
    <tr>

        <td width="50%">
            <b>Kepada</b><br>
            <?php echo $data['header_po'][0]->supplier_name; ?>
        </td>

        <td width="50%">
            <b>Dari</b><br>
            Toko Pionir<br>
            Jl. Sungai Raya Dalam 1 No A2<br>
            Kabupaten Kubu Raya
        </td>

    </tr>
</table>

<br>

<!-- ITEM -->
<table class="item-table">

    <tr class="text-center">
        <th width="5%">No</th>
        <th width="45%">Nama Barang</th>
        <th width="10%">Qty</th>
        <th width="15%">Satuan</th>
        <th width="25%">Catatan</th>
    </tr>

    <?php
        $start = $p * $limit;
        $end = min($start + $limit, $total);

        for($i=$start; $i<$end; $i++){
            $row = $data['detail_po'][$i];
        ?>

        <tr>
            <td class="text-center"><?php echo $number ?></td>
            <td class="text-left"><?php echo $row->product_name ?></td>
            <td class="text-center"><?php echo $row->dt_po_qty ?></td>
            <td class="text-center"><?php echo $row->unit_name ?></td>
            <td class="text-center"><?php echo $row->dt_po_note ?></td>
        </tr>

        <?php 
            $number++;
        }
    ?>

</table>

</div>

<?php if($p == $pages-1){ ?>

<div class="footer-wrapper">

    <table>
        <tr>
            <td width="50%"></td>

            <td width="50%">

                <table class="footer-table">

                    <tr>
                        <td>Dibuat Oleh</td>
                        <td>Memo Diterima</td>
                    </tr>

                    <tr>
                        <td height="40"></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Bag. Pembelian</td>
                        <td>Jaya Ar</td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</div>

<?php } ?>

</div>

</div>

<?php if($p < $pages-1){ ?>
<div class="page-break"></div>
<?php } ?>

<?php } ?>

</body>
</html>