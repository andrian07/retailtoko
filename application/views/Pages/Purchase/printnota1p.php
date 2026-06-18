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

    /* add bottom border for rows with class dash */
    tr.dash td {
      border-bottom: 1px dashed #000;
      padding-bottom: 4px;
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
    <?php foreach($data['header_po'] as $header){ ?>
    <h3><?php echo date('d-m-Y', strtotime($header->hd_po_date)); ?></h3>
    <?php } ?>

    <div class="line"></div>
    
    <?php foreach($data['header_po'] as $header){ ?>
      <p><?php echo $header->hd_po_invoice; ?></p>
      <p><?php echo $header->warehouse_name; ?></p>
    <?php } ?>

    <div class="line"></div>

    <table style="width: 100%;">
        <tr>
            <th width="70%">Item</th>
            <th width="10%">PCS</th>
            <th width="20%">Harga</th>
        </tr>
     <?php foreach($data['detail_po'] as $detail){ ?>
      <tr class="dash">
        <td width="70%" style="font-size:11px; padding: 2%;"><?php echo $detail->product_name; ?><br /><br /><br /><br /><br /></td>
        <td class="text-center" width="10%"><?php echo $detail->dt_po_qty; ?><br /><br /><br /><br /><br /></td>
        <td class="text-center" width="20%"><?php echo number_format($detail->dt_po_price, 0, ',', '.'); ?><br /><br /><br /><br /><br /></td>
      </tr>
    <?php } ?>
  </table>
 
</div>

</body>
</html>