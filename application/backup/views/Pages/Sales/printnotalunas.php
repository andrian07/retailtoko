<!DOCTYPE html>
<html>
<head>
  <title>Print 80mm</title>
  <style>
    body {
      font-family: monospace;
      width: 76mm;
      margin: 0;
      padding: 0;
    }

    .receipt {
      width: 76mm;
      padding: 5px;
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
        width: 76mm;
      }

      @page {
        size: 80mm auto;
        margin: 0;
      }
    }
  </style>
</head>
<body>

  <div class="receipt">
    <h3>TOKO Pionir</h3>
    <p>Jl. Nusa Indah 2 <br /> Blok D5 No.10-11</p>
    <p>Telp: (0561) 731219</p>

    <div class="line"></div>
    
    <?php foreach($data['header_sales'] as $header){ ?>
      <p>INV: <?php echo $header->hd_sales_inv; ?></p>
      <p>T.O.P: <?php echo $header->hd_sales_top; ?></p>
      <p>Pembayaran: <?php echo $header->payment_name; ?></p>
      <p><?php echo date('d-m-Y', strtotime($header->hd_sales_date)); ?></p>
    <?php } ?>

    <div class="line"></div>

    <table style="width: 100%;">
        <tr>
            <th width="70%">Item</th>
            <th width="10%">Qty</th>
            <th width="20%">Harga</th>
        </tr>
     <?php foreach($data['detail_sales'] as $detail){ ?>
      <tr>
        <td width="70%" style="font-size:11px; padding: 2%;"><?php echo $detail->product_name; ?></td>
        <td class="text-center" width="10%"><?php echo $detail->dt_sales_qty; ?></td>
        <td class="text-center" width="20%"><?php echo number_format($detail->dt_sales_price, 0, ',', '.'); ?></td>
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
  <?php } ?>
</table>

<div class="line"></div>

<p>Terima Kasih</p>
</div>

</body>
</html>