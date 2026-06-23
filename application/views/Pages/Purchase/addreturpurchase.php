<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<style>
  .po-section-title {
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #6c757d;
    padding: 0 0 6px 0;
    margin-bottom: 14px;
    border-bottom: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .po-section-title i { color: #0d6efd; font-size: 0.9rem; }
  .card.po-header-card, .card.po-detail-card { border: none; box-shadow: 0 2px 12px rgba(0,0,0,0.07); border-radius: 12px; }
  .card.po-header-card .card-body, .card.po-detail-card .card-body { padding: 24px 28px; }
  .po-field-group { margin-bottom: 12px; }
  .po-field-group label { font-size: 0.78rem; font-weight:600; color:#495057; margin-bottom:6px; display:block; }
  .po-field-group .form-control { border-radius:8px; }
  .input-temp-wrapper-po {
    background: linear-gradient(135deg, #f0f7ff 0%, #f8fbff 100%);
    border: 1.5px dashed #90c0f8;
    border-radius: 10px;
    padding: 18px 20px 8px 20px;
    margin-bottom: 20px;
  }
  .btn-add-temp-po { height: 38px; width: 38px; border-radius: 50%; display:flex; align-items:center; justify-content:center; padding:0; font-size:1rem; }
  .po-summary-card { background: linear-gradient(135deg, #f4f6f9 0%, #eaecef 100%); border: 1px solid #dee2e6; border-radius: 12px; padding: 20px 24px; color:#343a40; }
  .po-summary-card .summary-row { display:flex; justify-content:space-between; align-items:center; padding:7px 0; border-bottom:1px solid #dee2e6; font-size:0.875rem; }
  .po-summary-card .summary-row:last-child { border-bottom:none; }
  .po-summary-card .summary-row .summary-label { color:#6c757d; font-weight:600; }
  .po-summary-card .summary-row .summary-input { background:#fff; border:1px solid #ced4da; border-radius:6px; color:#343a40; text-align:right; font-weight:600; width:170px; padding:4px 10px; }
  .po-summary-card .summary-row.grand-total-row .summary-input { font-size:1rem; background:#e9ecef; border-color:#adb5bd; color:#0d6efd; }
  .po-page-title-bar { display:flex; align-items:center; gap:12px; margin-bottom:20px; }
  .po-page-title-bar .title-icon { width:42px; height:42px; background:linear-gradient(135deg,#0d6efd,#0a58ca); border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.1rem; }
  .po-page-title-bar h3 { margin:0; font-size:1.25rem; font-weight:700; color:#2d3748; }
  .supplier-highlight-po { border-left:4px solid #0d6efd; padding-left:12px; }
  #temp-retur-purchase-list thead th { background:#0d6efd; color:#fff; font-size:0.78rem; text-transform:uppercase; }
</style>

<div class="container">
  <div class="page-inner">
    <div class="page-header">

    </div>
    <div class="row">

      <div class="col-md-12 mb-2">
        <div class="po-page-title-bar">
          <div class="title-icon"><i class="fas fa-undo-alt"></i></div>
          <div>
            <h3>Tambah Retur Pembelian</h3>
            <small>Form retur pembelian dari supplier</small>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card po-header-card">
          <div class="card-body">
            <div class="po-section-title"><i class="fas fa-file-invoice"></i> Informasi Retur</div>
            <div class="row">
              <div class="col-md-4 po-field-group">
                <label>No Invoice :</label>
                <input id="retur_purchase_invoice" name="retur_purchase_invoice" type="text" class="form-control" value="AUTO" readonly="">
                <input id="retur_purchase_id" name="retur_purchase_id" type="hidden" class="form-control">
              </div>
              <div class="col-md-4 po-field-group">
                <label>Tanggal :</label>
                <input id="retur_purchase_date" name="retur_purchase_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              </div>
              <div class="col-md-4 po-field-group">
                <label>User :</label>
                <input id="po_user_id" name="po_user_id" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
              </div>
            </div>

            <div class="po-section-title mt-2"><i class="fas fa-truck"></i> Supplier & Jenis Potongan</div>
            <div class="row">
              <div class="col-md-6 po-field-group supplier-highlight-po">
                <label>Supplier</label>
                <select class="form-control input-full js-example-basic-single" id="purchase_supplier" name="purchase_supplier">
                  <option value="">-- Pilih Supplier --</option>
                  <?php foreach ($data['supplier_list'] as $row) { ?>
                    <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-6 po-field-group">
                <label>Jenis Potongan :</label>
                <select class="form-control" id="payment_type" name="payment_type">
                  <option value="CASH">Cash</option>
                  <option value="PN">Potong Nota</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12 detail-product-wrapper">
        <div class="card po-detail-card">
          <div class="card-body">
            <div class="po-section-title"><i class="fas fa-boxes"></i> Detail Produk Retur</div>
            <form id="formaddtemp">
              <div class="input-temp-wrapper-po">
                <div class="row">
                  <div class="col-sm-4 po-field-group">
                    <label>No Invoice Pembelian</label>
                    <input id="purchase_inv" name="purchase_inv" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan No Invoice" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                    <input id="purchase_id" type="hidden" name="purchase_id">
                  </div>
                  <div class="col-sm-5 po-field-group">
                    <label>Produk</label>
                    <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan Nama Produk" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                    <input id="product_id" type="hidden" name="product_id">
                  </div>
                  <div class="col-sm-3 po-field-group">
                    <label>Harga</label>
                    <input id="temp_price" name="temp_price" type="text" class="form-control text-right" value="0" required="">
                  </div>
                </div>

                <div class="row mt-2 align-items-end">
                  <div class="col-sm-2 po-field-group">
                    <label>Qty Retur</label>
                    <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="">
                  </div>
                  <div class="col-sm-2 po-field-group">
                    <label>Qty Beli</label>
                    <input id="temp_qty_buy" name="temp_qty_buy" type="text" class="form-control text-right" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="" readonly>
                  </div>
                  <div class="col-sm-3 po-field-group">
                    <label>Total</label>
                    <input id="temp_total" name="temp_total" type="text" class="form-control text-right" value="0" required="" readonly>
                  </div>
                  <div class="col-sm-4 po-field-group">
                    <label>Catatan</label>
                    <input id="temp_note" name="temp_note" type="text" class="form-control text-left">
                  </div>
                  <div class="col-sm-1 d-flex flex-column align-items-center">
                    <label>&nbsp;</label>
                    <button id="btnadd_temp" class="btn btn-primary btn-add-temp btn-add-temp-po" title="Tambah Item"><i class="fas fa-plus"></i></button>
                  </div>
                </div>
              </div>
            </form>

            <div class="table-responsive mt-3">
              <table id="temp-retur-purchase-list" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>No Invoice Pembelian</th>
                    <th>SKU</th>
                    <th>Produk</th>
                    <th>Satuan</th>
                    <th>Harga Beli</th>
                    <th>Qty Retur</th>
                    <th>Total</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>

            <div class="row mt-4">
              <div class="col-lg-6">
                <div class="po-section-title"><i class="fas fa-sticky-note"></i> Catatan Retur</div>
                <textarea id="purchase_retur_remark" name="purchase_retur_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="8" style="border-radius:8px; resize:none;"></textarea>
              </div>

              <div class="col-lg-6">
                <div class="po-section-title"><i class="fas fa-calculator"></i> Ringkasan</div>
                <div class="po-summary-card">
                  <div class="summary-row grand-total-row">
                    <span class="summary-label">Total</span>
                    <input id="footer_total_invoice" name="footer_total_invoice" type="text" class="summary-input" value="0" readonly="">
                  </div>
                </div>
                <div class="mt-3 d-flex justify-content-end" style="gap:10px;">
                  <button id="btncancel" class="btn btn-danger px-4" style="border-radius:8px;"><i class="fas fa-times-circle"></i> Batal</button>
                  <button id="btnsave" class="btn btn-success button-header-custom-save px-4" style="border-radius:8px;"><i class="fas fa-save"></i> Simpan</button>
                </div>
              </div>
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



  $('#purchase_warehouse').prop('disabled', false);

  let temp_price = new AutoNumeric('#temp_price', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let temp_total = new AutoNumeric('#temp_total', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_total_invoice = new AutoNumeric('#footer_total_invoice', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });


  $(document).ready(function() {
    temp_retur_purchase_table();
  });

  $('#purchase_inv').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Purchase/search_purchase_inv?id='+$('#purchase_supplier').val(),
        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: res.message,
            })
            $("#purchase_inv").val("");
          }
        },
      });
    },
    select: function(event, ui) {
      let id = ui.item.id;
      $("#purchase_id").val(id);
    },
  });


  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Purchase/search_product_retur?id='+$('#purchase_id').val(),
        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: res.message,
            })
          }
        },
      });
    },
    select: function(event, ui) {
      let id = ui.item.id;
      purchase_warehouse        = ui.item.warehouse;
      purchase_price            = ui.item.purchase_price;
      purchase_qty_buy          = ui.item.purchase_qty;
      $("#product_id").val(id);
      $('#purchase_warehouse').val(purchase_warehouse);
      $('#purchase_warehouse').trigger('change');
      temp_price.set(purchase_price);
      $('#temp_qty_buy').val(purchase_qty_buy);
    },
  });


  $('#temp_qty').on('input', function() {
    let qty = $(this).val();
    let temp_price_val = temp_price.get();
    let temp_total_Val = qty * temp_price_val;
    temp_total.set(temp_total_Val);
  });

  $('#temp_price').on('input', function (event) {
    let temp_price_val = temp_price.get();
    let qty =  $('#temp_qty').val();
    let temp_total_Val = qty * temp_price_val;
    temp_total.set(temp_total_Val);
  })

  function calculation_temp()
  {
    let temp_price_val  = parseInt(temp_price.get());
    let temp_qty_val    = $('#temp_qty').val();
    let temp_ongkir_val = parseInt(temp_ongkir.get());
    let temp_total_val  = temp_price_val * temp_qty_val + temp_ongkir_val;
    temp_total.set(temp_total_val);
  }

  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var purchase_id          = $("#purchase_id").val();
    var purchase_inv         = $("#purchase_inv").val();
    var product_id           = $("#product_id").val();
    var product_name         = $("#product_name").val();
    var purchase_warehouse   = $("#purchase_warehouse").val();
    var temp_price_submit    = parseInt(temp_price.get());
    var temp_qty             = $("#temp_qty").val();
    var temp_qty_buy         = $("#temp_qty_buy").val();
    var temp_note            = $("#temp_note").val();
    var supplier_id          = $('#purchase_supplier').val();
    var temp_total_submit    = parseInt(temp_total.get());


    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/add_temp_retur_purchase",
        dataType: "json",
        data: {purchase_id:purchase_id, purchase_inv:purchase_inv, product_id:product_id, product_name:product_name, purchase_warehouse:purchase_warehouse, temp_price_submit:temp_price_submit, temp_qty:temp_qty, temp_qty_buy:temp_qty_buy, temp_note:temp_note, supplier_id:supplier_id, temp_total_submit:temp_total_submit},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Data Berhasil Di Tambah';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-retur-purchase-list').DataTable().ajax.reload();
            check_tempt_data();
            clear_input();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.result,
            })
          }
        }
      });
    }
  });

  function check_tempt_data()
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/check_temp_retur_purchase",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
          let row = data.data[0];
          footer_total_invoice.set(row.sub_total);
          $('#purchase_supplier').val(row.supplier);
          $('#purchase_supplier').trigger('change');
        }
      }
    });
  }

  function clear_input()
  {
    $("#purchase_id").val("");
    $("#purchase_inv").val("");
    $("#product_id").val("");
    $("#product_name").val("");
    $("#purchase_warehouse").val("");
    temp_price.set(0);
    $("#temp_qty").val(0);
    $("#temp_qty_buy").val(0);
    $("#temp_note").val("");
  }

  function edit_temp(id, purchase_id)
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/get_edit_temp_retur_purchase",
      dataType: "json",
      data: {id:id, purchase_id:purchase_id},
      success : function(data){
        if (data.code == "200"){
          let row = data.result[0];
          $("#purchase_inv").val(row.temp_retur_purchase_b_inv);
          $("#purchase_id").val(row.temp_retur_purchase_b_id);
          $("#product_name").val(row.temp_retur_purchase_product_name);
          $("#product_id").val(row.temp_retur_purchase_product_id);
          $("#purchase_warehouse").val(row.temp_retur_purchase_warehouse_id);
          $('#purchase_warehouse').trigger('change');
          temp_price.set(row.temp_retur_purchase_price);
          $("#temp_qty").val(row.temp_retur_purchase_qty);
          $("#temp_qty_buy").val(row.temp_retur_purchase_qty_buy);
          temp_total.set(row.temp_retur_purchase_total);
          $("#temp_note").val(row.temp_retur_purchase_note);
        }
      }
    });
  }

  function temp_retur_purchase_table(){
    $('#temp-retur-purchase-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Purchase/temp_retur_purchase_list',
        type: 'POST',
        data:  {},
      },
      columns: 
      [
        {data: 0},
        {data: 1},
        {data: 2},
        {data: 3},
        {data: 4},
        {data: 5},
        {data: 6},
        {data: 7},
        {data: 8}
      ]
    });
    check_tempt_data();
  }

  function deletes(id, purchase_id)
  {
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus Data ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Purchase/delete_temp_retur_purchase",
          dataType: "json",
          data: {id:id, purchase_id:purchase_id},
          success : function(data){
            if (data.code == "200"){
              let title = 'Hapus Data';
              let message = 'Data Berhasil Di Hapus';
              let state = 'danger';
              notif_success(title, message, state);
              check_tempt_data();
              $('#temp-retur-purchase-list').DataTable().ajax.reload();
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.result,
              })
            }
          }
        });
      }
    })
  }

  

  $('#btnsave').click(function(e){
    e.preventDefault();
    var retur_purchase_supplier                  = $("#purchase_supplier").val();
    var retur_purchase_date                      = $("#retur_purchase_date").val();
    var payment_type                             = $("#payment_type").val();
    var footer_total_invoice_val                 = parseInt(footer_total_invoice.get());
    var purchase_retur_remark                    = $("#purchase_retur_remark").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/save_retur_purchase",
      dataType: "json",
      data: {retur_purchase_supplier:retur_purchase_supplier, retur_purchase_date:retur_purchase_date, payment_type:payment_type, footer_total_invoice_val:footer_total_invoice_val, purchase_retur_remark:purchase_retur_remark},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Purchase/returpurchase";
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.result,
          })
        }
      }
    });
  });

</script>