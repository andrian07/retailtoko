<!DOCTYPE html>
<html>
<head>
    <title>Faktur Penjualan</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /*
            DOT MATRIX LANDSCAPE
            Ukuran kertas continuous form sekitar 9.5 x 5.5 inch
        */
        @page {
            size: 9.5in 5.5in;
            margin: 0.15in;
        }

        body {
            font-size: 10px;
            color: #000;
            background: #fff;
            width: 9.2in;
            line-height: 1.15;
        }

        .page {
            width: 9.2in;
            min-height: 5.15in;
            display: flex;
            flex-direction: column;
        }

        /* ================= HEADER ================= */

        .hdr {
            display: flex;
            border: 1px solid #000;
            margin-bottom: 4px;
        }

        .hdr-left {
            width: 55%;
            display: flex;
            align-items: center;
            padding: 5px;
        }

        .hdr-logo img {
            width: 42px;
            max-height: 42px;
            object-fit: contain;
            display: block;
            filter: grayscale(100%) contrast(200%);
        }

        .hdr-store {
            margin-left: 7px;
        }

        .hdr-store .sname {
            font-size: 13px;
            font-weight: bold;
            line-height: 1.1;
        }

        .hdr-store .sdoc {
            font-size: 10px;
            font-weight: bold;
            margin-top: 2px;
        }

        .hdr-store .saddr {
            font-size: 11px;
            margin-top: 3px;
            line-height: 1.3;
        }

        .hdr-right {
            width: 45%;
            padding: 5px;
            font-size: 9px;
        }

        .hdr-inv {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            border-bottom: 1px dashed #000;
            padding-bottom: 3px;
            margin-bottom: 3px;
        }

        .hdr-inv .inv-num {
            font-size: 14px;
        }

        .hdr-inv .pg-info {
            font-size: 8px;
        }

        .hdr-rows table {
            width: 100%;
            border-collapse: collapse;
        }

        .hdr-rows td {
            padding: 1px 2px;
            vertical-align: top;
            font-size: 12px;
        }

        .hdr-rows .lbl {
            width: 72px;
            white-space: nowrap;
        }

        .hdr-rows .sep {
            width: 10px;
        }


        /* ================= TABLE BARANG ================= */

        .tbl-item {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            border: 1px solid #000;
        }

        .tbl-item th {
            border: 1px solid #000;
            background: #fff !important;
            color: #000 !important;
            font-size: 9px;
            font-weight: bold;
            padding: 3px 2px;
            text-align: center;
        }

        .tbl-item td {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            border-bottom: 1px dashed #555;
            padding: 3px;
            font-size: 12px;
            vertical-align: middle;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: clip;
        }

        .tbl-item tbody tr:last-child td {
            border-bottom: 1px solid #000;
        }

        .tbl-item tbody tr:nth-child(odd),
        .tbl-item tbody tr:nth-child(even) {
            background: #fff !important;
        }

        .tc {
            text-align: center;
        }

        .tr {
            text-align: right;
        }

        .al {
            text-align: left !important;
        }

        /* ================= FOOTER ================= */

        .footer {
            display: flex;
            margin-top: 4px;
            gap: 4px;
        }

        .sign-wrap {
            width: 60%;
            display: flex;
            min-height: 78px;
        }

        .sign-col {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            padding: 5px;
            font-size: 9px;
        }

        .sign-col .slabel {
			font-size: 14px;
            text-transform: uppercase;
        }

        .sign-col .sspace {
            min-height: 38px;
        }

        .sign-col .sname {
            border-top: 1px solid #000;
            padding-top: 2px;
            font-size: 8px;
        }

        .sum-wrap {
            width: 40%;
        }

        .sum-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 3.5px 7px;
            font-size: 15.5px;
        }

        .sum-row:last-child {
            border-bottom: none;
        }

        .sum-row.grand {
            background: #1e1e1e !important;
            color: #fff !important;
            font-weight: 900;
            letter-spacing: 0.3px;
            padding: 5px 7px;
            border-bottom: none;
        }

        .sum-row.disc .slbl,
        .sum-row.disc .sval {
            color: #b50000;
        }

        .sum-row.sisa {
            font-weight: 800;
            font-size: 11px;
        }

        .slbl,
        .sval {
            white-space: nowrap;
        }

        .slbl {
            font-weight: 600;
        }

        .sval {
            font-weight: 700;
        }

        .sum-row.grand .slbl,
        .sum-row.grand .sval {
            font-weight: 900;
            color: #fff;
        }

        .page-break {
            page-break-after: always;
        }

        @media print {
            body {
                width: 9.2in;
            }

            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .page {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

<?php
    /*
        8 baris agar tulisan lebih renggang dan jelas di printer dot matrix.
    */
    $items_per_page = 15;
    $chunks         = array_chunk($data['detail_sales'], $items_per_page);
    $total_page     = count($chunks);
    $page           = 1;

    foreach ($chunks as $chunk) {
        foreach ($data['header_sales'] as $header) {
            /* bind header */
        }
?>

<div class="page">

    <!-- ================= HEADER ================= -->
    <div class="hdr">

        <div class="hdr-left">
            <div class="hdr-store">
                <div class="sname">TOKO PIONIR SUDIRMAN</div>
                <div class="sdoc">FAKTUR PENJUALAN</div>
                <div class="saddr">
                    Jl. Nusa Indah 2 Block D5 No.10-11, Pontianak<br>
                    Telp: (0561) 731219
                </div>
            </div>
        </div>

        <div class="hdr-right">

            <div class="hdr-inv">
                <span class="inv-num"><?php echo $header->hd_sales_inv; ?></span>
                <span class="pg-info">Hal <?php echo $page; ?> / <?php echo $total_page; ?></span>
            </div>

            <div class="hdr-rows">
                <table>
                    <tr>
                        <td class="lbl">Tanggal</td>
                        <td class="sep">:</td>
                        <td class="val"><?php echo $header->hd_sales_date; ?></td>
                    </tr>

                    <tr>
                        <td class="lbl">Pembayaran</td>
                        <td class="sep">:</td>
                        <td class="val"><?php echo $header->payment_name; ?></td>
                    </tr>

                    <tr>
                        <td class="lbl">Kepada</td>
                        <td class="sep">:</td>
                        <td class="val">
                            <?php echo $header->customer_name; ?>
                            <?php
                                if (!empty($header->customer_phone)) {
                                    echo ' / ' . $header->customer_phone;
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="lbl">Alamat</td>
                        <td class="sep">:</td>
                        <td class="val">
                            <?php echo $header->customer_address; ?>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

    </div>

    <!-- ================= TABLE BARANG ================= -->
    <div class="tbl-wrap">

        <table class="tbl-item">

            <colgroup>
                <col style="width:5%">
                <col style="width:8%">
                <col style="width:13%">
                <col style="width:39%">
                <col style="width:17.5%">
                <col style="width:17.5%">
            </colgroup>

            <thead>
                <tr>
                    <th>NO</th>
                    <th>QTY</th>
                    <th>SKU</th>
                    <th class="al">NAMA BARANG</th>
                    <th>HARGA SAT.</th>
                    <th>JUMLAH</th>
                </tr>
            </thead>

            <tbody>

                <?php
                    $no = 1 + (($page - 1) * $items_per_page);

                    foreach ($chunk as $row) {
                ?>
                    <tr>
                        <td class="tc"><?php echo $no++; ?></td>
                        <td class="tc"><?php echo $row->dt_sales_qty; ?>x</td>
                        <td><?php echo $row->product_code; ?></td>
                        <td><?php echo $row->product_name; ?></td>
                        <td class="tr"><?php echo number_format($row->dt_sales_price); ?></td>
                        <td class="tr"><?php echo number_format($row->dt_sales_total); ?></td>
                    </tr>
                <?php } ?>

                <!-- Baris kosong agar tabel tetap rapi -->
                <?php for ($i = count($chunk); $i < $items_per_page; $i++) { ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>

    </div>

    <?php if ($page == $total_page) { ?>

        <!-- ================= FOOTER ================= -->
        <div class="footer">

            <!-- TANDA TANGAN -->
            <div class="sign-wrap">

                <div class="sign-col">
                    <div class="slabel">Penerima</div>
                    <div class="sspace"></div>
                    <div class="sname">(........................)</div>
                </div>

                <div class="sign-col">
                    <div class="slabel">Hormat Kami</div>
                    <div class="sspace"></div>
                    <div class="sname">(........................)</div>
                </div>

            </div>

            <!-- TOTAL -->
            <div class="sum-wrap">

                <?php
                    $discount = !empty($header->hd_sales_total_discount)
                        ? (int)$header->hd_sales_total_discount
                        : 0;

                    $ppn = !empty($header->hd_sales_ppn)
                        ? (int)$header->hd_sales_ppn
                        : 0;

                    $subtotal = (int)$header->hd_sales_total + $discount - $ppn;
                ?>

                <div class="sum-row">
                    <span class="slbl">Sub Total</span>
                    <span class="sval">Rp <?php echo number_format($subtotal); ?></span>
                </div>

                <?php if ($discount > 0) { ?>
                    <div class="sum-row">
                        <span class="slbl">Diskon</span>
                        <span class="sval">Rp <?php echo number_format($discount); ?></span>
                    </div>
                <?php } ?>

                <?php if ($ppn > 0) { ?>
                    <div class="sum-row">
                        <span class="slbl">PPN 11%</span>
                        <span class="sval">Rp <?php echo number_format($ppn); ?></span>
                    </div>
                <?php } ?>

                <div class="sum-row grand">
                    <span class="slbl">TOTAL FAKTUR</span>
                    <span class="sval">Rp <?php echo number_format($header->hd_sales_total); ?></span>
                </div>

                <?php if (!empty($header->hd_sales_dp) && $header->hd_sales_dp > 0) { ?>
                    <div class="sum-row">
                        <span class="slbl">DP / Bayar</span>
                        <span class="sval">Rp <?php echo number_format($header->hd_sales_dp); ?></span>
                    </div>
                <?php } ?>

            </div>

        </div>

    <?php } ?>

</div>

<?php if ($page < $total_page) { ?>
    <div class="page-break"></div>
<?php } ?>

<?php
        $page++;
    }
?>

</body>
</html>