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
      <h3 class="fw-bold mb-3">Laporan Stok </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-body">
              <form>
                <div class="row">
                
                <div class="col-sm-3">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Gudang:</label>
                      <select class="form-control input-full js-example-basic-single" id="warehouse_report" name="warehouse_report">
                        <option value="">-- Pilih Gudang --</option>
                        <?php foreach ($data['warehouse_list'] as $row) { ?>
                          <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="col-sm-3">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Kategori:</label>
                      <select class="form-control input-full js-example-basic-single" id="caregory_report" name="caregory_report">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($data['category_list'] as $row) { ?>
                          <option value="<?php echo $row->category_id; ?>"><?php echo $row->category_name; ?></option>  
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Brand:</label>
                      <select class="form-control input-full js-example-basic-single" id="brand_report" name="brand_report">
                        <option value="">-- Pilih Brand --</option>
                        <?php foreach ($data['brand_list'] as $row) { ?>
                          <option value="<?php echo $row->brand_id; ?>"><?php echo $row->brand_name; ?></option>  
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
            <iframe id="preview" src="<?php echo base_url(); ?>Reportstock/stockistpdf" width="100%" height="1000px"></iframe>
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
      let warehouse_report       = $('#warehouse_report').val();
      let caregory_report        = $('#caregory_report').val();
      let brand_report           = $('#brand_report').val();

      let url = '<?php echo base_url(); ?>Reportstock/stockistpdf?';
      url += '&warehouse_report=' + warehouse_report;
      url += '&caregory_report=' + caregory_report;
      url += '&brand_report=' + brand_report;
      $('#preview').attr('src', url);
    })


    $('#btndownloadexcell').click(function(e) {
      e.preventDefault();
      let warehouse_report       = $('#warehouse_report').val();
      let caregory_report        = $('#caregory_report').val();
      let brand_report           = $('#brand_report').val();
      let url = '<?php echo base_url(); ?>Reportstock/stockist_excell?';
      url += '&warehouse_report=' + warehouse_report;
      url += '&caregory_report=' + caregory_report;
      url += '&brand_report=' + brand_report;
      window.open(url, '_blank');
    })
  </script>