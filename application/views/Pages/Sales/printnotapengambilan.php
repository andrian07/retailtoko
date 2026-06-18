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

        .receipt-inner {
            border: 1px solid #000;
            box-sizing: border-box;
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

<div class="receipt" style="text-align: center;">
    <div class="receipt-inner">
    <h1>TOKO PIONIR
    <br />0853 8672 0722
    <br />PTK</h1>
    <div class="line"></div>
    <h2> <?php echo $data['header_sales'][0]->customer_name; ?></h2>

    <h2 style="margin-top: 80px;"> <?php echo $data['header_sales'][0]->customer_address; ?>

    <h2 style="margin-top: 50px;">Via Datang Ambil</h2>
    <h2>Jumlah Colly: <?php echo $data['header_sales'][0]->hd_sales_colly; ?> X</h2>
    </div>
</div>

</body>
</html>