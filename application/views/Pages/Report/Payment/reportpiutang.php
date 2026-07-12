<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
<style type="text/css">
  /* ===== Filter Card ===== */
  .filter-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(31, 78, 121, 0.10);
  }
  .filter-card .card-header {
    background: linear-gradient(135deg, #1F4E79 0%, #2E75B6 100%);
    border-radius: 12px 12px 0 0;
    padding: 14px 22px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .filter-card .card-header .header-title {
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    margin: 0;
  }
  .filter-card .card-header i {
    color: rgba(255,255,255,0.85);
    font-size: 16px;
  }
  .filter-card .card-body {
    background: #f8fafd;
    border-radius: 0 0 12px 12px;
    padding: 20px 22px 10px;
  }
  .filter-card label {
    font-size: 12px;
    font-weight: 600;
    color: #1F4E79;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
  }
  .filter-card .form-control {
    border-radius: 7px;
    border: 1px solid #c9d9ea;
    font-size: 13px;
    background: #fff;
  }
  .filter-card .form-control:focus {
    border-color: #2E75B6;
    box-shadow: 0 0 0 3px rgba(46,117,182,0.12);
  }
  .btn-filter-search {
    background: linear-gradient(135deg, #1F4E79, #2E75B6);
    border: none;
    color: #fff;
    border-radius: 7px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: opacity 0.2s;
  }
  .btn-filter-search:hover { opacity: 0.88; color: #fff; }
  .btn-filter-excel {
    background: linear-gradient(135deg, #c07a00, #f0a500);
    border: none;
    color: #fff;
    border-radius: 7px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: opacity 0.2s;
  }
  .btn-filter-excel:hover { opacity: 0.88; color: #fff; }

  /* ===== Preview Card ===== */
  .preview-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(31, 78, 121, 0.10);
    margin-top: 18px;
  }
  .preview-card .card-header {
    background: #fff;
    border-radius: 12px 12px 0 0;
    border-bottom: 2px solid #e3edf7;
    padding: 12px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .preview-card .card-header .preview-title {
    font-size: 14px;
    font-weight: 700;
    color: #1F4E79;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
  }
  .preview-card .card-header .preview-title i {
    color: #2E75B6;
  }
  .preview-card .card-body {
    padding: 0;
    border-radius: 0 0 12px 12px;
    overflow: hidden;
    position: relative;
  }
  .preview-card iframe {
    display: block;
    width: 100%;
    height: 1000px;
    border: none;
    border-radius: 0 0 12px 12px;
  }
  #iframe-loading {
    position: absolute;
    inset: 0;
    background: #f8fafd;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    z-index: 10;
    border-radius: 0 0 12px 12px;
  }
  #iframe-loading .spinner-border { color: #2E75B6; width: 2.5rem; height: 2.5rem; }
  #iframe-loading span { color: #2E75B6; font-size: 13px; font-weight: 600; }

  /* ===== Page Header ===== */
  .report-page-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
  }
  .report-page-header .report-icon-wrap {
    width: 46px; height: 46px;
    background: linear-gradient(135deg, #1F4E79, #2E75B6);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .report-page-header .report-icon-wrap i { color: #fff; font-size: 20px; }
  .report-page-header h3 { margin: 0; font-size: 20px; font-weight: 700; color: #1F4E79; }
  .report-page-header p  { margin: 2px 0 0; font-size: 12px; color: #6c8eae; }
</style>
</div>

<div class="container">
  <div class="page-inner">

    <!-- ===== Page Header ===== -->
    <div class="report-page-header">
      <div class="report-icon-wrap">
        <i class="fas fa-hand-holding-usd"></i>
      </div>
      <div>
        <h3>Laporan Pembayaran Piutang</h3>
        <p>Monitoring transaksi pembayaran piutang dari pelanggan</p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">

        <!-- ===== Filter Card ===== -->
        <div class="card filter-card">
          <div class="card-header">
            <i class="fas fa-filter"></i>
            <span class="header-title">Filter Laporan</span>
          </div>
          <div class="card-body">
            <form>
              <div class="row align-items-end g-3">

                <div class="col-sm-6 col-md-3">
                  <div class="form-group mb-0">
                    <label><i class="far fa-calendar-alt me-1"></i>Tanggal Dari</label>
                    <input type="date" class="form-control" id="start_date" value="<?php echo date('Y-m-01'); ?>">
                  </div>
                </div>

                <div class="col-sm-6 col-md-3">
                  <div class="form-group mb-0">
                    <label><i class="far fa-calendar-alt me-1"></i>Tanggal Sampai</label>
                    <input type="date" class="form-control" id="end_date" value="<?php echo date('Y-m-d'); ?>">
                  </div>
                </div>

                <div class="col-sm-6 col-md-2">
                  <div class="form-group mb-0">
                    <label><i class="fas fa-user me-1"></i>Pelanggan</label>
                    <select class="form-control js-example-basic-single" id="customer_report" name="customer_report">
                      <option value="">-- Semua Pelanggan --</option>
                      <?php foreach ($data['customer_list'] as $row) { ?>
                        <option value="<?php echo $row->customer_id; ?>"><?php echo $row->customer_name; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6 col-md-2">
                  <div class="form-group mb-0">
                    <label><i class="fas fa-tag me-1"></i>Status</label>
                    <select class="form-control js-example-basic-single" id="status" name="status">
                      <option value="Success">Success</option>
                      <option value="Pending">Pending</option>
                      <option value="Cancel">Cancel</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6 col-md-2">
                  <div class="d-flex gap-2 pt-1">
                    <button id="btnsearch" type="button" class="btn btn-filter-search">
                      <i class="fas fa-search"></i> Tampilkan
                    </button>
                    <button id="btndownloadexcell" type="button" class="btn btn-filter-excel">
                      <i class="fas fa-file-excel"></i> Excel
                    </button>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
        <!-- End Filter Card -->

        <!-- ===== Preview Card ===== -->
        <div class="card preview-card">
          <div class="card-header">
            <span class="preview-title">
              <i class="fas fa-eye"></i> Preview Laporan Pembayaran Piutang
            </span>
            <small class="text-muted" id="preview-period"></small>
          </div>
          <div class="card-body">
            <div id="iframe-loading">
              <div class="spinner-border" role="status"></div>
              <span>Memuat laporan...</span>
            </div>
            <iframe id="preview"
              src="<?php echo base_url(); ?>Reportpayment/reportpiutangpdf"
              width="100%" height="1000px"
              onload="document.getElementById('iframe-loading').style.display='none'">
            </iframe>
          </div>
        </div>
        <!-- End Preview Card -->

      </div>
    </div>
  </div>

  <?php 
  require DOC_ROOT_PATH . $this->config->item('footer');
  ?>

  <script type="text/javascript">
    function buildUrl(base) {
      let start_date      = $('#start_date').val();
      let end_date        = $('#end_date').val();
      let customer_report = $('#customer_report').val();
      let status          = $('#status').val();
      return base
        + '&start_date='      + start_date
        + '&end_date='        + end_date
        + '&customer_report=' + customer_report
        + '&status='          + status;
    }

    function showLoading() {
      $('#iframe-loading').show();
    }

    $('#btnsearch').click(function(e) {
      e.preventDefault();
      showLoading();
      let url = buildUrl('<?php echo base_url(); ?>Reportpayment/reportpiutangpdf?');
      $('#preview').attr('src', url);
      let sd = $('#start_date').val();
      let ed = $('#end_date').val();
      $('#preview-period').text('Periode: ' + sd + '  s/d  ' + ed);
    });

    $('#btndownloadexcell').click(function(e) {
      e.preventDefault();
      let url = buildUrl('<?php echo base_url(); ?>Reportpayment/reportpiutang_excell?');
      window.open(url, '_blank');
    });

    // Set periode label on initial load
    $('#preview-period').text('Periode: ' + $('#start_date').val() + '  s/d  ' + $('#end_date').val());
  </script>