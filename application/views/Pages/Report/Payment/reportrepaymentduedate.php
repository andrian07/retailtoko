<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
<style type="text/css">
  .card-pricing .specification-list li {
    font-size: 13px;
  }
  .card.card-pricing {
    height: 602px;
  }
  .card-pricing .specification-list li {
    border-bottom: 1px solid #000 !important;
  }
</style>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">

    </div>
    <div class="row">
      <h3 class="fw-bold mb-3">Laporan Piutang Jatuh Tempo </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-body">
              <form>
                <div class="row">
                  <div class="col-sm-3">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Tanggal Jatuh Tempo Dari:</label>
                      <input type="date" class="form-control input-full" id="start_date" value="<?php echo date('Y-m-01'); ?>">
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Tanggal Jatuh Tempo Sampai:</label>
                      <input type="date" class="form-control input-full" id="end_date" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Pelanggan:</label>
                      <select class="form-control input-full js-example-basic-single" id="customer_report" name="customer_report">
                        <option value="">-- Pilih Customer --</option>
                        <?php foreach ($data['customer_list'] as $row) { ?>
                          <option value="<?php echo $row->customer_id; ?>"><?php echo $row->customer_name; ?></option>  
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-2">
                    <!-- text input -->
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <div class="form-group">
                        <div class="btn-group">
                          <button id="btnsearch" type="button" class="btn btn-primary">Cari</button>
                          <button id="btndownloadexcell" type="button" class="btn btn-warning" style="margin-left: 10px;">Excell</button>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <iframe id="preview" src="<?php echo base_url(); ?>Reportpayment/reportrepaymentduedatepdf" width="100%" height="1000px"></iframe>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php 
  require DOC_ROOT_PATH . $this->config->item('footer');
  ?>

  <script type="text/javascript">

    $('#btnsearch').click(function(e) {
      e.preventDefault();
      let start_date       = $('#start_date').val();
      let end_date         = $('#end_date').val();
      let customer_report  = $('#customer_report').val();

      let url = '<?php echo base_url(); ?>Reportpayment/reportrepaymentduedatepdf?';
      url += '&start_date=' + start_date;
      url += '&end_date=' + end_date;
      url += '&customer_report=' + customer_report;
      $('#preview').attr('src', url);
    })


    $('#btndownloadexcell').click(function(e) {
      e.preventDefault();
      let start_date       = $('#start_date').val();
      let end_date         = $('#end_date').val();
      let customer_report  = $('#customer_report').val();
      let url = '<?php echo base_url(); ?>Reportpayment/reportrepaymentduedate_excell?';
      url += '&start_date=' + start_date;
      url += '&end_date=' + end_date;
      url += '&customer_report=' + customer_report;
      window.open(url, '_blank');
    })
  </script>