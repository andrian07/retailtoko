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
      <h3 class="fw-bold mb-3">Tambah Retur Penjualan </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>
              <div class="col-sm-3">
                <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly="">
                <input id="purchase_order_id" name="purchase_order_id" type="hidden" class="form-control">
              </div>
              <div class="col-md-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>
              <div class="col-sm-3">
                <input id="retur_sales_date" name="retur_sales_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Customer:</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="sales_customer" name="sales_customer">
                  <option value="">-- Pilih Customer --</option>
                  <?php foreach ($data['customer_list'] as $row) { ?>
                    <option value="<?php echo $row->customer_id; ?>"><?php echo $row->customer_name; ?></option>  
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
                    <label>No Invoice Penjualan</label>
                    <input id="sales_inv" name="sales_inv" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan No Invoice" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                    <input id="sales_id" type="hidden" name="sales_id">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Produk</label>
                    <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan Nama Produk" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                    <input id="product_id" type="hidden" name="product_id">
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Harga Jual</label>
                    <input id="temp_price" name="temp_price" type="text" class="form-control text-right" value="0" required="">
                  </div>
                </div>

                <div class="col-sm-1">
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Qty Retur</label>
                    <input id="temp_qty" name="temp_qty" type="text" class="form-control" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Qty Jual</label>
                    <input id="temp_qty_sell" name="temp_qty_sell" type="text" class="form-control" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="" readonly>
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
              <table id="temp-retur-sales-list" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>SKU</th>
                    <th>produk</th>
                    <th>Satuan</th>
                    <th>Qty</th>
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
                    <textarea id="sales_retur_remark" name="sales_retur_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="8"></textarea>
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

  $('#purchase_warehouse').prop('disabled', true);

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

  $('#sales_inv').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Sales/search_sales_inv?id='+$('#sales_customer').val(),
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
            $("#sales_inv").val("");
          }
        },
      });
    },
    select: function(event, ui) {
      let id = ui.item.id;
      $("#sales_inv").val(id);
      $("#sales_id").val(id);
    },
  });


  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Sales/search_product_retur?id='+$('#sales_id').val(),
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
      sales_price     = ui.item.sales_price;
      sales_qty       = ui.item.sales_qty;
      $("#product_id").val(id);
      temp_price.set(sales_price);
      $('#temp_qty_sell').val(sales_qty);
    },
  });


  $('#temp_qty').on('input', function (event) {
    calculation_temp();
  })

  $('#temp_price').on('input', function (event) {
    calculation_temp();
  })


  function calculation_temp()
  {
    let temp_price_val  = parseInt(temp_price.get());
    let temp_qty_val    = $('#temp_qty').val();
    let temp_total_val  = temp_price_val * temp_qty_val ;
    temp_total.set(temp_total_val);
  }

  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var sales_id             = $("#sales_id").val();
    var sales_inv            = $("#sales_inv").val();
    var product_id           = $("#product_id").val();
    var product_name         = $("#product_name").val();
    var temp_price_submit    = parseInt(temp_price.get());
    var temp_qty             = $("#temp_qty").val();
    var temp_qty_sell        = $("#temp_qty_sell").val();
    var temp_total_submit    = parseInt(temp_total.get());
    var temp_note            = $("#temp_note").val();
    var customer_id          = $('#sales_customer').val();

    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Sales/add_temp_retur_sales",
        dataType: "json",
        data: {sales_id:sales_id, sales_inv:sales_inv, product_id:product_id, product_name:product_name, temp_price_submit:temp_price_submit, temp_qty:temp_qty, temp_qty_sell:temp_qty_sell, temp_total_submit:temp_total_submit, temp_note:temp_note, customer_id:customer_id},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Data Berhasil Di Tambah';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-retur-sales-list').DataTable().ajax.reload();
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
      url: "<?php echo base_url(); ?>Sales/check_temp_retur_sales",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
          let row = data.data[0];
          footer_total_invoice.set(row.sub_total);
          $('#sales_customer').val(row.customer);
          $('#sales_customer').trigger('change');
        }
      }
    });
  }

  function clear_input()
  {
    $("#sales_id").val("");
    $("#sales_inv").val("");
    $("#product_id").val("");
    $("#product_name").val("");
    temp_price.set(0);
    $("#temp_qty").val(0);
    $("#temp_qty_sell").val(0);
    temp_total.set(0);
    $("#temp_note").val("");
  }

  function edit_temp(id, sales_id)
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Sales/get_edit_temp_retur_sales",
      dataType: "json",
      data: {id:id, sales_id:sales_id},
      success : function(data){
        console.log("asdasd");
        if (data.code == "200"){
          let row = data.result[0];
          $("#sales_inv").val(row.temp_retur_sales_b_inv);
          $("#sales_id").val(row.temp_retur_sales_b_id);
          $("#product_name").val(row.temp_retur_sales_product_name);
          $("#product_id").val(row.temp_retur_sales_product_id);
          temp_price.set(row.temp_retur_sales_price);
          $("#temp_qty").val(row.temp_retur_sales_qty);
          $("#temp_qty_sell").val(row.temp_retur_sales_qty_sales);
          temp_total.set(row.temp_retur_sales_total);
          $("#temp_note").val(row.temp_retur_sales_note);
        }
      }
    });
  }

  function temp_retur_purchase_table(){
    $('#temp-retur-sales-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Sales/temp_retur_sales_list',
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
        {data: 6}
      ]
    });
    check_tempt_data();
  }

  function deletes(id)
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
          url: "<?php echo base_url(); ?>Sales/delete_temp_retur_sales",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              let title = 'Hapus Data';
              let message = 'Data Berhasil Di Hapus';
              let state = 'danger';
              notif_success(title, message, state);
              check_tempt_data();
              $('#temp-retur-sales-list').DataTable().ajax.reload();
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
    var retur_sales_customer                     = $("#sales_customer").val();
    var retur_sales_date                         = $("#retur_sales_date").val();
    var footer_total_invoice_val                 = parseInt(footer_total_invoice.get());
    var sales_retur_remark                       = $("#sales_retur_remark").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Sales/save_retur_sales",
      dataType: "json",
      data: {retur_sales_customer:retur_sales_customer, retur_sales_date:retur_sales_date, footer_total_invoice_val:footer_total_invoice_val, sales_retur_remark:sales_retur_remark},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Sales/retursales";
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