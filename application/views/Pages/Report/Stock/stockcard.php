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
                
                <div class="col-sm-4">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Produk:</label>
                      <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan nama produk" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                      <input id="product_id" type="hidden" name="product_id">
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
            <iframe id="preview" src="<?php echo base_url(); ?>Reportstock/stockcardpdf" width="100%" height="1000px"></iframe>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php 
  require DOC_ROOT_PATH . $this->config->item('footer');
  ?>

  <script type="text/javascript">

    $('#product_name').autocomplete({ 
        minLength: 2,
        source: function(req, add) {
        $.ajax({
            url: '<?php echo base_url(); ?>/Sales/search_product',
            dataType: 'json',
            type: 'GET',
            data: req,
            success: function(res) {
            if (res.success == true) {
                add(res.data);
            }
            },
        });
        },
        select: function(event, ui) {
        let id = ui.item.id;
        let product_name = ui.item.product_name;
        let product_id = ui.item.product_id;
        $('#product_name').val(product_name);
        $('#product_id').val(id);
        },
    });

    $('#btnsearch').click(function(e) {
      e.preventDefault();
      let product_id       = $('#product_id').val();
      let url = '<?php echo base_url(); ?>Reportstock/stockcardpdf?';
      url += '&product_id=' + product_id;
      $('#preview').attr('src', url);
    })


    $('#btndownloadexcell').click(function(e) {
      e.preventDefault();
      let product_id       = $('#product_id').val();
      let url = '<?php echo base_url(); ?>Reportstock/stockcard_excell?';
      url += '&product_id=' + product_id;
      window.open(url, '_blank');
    })
  </script>