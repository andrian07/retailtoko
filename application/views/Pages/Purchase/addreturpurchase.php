<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">

    </div>
    <div class="row">
      <h3 class="fw-bold mb-3">Tambah Retur Pembelian </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>
              <div class="col-sm-3">
                <input id="retur_purchase_invoice" name="retur_purchase_invoice" type="text" class="form-control" value="AUTO" readonly="">
                <input id="retur_purchase_id" name="retur_purchase_id" type="hidden" class="form-control">
              </div>
              <div class="col-md-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>
              <div class="col-sm-3">
                <input id="retur_purchase_date" name="retur_purchase_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Supplier:</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="purchase_supplier" name="purchase_supplier">
                  <option value="">-- Pilih Supplier --</option>
                  <?php foreach ($data['supplier_list'] as $row) { ?>
                    <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">User :</label>
              <div class="col-sm-3">
                <input id="po_user_id" name="po_user_id" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form id="formaddtemp">
              <div class="row well well-sm input-temp">

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>No Invoice Pembelian</label>
                    <input id="purchase_inv" name="purchase_inv" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan No Invoice" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                    <input id="purchase_id" type="hidden" name="purchase_id">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Produk</label>
                    <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan Nama Produk" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                    <input id="product_id" type="hidden" name="product_id">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Gudang</label>
                    <select class="form-control input-full js-example-basic-single" id="purchase_warehouse" name="purchase_warehouse">
                      <option value="">-- Pilih Gudang --</option>
                      <?php foreach ($data['warehouse_list'] as $row) { ?>
                        <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Harga</label>
                    <input id="temp_price" name="temp_price" type="text" class="form-control text-right" value="0" required="">
                  </div>
                </div>


                <div class="col-sm-1">
                  <div class="form-group">
                    <label>Qty Retur</label>
                    <input id="temp_qty" name="temp_qty" type="text" class="form-control" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="">
                  </div>
                </div>

                <div class="col-sm-1">
                  <div class="form-group">
                    <label>Qty Beli</label>
                    <input id="temp_qty_buy" name="temp_qty_buy" type="text" class="form-control" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Berat(GR)</label>
                    <input id="temp_weight" name="temp_weight" type="text" class="form-control text-right" value="0">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Ongkir / KG</label>
                    <input id="temp_delivery_price" name="temp_delivery_price" type="text" class="form-control text-right" value="0">
                    <input id="temp_total_weight" name="temp_total_weight" type="hidden" class="form-control text-right" value="0" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Ongkir / PCS</label>
                    <input id="temp_ongkir" name="temp_ongkir" type="text" class="form-control text-right" value="0" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Total</label>
                    <input id="temp_total" name="temp_total" type="text" class="form-control text-right" value="0" required="" readonly>
                  </div>
                </div>

                <div class="col-sm-5">
                  <div class="form-group">
                    <label>Catatan</label>
                    <input id="temp_note" name="temp_note" type="text" class="form-control text-left">
                  </div>
                </div>

                <div class="col-sm-1" style="padding-right: 62px;">

                  <!-- text input -->

                  <label>&nbsp;</label>

                  <div class="form-group">

                    <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right btn-add-temp"><i class="fas fa-plus"></i></button>

                  </div>

                </div>

              </div>
            </form>

            <div class="table-responsive">
              <table id="temp-retur-purchase-list" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>SKU</th>
                    <th>Produk</th>
                    <th>Satuan</th>
                    <th>Harga Beli</th>
                    <th>Qty Retur</th>
                    <th>Ongkir Per Pcs</th>
                    <th>Total</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>

            <div class="row form-space">
              <div class="col-lg-6">
                <div class="form-group">
                  <div class="col-sm-12">
                    <textarea id="purchase_retur_remark" name="purchase_retur_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="8"></textarea>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 text-right">
                <div class="form-group row">
                  <label for="footer_total_invoice" class="col-sm-7 col-form-label text-right:">Total :</label>
                  <div class="col-sm-5">
                    <input id="footer_total_invoice" name="footer_total_invoice" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
                <div class="form-group row" style="margin-top: 20px;">
                  <div class="col-sm-12">
                    <button id="btncancel" class="btn btn-danger"><i class="fas fa-times-circle"></i> Batal</button>
                    <button id="btnsave" class="btn btn-success button-header-custom-save"><i class="fas fa-save"></i> Simpan</button>
                  </div>
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

  let temp_delivery_price = new AutoNumeric('#temp_delivery_price', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  

  let temp_ongkir = new AutoNumeric('#temp_ongkir', {
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
      purchase_ongkir           = ui.item.purchase_ongkir;
      purchase_weight           = ui.item.purchase_weight;
      purchase_total_weight     = ui.item.purchase_total_weight;
      purchase_total_ongkir     = ui.item.purchase_total_ongkir;
      $("#product_id").val(id);
      $('#purchase_warehouse').val(purchase_warehouse);
      $('#purchase_warehouse').trigger('change');
      temp_price.set(purchase_price);
      $('#temp_qty_buy').val(purchase_qty_buy);
      $('#temp_weight').val(purchase_weight);
      temp_delivery_price.set(purchase_ongkir);
      temp_ongkir.set(purchase_total_ongkir);
    },
  });


  $('#temp_qty').on('input', function (event) {
    let temp_price_val = parseInt(temp_price.get());
    let temp_qty_val = $('#temp_qty').val();
    let temp_weight_val = $('#temp_weight').val();
    let temp_total_weight_val = temp_qty_val * temp_weight_val;
    $('#temp_total_weight').val(temp_total_weight_val);
    let temp_ongkir_val = parseInt(temp_ongkir.get());
    let temp_total_val = temp_price_val * temp_qty_val + temp_ongkir_val;
    temp_total.set(temp_total_val)
  })

  $('#temp_price').on('input', function (event) {
    let temp_price_val = parseInt(temp_price.get());
    let temp_qty_val = $('#temp_qty').val();
    let temp_weight_val = $('#temp_weight').val();
    let temp_total_weight_val = temp_qty_val * temp_weight_val;
    $('#temp_total_weight').val(temp_total_weight_val);
    let temp_ongkir_val = parseInt(temp_ongkir.get());
    let temp_total_val = temp_price_val * temp_qty_val + temp_ongkir_val;
    temp_total.set(temp_total_val);
  })

  /*$('#temp_ongkir').on('input', function (event) {
    calculation_temp();
  })*/

  $('#temp_weight').on('input', function (event) {
    let temp_qty_val = $('#temp_qty').val();
    if(temp_qty_val == 0){
      temp_delivery_price.set(0);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "Silahakn Isi Qty Terlebih Dahulu",
      })
    }else{
      let temp_price_val = parseInt(temp_price.get());
      let temp_delivery_price_val = parseInt(temp_delivery_price.get());
      let temp_weight = $('#temp_weight').val();
      let temp_ongkir_val = temp_delivery_price_val / 1000 * temp_weight;
      temp_ongkir.set(temp_ongkir_val);
      let temp_total_val = temp_price_val * temp_qty_val + temp_ongkir_val * temp_qty_val;
      temp_total.set(temp_total_val);
    }
  })

  $('#temp_delivery_price').on('input', function (event) {
    let temp_qty_val = $('#temp_qty').val();
    if(temp_qty_val == 0){
      temp_delivery_price.set(0);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "Silahakn Isi Qty Terlebih Dahulu",
      })
    }else{
      let temp_price_val = parseInt(temp_price.get());
      let temp_delivery_price_val = parseInt(temp_delivery_price.get());
      let temp_weight = $('#temp_weight').val();
      let temp_ongkir_val = temp_delivery_price_val / 1000 * temp_weight;
      temp_ongkir.set(temp_ongkir_val);
      let temp_total_val = temp_price_val * temp_qty_val + temp_ongkir_val;
      temp_total.set(temp_total_val);
    }
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
    var temp_ongkir_submit   = parseInt(temp_ongkir.get());
    var temp_total_submit    = parseInt(temp_total.get());
    var temp_note            = $("#temp_note").val();
    var supplier_id          = $('#purchase_supplier').val();

    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/add_temp_retur_purchase",
        dataType: "json",
        data: {purchase_id:purchase_id, purchase_inv:purchase_inv, product_id:product_id, product_name:product_name, purchase_warehouse:purchase_warehouse, temp_price_submit:temp_price_submit, temp_qty:temp_qty, temp_qty_buy:temp_qty_buy, temp_ongkir_submit:temp_ongkir_submit, temp_total_submit:temp_total_submit, temp_note:temp_note, supplier_id:supplier_id},
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
    temp_ongkir.set(0);
    temp_total.set(0);
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
          temp_ongkir.set(row.temp_retur_purchase_ongkir);
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
    var footer_total_invoice_val                 = parseInt(footer_total_invoice.get());
    var purchase_retur_remark                    = $("#purchase_retur_remark").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/save_retur_purchase",
      dataType: "json",
      data: {retur_purchase_supplier:retur_purchase_supplier, retur_purchase_date:retur_purchase_date, footer_total_invoice_val:footer_total_invoice_val, purchase_retur_remark:purchase_retur_remark},
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