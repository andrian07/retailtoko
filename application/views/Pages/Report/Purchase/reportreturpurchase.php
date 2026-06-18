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
      <h3 class="fw-bold mb-3">Laporan Retur Pembelian </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-body">
              <form>
                <div class="row">
                  <div class="col-sm-3">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Tanggal Dari:</label>
                      <input type="date" class="form-control input-full" id="start_date" value="<?php echo date('Y-m-01'); ?>">
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Tanggal Sampai:</label>
                      <input type="date" class="form-control input-full" id="end_date" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                  </div>

                  <div class="col-sm-2">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Supplier:</label>
                      <select class="form-control input-full js-example-basic-single" id="supplier_report" name="supplier_report">
                        <option value="">-- Pilih Supplier --</option>
                        <?php foreach ($data['supplier_list'] as $row) { ?>
                          <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>  
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
            <iframe id="preview" src="<?php echo base_url(); ?>Reportpurchase/reportreturpurchasespdf" width="100%" height="1000px"></iframe>
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
      let supplier_report  = $('#supplier_report').val();

      let url = '<?php echo base_url(); ?>Reportpurchase/reportreturpurchasespdf?';
      url += '&start_date=' + start_date;
      url += '&end_date=' + end_date;
      url += '&supplier_report=' + supplier_report;
      $('#preview').attr('src', url);
    })


    $('#btndownloadexcell').click(function(e) {
      e.preventDefault();
      let start_date       = $('#start_date').val();
      let end_date         = $('#end_date').val();
      let supplier_report  = $('#supplier_report').val();
      let url = '<?php echo base_url(); ?>Reportpurchase/reportreturpurchases_excell?';
      url += '&start_date=' + start_date;
      url += '&end_date=' + end_date;
      url += '&supplier_report=' + supplier_report;
      window.open(url, '_blank');
    })
  </script>