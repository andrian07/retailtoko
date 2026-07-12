<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Laporan Laba Rugi</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: DejaVu Sans, Arial, sans-serif;
      font-size: 12px;
      color: #222;
      background: #fff;
      padding: 24px 28px;
    }

    /* ── Header ── */
    .doc-header {
      border-bottom: 3px solid #1F4E79;
      padding-bottom: 12px;
      margin-bottom: 20px;
    }
    .doc-header .company { font-size: 17px; font-weight: bold; color: #1F4E79; }
    .doc-header .report-title {
      font-size: 13px; font-weight: bold; color: #2E75B6; margin-top: 2px;
    }
    .doc-header .period { font-size: 11px; color: #555; margin-top: 3px; }
    .doc-header .print-date { font-size: 10px; color: #888; float: right; margin-top: -38px; }

    /* ── Summary Table ── */
    .section-title {
      font-size: 11px; font-weight: bold; text-transform: uppercase;
      letter-spacing: 0.5px; color: #fff;
      background: #1F4E79;
      padding: 6px 10px;
      border-radius: 4px 4px 0 0;
    }
    .pl-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 18px;
    }
    .pl-table td {
      padding: 7px 10px;
      border: 1px solid #cdd9e5;
      font-size: 12px;
    }
    .pl-table .row-label { width: 70%; }
    .pl-table .row-value { width: 30%; text-align: right; }
    .pl-table .row-indent td { padding-left: 24px; background: #fafcfe; }
    .pl-table .row-sub td   { background: #ebf3fb; font-weight: bold; }
    .pl-table .row-header td {
      background: #2E75B6; color: #fff; font-weight: bold;
    }
    .pl-table .row-total-green td {
      background: #1a6b1a; color: #fff; font-weight: bold; font-size: 13px;
    }
    .pl-table .row-total-red td {
      background: #8b1a1a; color: #fff; font-weight: bold; font-size: 13px;
    }
    .pl-table .row-deduct td { color: #c0392b; }

    /* ── Detail Table ── */
    .detail-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 4px;
    }
    .detail-table th {
      background: #2E75B6; color: #fff;
      padding: 7px 8px; font-size: 11px; text-align: center;
      border: 1px solid #1F4E79;
    }
    .detail-table td {
      padding: 6px 8px; font-size: 11px;
      border: 1px solid #cdd9e5;
    }
    .detail-table .num { text-align: right; }
    .detail-table .center { text-align: center; }
    .detail-table tbody tr:nth-child(even) td { background: #f0f6fc; }
    .detail-table tfoot td {
      background: #1F4E79; color: #fff; font-weight: bold; font-size: 11px;
    }
    .detail-table tfoot .num { text-align: right; }

    /* positive/negative laba */
    .laba-pos { color: #1a6b1a; font-weight: bold; }
    .laba-neg { color: #8b1a1a; font-weight: bold; }

    .spacer { height: 8px; }
    .page-break { page-break-after: always; }
  </style>
</head>
<body>

<?php
$d = $data;
function rupiah($n) {
    return 'Rp ' . number_format($n, 0, ',', '.');
}
?>

<!-- ── Document Header ── -->
<div class="doc-header">
  <div class="print-date">Dicetak: <?php echo date('d/m/Y H:i'); ?></div>
  <div class="company">CV. ANUGRAH HARAPAN UTAMA</div>
  <div class="report-title">LAPORAN LABA RUGI</div>
  <div class="period">
    Periode: <?php echo date('d F Y', strtotime($d['start_date'])); ?>
    &nbsp;&ndash;&nbsp;
    <?php echo date('d F Y', strtotime($d['end_date'])); ?>
  </div>
</div>

<!-- ── Pendapatan ── -->
<div class="section-title">I. PENDAPATAN</div>
<table class="pl-table">
  <tr class="row-indent">
    <td class="row-label">Penjualan Bruto</td>
    <td class="row-value"><?php echo rupiah($d['total_sales']); ?></td>
  </tr>
  <tr class="row-indent row-deduct">
    <td class="row-label">Retur Penjualan</td>
    <td class="row-value">(<?php echo rupiah($d['total_retur_sales']); ?>)</td>
  </tr>
  <tr class="row-sub">
    <td class="row-label">Penjualan Bersih</td>
    <td class="row-value"><?php echo rupiah($d['penjualan_bersih']); ?></td>
  </tr>
</table>

<div class="spacer"></div>

<!-- ── HPP ── -->
<div class="section-title">II. HARGA POKOK PENJUALAN (HPP)</div>
<table class="pl-table">
  <tr class="row-indent">
    <td class="row-label">HPP (biaya pokok barang terjual)</td>
    <td class="row-value"><?php echo rupiah($d['total_hpp']); ?></td>
  </tr>
  <tr class="row-indent row-deduct">
    <td class="row-label">Retur HPP</td>
    <td class="row-value">(<?php echo rupiah($d['total_hpp_retur']); ?>)</td>
  </tr>
  <tr class="row-sub">
    <td class="row-label">HPP Bersih</td>
    <td class="row-value"><?php echo rupiah($d['hpp_bersih']); ?></td>
  </tr>
</table>

<div class="spacer"></div>

<!-- ── Laba Kotor ── -->
<?php $isProfit = $d['laba_kotor'] >= 0; ?>
<table class="pl-table">
  <tr class="<?php echo $isProfit ? 'row-total-green' : 'row-total-red'; ?>">
    <td class="row-label" style="font-size:13px;">
      <?php echo $isProfit ? 'LABA KOTOR' : 'RUGI KOTOR'; ?>
    </td>
    <td class="row-value" style="font-size:13px;">
      <?php echo rupiah(abs($d['laba_kotor'])); ?>
    </td>
  </tr>
</table>

<div class="spacer"></div><div class="spacer"></div>

<!-- ── Detail per Produk ── -->
<div class="section-title">III. RINCIAN LABA PER PRODUK</div>
<?php if (empty($d['detail'])): ?>
  <p style="padding:10px; color:#888; font-size:11px;">Tidak ada data penjualan pada periode ini.</p>
<?php else: ?>
<table class="detail-table">
  <thead>
    <tr>
      <th style="width:4%">No</th>
      <th style="width:13%">Kode</th>
      <th style="width:33%">Nama Produk</th>
      <th style="width:10%">Qty Terjual</th>
      <th style="width:18%">HPP/Unit</th>
      <th style="width:18%">Total Penjualan</th>
      <th style="width:18%">Laba</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $grand_qty   = 0;
    $grand_jual  = 0;
    $grand_laba  = 0;
    $no = 1;
    foreach ($d['detail'] as $row):
        $grand_qty  += $row['qty_jual'];
        $grand_jual += $row['total_jual'];
        $grand_laba += $row['laba'];
        $laba_class = $row['laba'] >= 0 ? 'laba-pos' : 'laba-neg';
    ?>
    <tr>
      <td class="center"><?php echo $no++; ?></td>
      <td><?php echo htmlspecialchars($row['product_code']); ?></td>
      <td><?php echo htmlspecialchars($row['product_name']); ?></td>
      <td class="num"><?php echo number_format($row['qty_jual'], 0, ',', '.'); ?></td>
      <td class="num"><?php echo rupiah($row['product_hpp']); ?></td>
      <td class="num"><?php echo rupiah($row['total_jual']); ?></td>
      <td class="num <?php echo $laba_class; ?>"><?php echo rupiah($row['laba']); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="3" style="text-align:center">TOTAL</td>
      <td class="num"><?php echo number_format($grand_qty, 0, ',', '.'); ?></td>
      <td></td>
      <td class="num"><?php echo rupiah($grand_jual); ?></td>
      <td class="num"><?php echo rupiah($grand_laba); ?></td>
    </tr>
  </tfoot>
</table>
<?php endif; ?>

</body>
</html>
