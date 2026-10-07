<!DOCTYPE html>
<html>
<head>
  <title>Print 72mm</title>
  <style>
    /* box-sizing: border-box supaya padding TIDAK menambah lebar total
       (tanpa ini, .receipt jadi 72mm + padding = lebih lebar dari kertas,
       sehingga kepotong sama rata di kiri & kanan saat print) */
    * {
      box-sizing: border-box;
    }

    body {
      font-family: monospace;
      width: 72mm;
      margin: 0;
      padding: 0;
    }

    .receipt {
      width: 72mm;
      /* printer memotong sisi kiri kertas, jadi beri padding kiri lebih besar */
      padding: 3px 3mm 3px 8.5mm;
    }

    h3, p {
      text-align: center;
      margin: 2px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 12px;
    }

    th, td {
      padding: 2px 0;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .line {
      border-top: 1px dashed #000;
      margin: 5px 0;
    }

    @media print {
      body {
        width: 72mm;
      }

      @page {
        size: 72mm auto;
        margin: 0;
      }
    }
  </style>
</head>
<body>

  <div class="receipt">
    <h3><?php echo company; ?></h3>
    <p><?php echo company_address; ?></p>
    <p>Telp: <?php echo company_phone; ?></p>

    <div class="line"></div>
    
    <?php foreach($data['header_sales'] as $header){ ?>
      <p>INV: <?php echo $header->hd_sales_inv; ?></p>
      <p>Kasir: <?php echo $header->user_name; ?></p>
      <p>Pembayaran: <?php echo $header->payment_name; ?></p>
      <p><?php echo date('d-m-Y', strtotime($header->hd_sales_date)); ?></p>
    <?php } ?>

    <div class="line"></div>

    <table style="width: 100%;">
        <tr>
            <th width="70%">Item</th>
            <th width="10%">Qty</th>
            <th width="20%" class="text-right">Total</th>
        </tr>
     <?php foreach($data['detail_sales'] as $detail){ ?>
      <tr>
        <td width="70%" style="font-size:11px; padding: 2%;"><?php echo $detail->product_name; ?><br><span style="font-size:10px;"><?php echo $detail->dt_sales_qty; ?> <?php echo $detail->unit_name; ?> x <?php echo number_format($detail->dt_sales_price, 0, ',', '.'); ?><?php if($detail->dt_sales_package_count > 0){ echo ' ('.$detail->dt_sales_package_count.' '.htmlspecialchars($detail->dt_sales_package_name).' @'.$detail->dt_sales_package_conv.')'; } ?></span></td>
        <td class="text-center" width="10%"><?php echo $detail->dt_sales_qty; ?></td>
        <td class="text-right" width="20%"><?php echo number_format($detail->dt_sales_total, 0, ',', '.'); ?></td>
      </tr>
    <?php } ?>
  </table>

  <div class="line"></div>

  <table>
   <?php foreach($data['header_sales'] as $header_sales){ ?>
    <tr>
      <td>Diskon</td>
      <td class="text-right"><?php echo number_format($header_sales->hd_sales_total_discount, 0, ',', '.'); ?></td>
    </tr>
    <tr>
      <td>Total</td>
      <td class="text-right"><?php echo number_format($header_sales->hd_sales_total, 0, ',', '.'); ?></td>
    </tr>
    <?php if(!empty($data['pay']) && $data['pay'] >= $header_sales->hd_sales_total){ ?>
    <tr>
      <td>Bayar</td>
      <td class="text-right"><?php echo number_format($data['pay'], 0, ',', '.'); ?></td>
    </tr>
    <tr>
      <td>Kembali</td>
      <td class="text-right"><?php echo number_format($data['pay'] - $header_sales->hd_sales_total, 0, ',', '.'); ?></td>
    </tr>
    <?php } ?>
  <?php } ?>
</table>

<div class="line"></div>

<p>Terima Kasih</p>
</div>

<script>
  window.onafterprint = function(){ window.close(); };
  window.onload = function(){ window.print(); };
</script>

</body>
</html>