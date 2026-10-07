<?php

/*
    Faktur Penjualan / Surat Jalan untuk printer dot matrix.

    Satu halaman = kertas continuous 24.1 x 13.97 cm, konten dicetak di lebar 21.3cm bagian tengah, 9 item per halaman.

    Header toko + info faktur dicetak ulang di setiap halaman.

    $print_mode : 'invoice' (default) atau 'dispatch' (surat jalan, tanpa harga)
*/

$print_mode = isset($print_mode) ? $print_mode : 'invoice';

$is_invoice = $print_mode == 'invoice';


$header = $data['header_sales'][0];

$items  = $data['detail_sales'];


// setiap 9 item dipotong ke halaman baru

$rows_per_page = 9;

$pages      = $items ? array_chunk($items, $rows_per_page) : array(array());

$total_page = count($pages);


if (!function_exists('print_terbilang')) {

    function print_terbilang($n)
    {
        $n = abs((int) $n);

        $w = array(
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas'
        );

        if ($n < 12) {
            return $w[$n];
        }

        if ($n < 20) {
            return print_terbilang($n - 10) . ' belas';
        }

        if ($n < 100) {
            return print_terbilang(intdiv($n, 10)) . ' puluh ' . print_terbilang($n % 10);
        }

        if ($n < 200) {
            return 'seratus ' . print_terbilang($n - 100);
        }

        if ($n < 1000) {
            return print_terbilang(intdiv($n, 100)) . ' ratus ' . print_terbilang($n % 100);
        }

        if ($n < 2000) {
            return 'seribu ' . print_terbilang($n - 1000);
        }

        if ($n < 1000000) {
            return print_terbilang(intdiv($n, 1000)) . ' ribu ' . print_terbilang($n % 1000);
        }

        if ($n < 1000000000) {
            return print_terbilang(intdiv($n, 1000000)) . ' juta ' . print_terbilang($n % 1000000);
        }

        return print_terbilang(intdiv($n, 1000000000)) . ' milyar ' . print_terbilang($n % 1000000000);
    }

}


if (!function_exists('print_money')) {

    function print_money($n)
    {
        return number_format((float) $n, 0, ',', '.');
    }

    function print_date($d)
    {
        return $d && $d != '0000-00-00'
            ? date('d-m-Y', strtotime($d))
            : '-';
    }

}


$customer_address = trim(
    $header->customer_address . ' ' .
    ($header->customer_address_blok != '' ? 'Blok ' . $header->customer_address_blok . ' ' : '') .
    ($header->customer_address_no != '' ? 'No. ' . $header->customer_address_no : '')
);


$discount     = (int) $header->hd_sales_total_discount;

$ppn          = (int) $header->hd_sales_ppn;

$has_due_date = $header->hd_sales_due_date != $header->hd_sales_date &&
                $header->hd_sales_due_date != '0000-00-00';

$note         = trim($header->hd_sales_note) == 'POS'
                ? ''
                : trim($header->hd_sales_note);

$doc_title    = $is_invoice ? 'FAKTUR PENJUALAN' : 'SURAT JALAN';

$col_count    = $is_invoice ? 8 : 6;


$total_qty = 0;

foreach ($items as $it) {
    $total_qty += $it->dt_sales_qty;
}

?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title><?php echo $doc_title . ' ' . $header->hd_sales_inv; ?></title>

    <style>

        /* =========================================
           RESET
        ========================================= */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        /* =========================================
           UKURAN KERTAS

           Kertas fisik (paper size aktif di driver):
           24.1 x 13.97 cm

           Lebar KONTEN sengaja dibuat lebih sempit
           (21.3cm) dari lebar kertas fisik (24.1cm),
           menyisakan +/- 1.4cm kosong di kiri & kanan.
           Ini WAJIB untuk printer dot matrix: print
           head/pita tidak bisa mencetak sampai ke tepi
           kertas, apalagi di kertas continuous yang
           tepi kiri-kanannya dipakai lubang sprocket.
           Konten dipusatkan (center) di antara margin
           kiri & kanan itu.
        ========================================= */

        @page {
            size: 24.1cm 13.97cm;
            margin: 0;
        }

        /* =========================================
           KOREKSI POSISI CETAK (GESER)

           Konten sudah otomatis DITENGAHKAN secara
           horizontal. Kalau hasil print MASIH geser,
           ubah 2 angka di bawah ini saja lalu cetak
           ulang. Naikkan/turunkan sedikit demi sedikit
           (misal 0.1cm - 0.2cm setiap coba).

           - PRINT_SHIFT_DOWN : geser konten ke BAWAH
             (mengatasi hasil cetak yang KETINGGIAN)
           - PRINT_SHIFT_LEFT : geser konten ke KIRI
             (mengatasi hasil cetak yang KEKANANAN)

           Kalau sebaliknya (kurang tinggi / kurang
           ke kanan), isi dengan angka negatif,
           contoh: -0.3cm
        ========================================= */

        :root {
            --print-shift-down: 0cm;
            --print-shift-left: 0cm;
        }


        /* =========================================
           BODY
        ========================================= */

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
            background: #fff;
            line-height: 1.2;
        }


        /* =========================================
           HALAMAN

           Kertas fisik = 24.1 x 13.97 cm
           Lebar konten = 21.3cm, ditengahkan dengan
           margin kiri/kanan +/- 1.4cm (lihat komentar
           UKURAN KERTAS di atas). Tinggi konten juga
           dibuat sedikit lebih pendek dari kertas asli
           agar tidak memicu halaman kosong tambahan
           akibat pembulatan browser.

           PENTING:
           Untuk PRINT tidak menggunakan
           margin: 0 auto.
        ========================================= */

        .page {
            width: 21.3cm;
            height: 13.5cm;

            /* konten ditengahkan (1.4cm kiri/kanan) + koreksi geser manual */
            margin: calc(0.3cm + var(--print-shift-down)) 0 0 calc(1.4cm - var(--print-shift-left));
            padding: 0;

            overflow: hidden;

            page-break-after: always;
            break-after: page;
        }

        .page:last-child {
            page-break-after: auto;
            break-after: auto;
        }


        /* =========================================
           HEADER
        ========================================= */

        .hdr {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;

            padding-bottom: 4px;

            border-bottom: 2px solid #000;
        }

        .store-name {
            font-size: 17px;
            font-weight: bold;
            letter-spacing: .5px;
        }

        .store-info {
            font-size: 10px;
            margin-top: 1px;
        }

        .doc-box {
            text-align: right;
        }

        .doc-title {
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 1px;

            border: 2px solid #000;

            padding: 2px 10px;

            display: inline-block;
        }

        .doc-page {
            font-size: 10px;
            margin-top: 2px;
        }


        /* =========================================
           INFORMASI FAKTUR
        ========================================= */

        .info {
            display: flex;
            gap: 12px;
            margin: 5px 0;
        }

        .info-box {
            flex: 1;

            border: 1px solid #000;

            padding: 3px 7px;
        }

        .info-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-box td {
            padding: 0;
            vertical-align: top;

            font-size: 11px;
            line-height: 1.3;
        }

        .info-box .lbl {
            width: 78px;
            white-space: nowrap;
        }

        .info-box .sep {
            width: 9px;
        }

        .info-box .val {
            font-weight: bold;
        }

        .info-box .addr {
            font-weight: normal;
        }


        /* =========================================
           TABEL BARANG
        ========================================= */

        .items {
            width: 100%;

            border-collapse: collapse;
            table-layout: fixed;
        }

        .items th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;

            padding: 3px 4px;

            font-size: 10px;
            font-weight: bold;

            text-align: left;
        }

        .items td {
            padding: 1px 4px;

            height: 0.19in;

            font-size: 11px;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;

            border-bottom: 1px dotted #777;
        }

        .items tr.last td {
            border-bottom: 1px solid #000;
        }

        .tc {
            text-align: center !important;
        }

        .tr {
            text-align: right !important;
        }


        /* =========================================
           CONTINUED
        ========================================= */

        .continued {
            text-align: right;

            font-size: 10px;
            font-style: italic;

            padding-top: 4px;
        }


        /* =========================================
           FOOTER
        ========================================= */

        .footer {
            display: flex;

            gap: 14px;

            margin-top: 5px;
        }

        .ft-left {
            flex: 1;
            min-width: 0;
        }

        .terbilang {
            border: 1px solid #000;

            padding: 3px 7px;

            font-size: 10px;
            font-style: italic;
        }

        .terbilang b {
            font-style: normal;
        }

        .note {
            font-size: 10px;
            margin-top: 3px;
        }

        .signs {
            display: flex;

            justify-content: space-around;

            margin-top: 6px;

            text-align: center;

            font-size: 11px;
        }

        .sign {
            width: 1.7in;
        }

        .sign .space {
            height: 0.42in;
        }

        .sign .line {
            font-size: 10px;
        }


        /* =========================================
           TOTAL
        ========================================= */

        .totals {
            width: 2.9in;

            border-collapse: collapse;

            align-self: flex-start;
        }

        .totals td {
            padding: 1px 4px;

            font-size: 11px;
        }

        .totals .tval {
            text-align: right;

            font-weight: bold;

            white-space: nowrap;
        }

        .totals .grand td {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;

            font-size: 13px;
            font-weight: bold;

            padding: 3px 4px;
        }


        /* =========================================
           PRINT META
        ========================================= */

        .print-meta {
            font-size: 8px;

            margin-top: 4px;

            display: flex;

            justify-content: space-between;
        }


        /* =========================================
           PREVIEW DI LAYAR
           
           Preview tetap berada di tengah.
           Ini hanya untuk layar, bukan print.
        ========================================= */

        @media screen {

            body {
                background: #e5e7eb;
                padding: 16px 0;
            }

            .page {
                background: #fff;

                width: 21.3cm;

                margin: 0 auto 16px;

                box-shadow: 0 2px 10px rgba(0,0,0,.2);
            }

            .toolbar {
                text-align: center;

                margin-bottom: 12px;
            }

            .toolbar button {
                font-size: 14px;

                padding: 8px 20px;

                cursor: pointer;
            }

        }


        /* =========================================
           PRINT

           Saat print:
           - tidak ada margin auto
           - width 20.3 cm (ditengahkan, lihat komentar
             UKURAN KERTAS di atas)
           - height 13.5 cm
        ========================================= */

        @media print {

            .toolbar {
                display: none;
            }

            html,
            body {
                margin: 0;
                padding: 0;
            }

            .page {
                width: 21.3cm;
                height: 13.5cm;

                /* konten ditengahkan (1.4cm kiri/kanan) + koreksi geser manual */
                margin: calc(0.3cm + var(--print-shift-down)) 0 0 calc(1.4cm - var(--print-shift-left));
                padding: 0;

                overflow: hidden;

                page-break-after: always;
                break-after: page;
            }

            .page:last-child {
                page-break-after: auto;
                break-after: auto;
            }

        }

    </style>

</head>


<body>


<div class="toolbar">

    <button onclick="window.print()">
        Cetak (<?php echo $total_page; ?> halaman)
    </button>

    <div style="font-size:12px;color:#555;margin-top:6px;">
        Atur printer: paper size "Dot Metrix" (24.1 x 13.97 cm), scale 100%.
    </div>

</div>


<?php

$no = 1;

foreach ($pages as $p => $chunk) {

    $page_no = $p + 1;

    $is_last = $page_no == $total_page;

?>

<div class="page">


    <!-- ===== HEADER ===== -->

    <div class="hdr">

        <div>

            <div class="store-name">
                <?php echo company; ?>
            </div>

            <div class="store-info">
                <?php echo company_address; ?>
                &nbsp;|&nbsp;
                Telp: <?php echo company_phone; ?>
            </div>

        </div>


        <div class="doc-box">

            <div class="doc-title">
                <?php echo $doc_title; ?>
            </div>

            <div class="doc-page">
                Halaman <?php echo $page_no; ?> dari <?php echo $total_page; ?>
            </div>

        </div>

    </div>


    <!-- ===== INFO FAKTUR ===== -->

    <div class="info">


        <div class="info-box">

            <table>

                <tr>
                    <td class="lbl">
                        No. <?php echo $is_invoice ? 'Faktur' : 'Referensi'; ?>
                    </td>

                    <td class="sep">
                        :
                    </td>

                    <td class="val">
                        <?php echo $header->hd_sales_inv; ?>
                    </td>
                </tr>


                <tr>

                    <td class="lbl">
                        Tanggal
                    </td>

                    <td class="sep">
                        :
                    </td>

                    <td class="val">

                        <?php echo print_date($header->hd_sales_date); ?>

                        <?php if ($is_invoice && $has_due_date) { ?>

                            &nbsp;

                            <span class="addr">
                                Jatuh Tempo:
                            </span>

                            <?php echo print_date($header->hd_sales_due_date); ?>

                        <?php } ?>

                    </td>

                </tr>


                <?php if ($is_invoice) { ?>

                <tr>

                    <td class="lbl">
                        Pembayaran
                    </td>

                    <td class="sep">
                        :
                    </td>

                    <td class="val">

                        <?php echo $header->payment_name; ?>

                        <?php echo $header->hd_sales_remaining_debt > 0
                            ? ' (Kredit)'
                            : ' (Lunas)'; ?>

                    </td>

                </tr>

                <?php } ?>


                <tr>

                    <td class="lbl">
                        Dibuat Oleh
                    </td>

                    <td class="sep">
                        :
                    </td>

                    <td class="val">
                        <?php echo $header->user_name; ?>
                    </td>

                </tr>

            </table>

        </div>


        <div class="info-box">

            <table>

                <tr>

                    <td class="lbl">
                        Kepada
                    </td>

                    <td class="sep">
                        :
                    </td>

                    <td class="val">

                        <?php echo $header->customer_name; ?>

                        <?php echo $header->customer_code != ''
                            ? '('.$header->customer_code.')'
                            : ''; ?>

                    </td>

                </tr>


                <tr>

                    <td class="lbl">
                        Alamat
                    </td>

                    <td class="sep">
                        :
                    </td>

                    <td class="val addr">

                        <?php echo $customer_address != ''
                            ? $customer_address
                            : '-'; ?>

                    </td>

                </tr>


                <tr>

                    <td class="lbl">
                        Telp
                    </td>

                    <td class="sep">
                        :
                    </td>

                    <td class="val addr">

                        <?php echo $header->customer_phone != ''
                            ? $header->customer_phone
                            : '-'; ?>

                    </td>

                </tr>

            </table>

        </div>


    </div>


    <!-- ===== TABEL BARANG ===== -->

    <table class="items">


        <colgroup>

            <?php if ($is_invoice) { ?>

                <col style="width:5%">
                <col style="width:13%">
                <col style="width:34%">
                <col style="width:7%">
                <col style="width:8%">
                <col style="width:12%">
                <col style="width:9%">
                <col style="width:12%">

            <?php } else { ?>

                <col style="width:5%">
                <col style="width:15%">
                <col style="width:45%">
                <col style="width:9%">
                <col style="width:10%">
                <col style="width:16%">

            <?php } ?>

        </colgroup>


        <thead>

            <tr>

                <th class="tc">
                    NO
                </th>

                <th>
                    KODE
                </th>

                <th>
                    NAMA BARANG
                </th>

                <th class="tr">
                    QTY
                </th>

                <th>
                    SATUAN
                </th>


                <?php if ($is_invoice) { ?>

                    <th class="tr">
                        HARGA
                    </th>

                    <th class="tr">
                        DISKON
                    </th>

                    <th class="tr">
                        JUMLAH
                    </th>

                <?php } else { ?>

                    <th>
                        KETERANGAN
                    </th>

                <?php } ?>


            </tr>

        </thead>


        <tbody>


        <?php

        for ($i = 0; $i < $rows_per_page; $i++) {

            $row = isset($chunk[$i])
                ? $chunk[$i]
                : null;

            $cls = $i == $rows_per_page - 1
                ? ' class="last"'
                : '';

        ?>


            <?php if ($row) { ?>


                <tr<?php echo $cls; ?>>

                    <td class="tc">
                        <?php echo $no++; ?>
                    </td>


                    <td>
                        <?php echo $row->product_code; ?>
                    </td>


                    <td>
                        <?php echo $row->product_name; ?>
                    </td>


                    <td class="tr">
                        <?php echo print_money($row->dt_sales_qty); ?>
                    </td>


                    <td>
                        <?php echo $row->unit_name; ?>
                    </td>


                    <?php if ($is_invoice) { ?>


                        <td class="tr">
                            <?php echo print_money($row->dt_sales_price); ?>
                        </td>


                        <td class="tr">

                            <?php echo $row->dt_sales_discount > 0
                                ? print_money($row->dt_sales_discount)
                                : '-'; ?>

                        </td>


                        <td class="tr">
                            <?php echo print_money($row->dt_sales_total); ?>
                        </td>


                    <?php } else { ?>


                        <td>
                            <?php echo $row->dt_sales_desc; ?>
                        </td>


                    <?php } ?>


                </tr>


            <?php } else { ?>


                <tr<?php echo $cls; ?>>

                    <td colspan="<?php echo $col_count; ?>">
                        &nbsp;
                    </td>

                </tr>


            <?php } ?>


        <?php } ?>


        </tbody>


    </table>


    <?php if (!$is_last) { ?>


        <div class="continued">
            Bersambung ke halaman <?php echo $page_no + 1; ?> ...
        </div>


    <?php } else { ?>


        <!-- ===== FOOTER ===== -->

        <div class="footer">


            <div class="ft-left">


                <?php if ($is_invoice) { ?>


                    <div class="terbilang">

                        <b>Terbilang:</b>

                        <?php
                        echo ucfirst(
                            trim(
                                preg_replace(
                                    '/\s+/',
                                    ' ',
                                    print_terbilang($header->hd_sales_total)
                                )
                            )
                        );
                        ?>

                        rupiah

                    </div>


                <?php } ?>


                <div class="note">

                    <b>Catatan:</b>

                    <?php

                    echo $note != ''
                        ? htmlspecialchars($note)
                        : (
                            $is_invoice
                            ? 'Barang yang sudah dibeli tidak dapat ditukar / dikembalikan.'
                            : 'Harap periksa barang sebelum menandatangani surat jalan.'
                        );

                    ?>

                </div>


                <div class="signs">


                    <div class="sign">

                        <div>
                            Penerima
                        </div>

                        <div class="space">
                        </div>

                        <div class="line">
                            ( .............................. )
                        </div>

                    </div>


                    <?php if (!$is_invoice) { ?>


                        <div class="sign">

                            <div>
                                Pengirim
                            </div>

                            <div class="space">
                            </div>

                            <div class="line">
                                ( .............................. )
                            </div>

                        </div>


                    <?php } ?>


                    <div class="sign">

                        <div>
                            Hormat Kami
                        </div>

                        <div class="space">
                        </div>

                        <div class="line">
                            ( .............................. )
                        </div>

                    </div>


                </div>


            </div>


            <?php if ($is_invoice) { ?>


                <table class="totals">


                    <tr>

                        <td>
                            Sub Total
                        </td>

                        <td class="tval">
                            <?php echo print_money($header->hd_sales_sub_total); ?>
                        </td>

                    </tr>


                    <?php if ($discount > 0) { ?>


                        <tr>

                            <td>
                                Diskon
                            </td>

                            <td class="tval">
                                - <?php echo print_money($discount); ?>
                            </td>

                        </tr>


                    <?php } ?>


                    <?php if ($ppn > 0) { ?>


                        <tr>

                            <td>
                                PPN 11%
                            </td>

                            <td class="tval">
                                <?php echo print_money($ppn); ?>
                            </td>

                        </tr>


                    <?php } ?>


                    <tr class="grand">

                        <td>
                            TOTAL
                        </td>

                        <td class="tval">
                            Rp <?php echo print_money($header->hd_sales_total); ?>
                        </td>

                    </tr>


                    <?php if ($header->hd_sales_remaining_debt > 0) { ?>


                        <tr>

                            <td>
                                DP / Dibayar
                            </td>

                            <td class="tval">
                                <?php echo print_money($header->hd_sales_dp); ?>
                            </td>

                        </tr>


                        <tr>

                            <td>
                                <b>Sisa Tagihan</b>
                            </td>

                            <td class="tval">
                                <?php echo print_money($header->hd_sales_remaining_debt); ?>
                            </td>

                        </tr>


                    <?php } ?>


                </table>


            <?php } else { ?>


                <table class="totals">


                    <tr class="grand">

                        <td>
                            TOTAL QTY
                        </td>

                        <td class="tval">
                            <?php echo print_money($total_qty); ?>
                        </td>

                    </tr>


                    <tr>

                        <td>
                            Jumlah Item
                        </td>

                        <td class="tval">
                            <?php echo count($items); ?>
                        </td>

                    </tr>


                </table>


            <?php } ?>


        </div>


    <?php } ?>


    <div class="print-meta">

        <span>
            Dicetak:
            <?php echo date('d-m-Y H:i'); ?>
            oleh
            <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '-'; ?>
        </span>

        <span>
            <?php echo $header->hd_sales_inv; ?>
        </span>

    </div>


</div>


<?php } ?>


<script>

    window.onafterprint = function() {
        window.close();
    };

    window.onload = function() {
        window.print();
    };

</script>


</body>

</html>