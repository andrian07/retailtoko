<!DOCTYPE html>
<html>
<head>
    <title>Purchase Order - <?php echo $data['header_po'][0]['hd_po_invoice']; ?></title>

    <style>

        /* ===== PAGE SIZE: 21.59cm x 13.97cm (Continuous Form Landscape) ===== */
        @page {
            size: 21.59cm 13.97cm;
            margin: 0.5cm 0.8cm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            background: #d0d0d0;
            padding: 20px;
            color: #222;
        }

        /* ===== PAGE WRAPPER ===== */
        .page-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
        }

        .page {
            width: 21.59cm;
            min-height: 13.97cm;
            background: #fff;
            padding: 0.5cm 0.8cm;
            position: relative;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 12px rgba(0,0,0,0.18);
        }


        /* ===== HEADER ===== */
        .po-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 3px solid #222;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .po-header .company-block {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .po-header .company-block img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .company-name {
            font-size: 18px;
            font-weight: 900;
            color: #c00;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .company-address {
            font-size: 9.5px;
            color: #444;
            margin-top: 3px;
            line-height: 1.6;
        }

        .po-badge-block {
            text-align: right;
            min-width: 280px;
        }

        .po-badge-block .po-label {
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #fff;
            background: #222;
            padding: 3px 12px;
            display: inline-block;
            border-radius: 4px;
            margin-bottom: 6px;
        }

        .po-info-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
        }

        .po-info-table td {
            border: 1px solid #aaa;
            padding: 3px 7px;
        }

        .po-info-table td:first-child {
            font-weight: 700;
            background: #f5f5f5;
            width: 40%;
        }

        /* ===== DIVIDER ===== */
        .section-divider {
            border: none;
            border-top: 1px solid #bbb;
            margin: 8px 0;
        }

        /* ===== FROM / TO ===== */
        .parties-row {
            display: flex;
            gap: 16px;
            margin-bottom: 10px;
        }

        .party-box {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 6px 10px;
            background: #fafafa;
        }

        .party-box .party-label {
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #888;
            margin-bottom: 3px;
        }

        .party-box .party-name {
            font-size: 11px;
            font-weight: 700;
            color: #222;
        }

        .party-box .party-detail {
            font-size: 10px;
            color: #555;
            margin-top: 1px;
        }

        /* ===== ITEM TABLE ===== */
        .section-title {
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #888;
            margin-bottom: 5px;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }

        .item-table thead tr {
            background: #222;
            color: #fff;
        }

        .item-table thead th {
            padding: 5px 8px;
            text-align: center;
            font-weight: 700;
            letter-spacing: 0.3px;
            border: 1px solid #333;
        }

        .item-table tbody td {
            border: 1px solid #ccc;
            padding: 4px 8px;
            vertical-align: middle;
        }

        .item-table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .item-table tbody td.no-col   { text-align: center; width: 5%; }
        .item-table tbody td.name-col { text-align: left;   width: 55%; }
        .item-table tbody td.qty-col  { text-align: center; width: 12%; }
        .item-table tbody td.unit-col { text-align: center; width: 15%; }

        /* empty filler rows */
        .item-table tbody tr.empty-row td {
            color: #ccc;
            border-color: #e0e0e0;
        }

        /* ===== FOOTER SUMMARY ===== */
        .footer-inner {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-top: 8px;
        }

        .remark-block {
            flex: 1;
        }

        .remark-block .remark-label {
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #888;
            margin-bottom: 4px;
        }

        .remark-box {
            border: 1px solid #ccc;
            border-radius: 4px;
            min-height: 50px;
            padding: 6px 8px;
            font-size: 10px;
            color: #444;
            background: #fafafa;
        }

        .summary-block {
            min-width: 220px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }

        .summary-table tr {
            border-bottom: 1px solid #e0e0e0;
        }

        .summary-table td {
            padding: 4px 8px;
        }

        .summary-table td:first-child {
            color: #555;
            font-weight: 600;
        }

        .summary-table td:last-child {
            text-align: right;
            font-weight: 700;
        }

        .summary-table tr.grand-total-row {
            border-top: 2px solid #222;
            border-bottom: 2px solid #222;
        }

        .summary-table tr.grand-total-row td {
            font-size: 11.5px;
            font-weight: 900;
            color: #222;
        }

        /* ===== SIGNATURE ===== */
        .signature-row {
            display: flex;
            justify-content: space-between;
            margin-top: 16px;
            gap: 10px;
        }

        .sig-box {
            flex: 1;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px 6px 6px;
        }

        .sig-box .sig-title {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #666;
            margin-bottom: 36px;
        }

        .sig-box .sig-line {
            border-top: 1px solid #888;
            margin-top: 4px;
            padding-top: 3px;
            font-size: 9px;
            color: #888;
        }

        /* ===== PAGE NUMBER ===== */
        .page-number {
            text-align: right;
            font-size: 8.5px;
            color: #aaa;
            margin-top: 8px;
        }

        /* ===== CONTINUED BADGE ===== */
        .continued-badge {
            text-align: center;
            font-size: 9px;
            color: #888;
            font-style: italic;
            padding-top: 8px;
        }

        /* ===== PRINT ===== */
        @media print {
            html, body {
                background: none;
                padding: 0 !important;
                margin: 0 !important;
                height: auto !important;
                overflow: visible;
            }

            .page-wrap {
                margin: 0;
                display: block;
            }

            .page {
                box-shadow: none;
                width: 100%;
                height: auto;
                overflow: visible;
                page-break-after: always;
            }

            .page-wrap:last-of-type .page {
                page-break-after: avoid !important;
            }

            .page-break {
                display: none;
            }
        }

        .page-break {
            page-break-before: always;
        }

    </style>
</head>

<body>

    <?php
        $limit = 8;
        $total = count($data['detail_po']);
        $pages = ceil($total / $limit);
        if ($pages == 0) $pages = 1;
        $number = 1;
        $hd = $data['header_po'][0];
    ?>

    <?php for ($p = 0; $p < $pages; $p++): ?>

        <div class="page-wrap">
        <div class="page">
        <div class="content">

            <!-- ===== HEADER ===== -->
            <div class="po-header">
                <div class="company-block">
                    <img src="<?php echo base_url(); ?>assets/logo.png" alt="Logo">
                    <div>
                        <div class="company-name">TOKO PIONIR</div>
                        <div class="company-address">
                            Jl. Sungai Raya Dalam 1 No A2<br>
                            Telp: 0812-3456-7890 &nbsp;|&nbsp; pionir.toko@gmail.com
                        </div>
                    </div>
                </div>

                <div class="po-badge-block">
                    <div class="po-label">Purchase Order</div>
                    <table class="po-info-table">
                        <tr>
                            <td>No. PO</td>
                            <td><strong><?php echo $hd['hd_po_invoice']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td><?php echo date('d F Y', strtotime($hd['hd_po_date'])); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- ===== PARTIES ===== -->
            <?php if ($p == 0): ?>
            <div class="parties-row">
                <div class="party-box">
                    <div class="party-label">Kepada (Supplier)</div>
                    <div class="party-name"><?php echo $hd['supplier_name']; ?></div>
                </div>
                <div class="party-box">
                    <div class="party-label">Dari (Pembeli)</div>
                    <div class="party-name">Toko Pionir</div>
                    <div class="party-detail">Jl. Sungai Raya Dalam 1 No A2, Kab. Kubu Raya</div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ===== ITEM TABLE ===== -->
            <div class="section-title">Daftar Item</div>
            <table class="item-table">
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:55%;text-align:left;">Nama Barang</th>
                        <th style="width:12%">Qty</th>
                        <th style="width:15%">Harga</th>
                        <th style="width:15%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $start = $p * $limit;
                        $end   = min($start + $limit, $total);
                        for ($i = $start; $i < $end; $i++):
                            $row = $data['detail_po'][$i];
                    ?>
                    <tr>
                        <td class="no-col"><?php echo $number; ?></td>
                        <td class="name-col"><?php echo $row['product_name']; ?></td>
                        <td class="qty-col"><?php echo $row['dt_po_qty']; ?> <?php echo $row['unit_name']; ?></td>
                        <td class="unit-col">Rp <?php echo number_format($row['dt_po_price'], 0, ',', '.'); ?></td>
                        <td class="total-col">Rp <?php echo number_format($row['dt_po_qty'] * $row['dt_po_price'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php
                            $number++;
                        endfor;

                        /* Filler rows agar tabel selalu penuh */
                        $filled = $end - $start;
                        for ($f = $filled; $f < $limit; $f++):
                    ?>
                    <tr class="empty-row">
                        <td class="no-col">&nbsp;</td>
                        <td class="name-col">&nbsp;</td>
                        <td class="qty-col">&nbsp;</td>
                        <td class="unit-col">&nbsp;</td>
                        <td class="total-col">&nbsp;</td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>

            <?php if ($p < $pages - 1): ?>
                <div class="continued-badge">... bersambung ke halaman berikutnya ...</div>
            <?php endif; ?>

        </div><!-- .content -->

        <!-- ===== FOOTER (hanya halaman terakhir) ===== -->
        <?php if ($p == $pages - 1): ?>
        <div class="footer-wrapper">
            <hr class="section-divider">

            <div class="footer-inner">
                <div class="remark-block">
                    <div class="remark-label">Catatan</div>
                    <div class="remark-box">
                        <?php echo !empty($hd['hd_po_remark']) ? nl2br(htmlspecialchars($hd['hd_po_remark'])) : '&nbsp;'; ?>
                    </div>
                </div>

                <div class="summary-block">
                    <table class="summary-table">
                        <tr>
                            <td>Sub Total</td>
                            <td>Rp <?php echo number_format($hd['hd_po_sub_total'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php if (!empty($hd['hd_po_total_discount']) && $hd['hd_po_total_discount'] > 0): ?>
                        <tr>
                            <td>Diskon</td>
                            <td>Rp <?php echo number_format($hd['hd_po_total_discount'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($hd['hd_po_ppn']) && $hd['hd_po_ppn'] > 0): ?>
                        <tr>
                            <td>PPN 11%</td>
                            <td>Rp <?php echo number_format($hd['hd_po_ppn'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr class="grand-total-row">
                            <td>Grand Total</td>
                            <td>Rp <?php echo number_format($hd['hd_po_grand_total'], 0, ',', '.'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Page number -->
        <div class="page-number">
            Halaman <?php echo ($p + 1); ?> dari <?php echo $pages; ?>
        </div>

        </div><!-- .page -->
        </div><!-- .page-wrap -->

        <?php if ($p < $pages - 1): ?>
            <div class="page-break"></div>
        <?php endif; ?>

    <?php endfor; ?>

</body>
</html>