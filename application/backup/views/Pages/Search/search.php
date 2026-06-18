<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
<style type="text/css">
  .image-td{
    width: 15%;
  }

  @media only screen and (max-width: 600px) {
    .image-td{
      width: 35%;
    }
  }
</style>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3" style="padding-left: 20px;">Informasi Produk</h3>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="row" style="margin-top:10px;">
               <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Unit:</label>
                <select id="filter_unit" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua Unit --</option>
                  <?php foreach($data['unit_list'] as $u){ ?>
                    <option value="<?= $u->unit_id ?>"><?= $u->unit_name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Kategori:</label>
                <select id="filter_category" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua Kategori --</option>
                  <?php foreach($data['category_list'] as $c){ ?>
                    <option value="<?= $c->category_id ?>"><?= $c->category_name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-3">
                
                <label style="font-weight: 700; margin-bottom: 5px;">Brand:</label>
                <select id="filter_brand" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua Brand --</option>
                  <?php foreach($data['brand_list'] as $b){ ?>
                    <option value="<?= $b->brand_id ?>"><?= $b->brand_name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Supplier:</label>
                <select id="filter_supplier" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua Supplier --</option>
                  <?php foreach($data['supplier_list'] as $s){ ?>
                    <option value="<?= $s->supplier_id ?>"><?= $s->supplier_name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Status:</label>
                <select id="filter_status" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua Status --</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Discontinue">Discontinue</option>
                </select>
              </div>

              <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Paket:</label>
                <select id="filter_paket" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua --</option>
                    <option value="N">Bukan Paket</option>
                    <option value="Y">Paket</option>
                </select>
              </div>

               <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">PPN:</label>
                <select id="filter_ppn" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua --</option>
                    <option value="N">Bukan PPN</option>
                    <option value="Y">PPN</option>
                </select>
              </div>


            </div>
          </div>

          <div class="card-header">
            <div class="row">
              <div id="info" class="col-12"></div>

              <div class="col-12">
                <label style="font-weight: 700; margin-bottom: 5px; margin-left:5px;">Barcode / Nama Produk</label>
              </div>
              <div class="col-sm-10">
                <!-- text input -->
                <div class="form-group">
                  <input id="key" name="key" type="text" class="form-control ui-autocomplete-input" placeholder="Barcode atau Nama Produk" value="" autocomplete="off">
                </div>
              </div>
            </div>
          </div>

          
          <div class="card-body">
            <div class="table-responsive">


             <table class="table table-hover">
              <tbody id="product_list">

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script>

 $(document ).ready(function() {
  product_list_table();
});


 let formatter = new Intl.NumberFormat('id-ID', {
  style: 'currency',
  currency: 'IDR',
  minimumFractionDigits: 0
});

$('#filter_unit, #filter_category, #filter_brand, #filter_supplier, #filter_status, #filter_paket, #filter_ppn')
.on('change', function () {
  let key = $('#key').val();
  product_list_table(key);
});


function product_list_table(key = '') {

  let unit      = $('#filter_unit').val();
  let category  = $('#filter_category').val();
  let brand     = $('#filter_brand').val();
  let supplier  = $('#filter_supplier').val();
  let status    = $('#filter_status').val();
  let paket     = $('#filter_paket').val();
  let ppn       = $('#filter_ppn').val();

  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>Search/product_list",
    dataType: "json",
    data: {
      key: key,
      unit: unit,
      category: category,
      brand: brand,
      supplier: supplier,
      status: status,
      paket: paket,
      ppn: ppn
    },
    success : function(data){

      let text = "";
      for (let i = 0; i < data.length; i++) {

        let stocks = data[i].total_stock ?? 0;

        text+= `
        <tr onclick="popupOpen(${data[i].product_id})">
          <td class="image-td">
            <img src="<?php echo base_url(); ?>assets/products/${data[i].product_image}" width="100%">
          </td>
          <td>
            ${data[i].product_name}<br>
            <span class="badge badge-primary">${formatter.format(data[i].product_sell_price_1)}</span>
          </td>
          <td>${stocks} ${data[i].unit_name}</td>
        </tr>`;
      }       

      document.getElementById("product_list").innerHTML = text;
    }
  });
}

$('#key').on('input', function (event) {
  var key = this.value;
  product_list_table(key);
})


function popupOpen(id) {
  let link = window.location.origin + window.location.pathname + '/detailsearch?id='+id;
  Fancybox.show([
    {
      src: link,
      type: "iframe",
      preload: false,
      top:0,
    },
  ]);
}

</script>