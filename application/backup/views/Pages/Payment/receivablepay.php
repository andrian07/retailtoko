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
      <h3 class="fw-bold mb-3">Pelunasan Piutang</h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="form-group row">
              <div class="row">
                <div class="col-sm-12 col-md-3">
                  <input id="customer_id" name="customer_id" type="hidden" class="form-control text-right" value="<?php echo $_GET['id']; ?>" readonly="">

                  <!-- text input -->
                  <div class="form-group">
                    <label>Nama Supplier</label>
                    <input id="customer_name" name="customer_name" type="text" class="form-control" readonly="">
                  </div>
                </div>
                <div class="col-sm-12 col-md-2">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Tanggal Pembayaran</label>
                    <input id="repayment_date" name="repayment_date" type="date" class="form-control" value="2025-07-23">
                  </div>
                </div>

                <div class="col-sm-12 col-md-3">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <select class="form-control input-full js-example-basic-single" id="payment_method_id" name="payment_method_id">
                      <option value="">-- Pilih Metode Bayar --</option>
                      <?php foreach ($payment_list as $row) { ?>
                        <option value="<?php echo $row->payment_id; ?>"><?php echo $row->payment_name; ?></option>  
                      <?php } ?>
                    </select>

                  </div>
                </div>


                <div class="col-sm-12 col-md-2">
                  <!-- text input -->
                  <div class="form-group">
                    <label>User</label>
                    <input id="display_user" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
                  </div>
                </div>
                <div class="col-sm-12 col-md-2">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Total Hutang</label>
                    <input id="supplier_total_receivable" name="supplier_total_receivable" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
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
                    <input id="sales_inv" name="sales_inv" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan No Invoice" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                    <input id="sales_id" type="hidden" name="sales_id">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Tgl Invoice</label>
                    <input id="sales_invoice_date" name="sales_invoice_date" type="date" class="form-control ui-autocomplete-input">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input id="receivable_desc" name="receivable_desc" type="text" class="form-control">
                  </div>
                </div>


                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Saldo Hutang</label>
                    <input id="receivable_nominal" name="receivable_nominal" type="text" class="form-control text-right" value="0" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Total Retur</label>
                    <input id="receivable_retur" name="receivable_retur" type="text" class="form-control text-right" value="0" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Pembayaran</label>
                    <input id="receivable_payment" name="receivable_payment" type="text" class="form-control text-right" value="0">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Pembulatan / Disc</label>
                    <input id="receivable_disc" name="receivable_disc" type="text" class="form-control text-right" value="0">
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Remaining receivable</label>
                    <input id="new_remaining_receivable" name="new_remaining_receivable" type="text" class="form-control text-right" value="0" readonly>
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
              <table id="temp-receivable-list" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>No Invoice</th>
                    <th>Tgl Invoice</th>
                    <th>Saldo Hutang</th>
                    <th>Pembulatan/Disc</th>
                    <th>Total Retur</th>
                    <th>Pembayaran</th>
                    <th>Sisa Hutang</th>
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
                  <label for="footer_total_invoice" class="col-sm-7 col-form-label text-right:">Total Pembayaran:</label>
                  <div class="col-sm-5">
                    <input id="footer_total_pay" name="footer_total_pay" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="footer_total_discount" class="col-sm-7 col-form-label text-right:">Total Discount:</label>
                  <div class="col-sm-5">
                    <input id="footer_total_discount" name="footer_total_discount" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="footer_total_retur" class="col-sm-7 col-form-label text-right:">Total Retur:</label>
                  <div class="col-sm-5">
                    <input id="footer_total_retur" name="footer_total_retur" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="footer_total_invoice" class="col-sm-7 col-form-label text-right:">Total Nota:</label>
                  <div class="col-sm-5">
                    <input id="footer_total_nota" name="footer_total_nota" type="text" class="form-control text-right" value="0" readonly="">
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



  $('#sales_warehouse').prop('disabled', true);

  let supplier_total_receivable = new AutoNumeric('#supplier_total_receivable', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let receivable_nominal = new AutoNumeric('#receivable_nominal', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let receivable_payment = new AutoNumeric('#receivable_payment', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let receivable_retur = new AutoNumeric('#receivable_retur', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let receivable_disc = new AutoNumeric('#receivable_disc', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let new_remaining_receivable = new AutoNumeric('#new_remaining_receivable', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_total_pay = new AutoNumeric('#footer_total_pay', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_total_retur = new AutoNumeric('#footer_total_retur', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_total_discount = new AutoNumeric('#footer_total_discount', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });
  


  $(document).ready(function() {
    get_header_receivable_pay();
    get_footer_receivable_pay();
    tempreceivable_table();
  });

  function tempreceivable_table(){
    $('#temp-receivable-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Payment/temp_receivable_list',
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
        {data: 7}
      ]
    });
  }

  function get_header_receivable_pay() {
    let customer_id = $("#customer_id").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/get_header_receivable_pay",
      dataType: "json",
      data: {customer_id:customer_id},
      success : function(data){
        if (data.code == "200"){
          let data_result = data.result[0];
          $("#customer_name").val(data_result.customer_name);
          supplier_total_receivable.set(data_result.total_hutang);
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

  function get_footer_receivable_pay() {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/get_footer_receivable_pay",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
          let data_result = data.result[0];
          footer_total_pay.set(data_result.total_payment_receivable);
          footer_total_discount.set(data_result.total_payment_discount);
          footer_total_retur.set(data_result.total_retur_receivable);
          $("#footer_total_nota").val(data_result.total_nota);
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

  function edit(id){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/get_receivable_temp_by_id",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          let data_row = data.result[0];
          $("#sales_inv").val(data_row.hd_sales_inv);
          $("#sales_id").val(data_row.hd_sales_id);
          $("#sales_invoice_date").val(data_row.hd_sales_date);
          $("#receivable_desc").val(data_row.temp_payment_receivable_desc);
          receivable_nominal.set(data_row.hd_sales_remaining_debt);
          receivable_payment.set(data_row.temp_payment_receivable_nominal);
          receivable_retur.set(data_row.temp_payment_receivable_retur);
          receivable_disc.set(data_row.temp_payment_receivable_discount);
          new_remaining_receivable.set(data_row.temp_payment_receivable_new_remaining);
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

  $('#receivable_payment').on('input', function (event) {
    receivable_nominal_val = parseInt(receivable_nominal.get());
    receivable_retur_val   = parseInt(receivable_retur.get());
    receivable_payment_val = parseInt(receivable_payment.get());
    receivable_disc_val    = parseInt(receivable_disc.get());    
    new_remaining_receivable.set(receivable_nominal_val - receivable_retur_val - receivable_payment_val - receivable_disc_val);
  })

  $('#receivable_disc').on('input', function (event) {
    receivable_nominal_val = parseInt(receivable_nominal.get());
    receivable_retur_val   = parseInt(receivable_retur.get());
    receivable_payment_val = parseInt(receivable_payment.get());
    receivable_disc_val    = parseInt(receivable_disc.get());    
    new_remaining_receivable.set(receivable_nominal_val - receivable_retur_val - receivable_payment_val - receivable_disc_val);
  })
  
  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var sales_id                      = $("#sales_id").val();
    var sales_invoice_date            = $("#sales_invoice_date").val();
    var receivable_desc               = $("#receivable_desc").val();
    var receivable_payment_val        = parseInt(receivable_payment.get());
    var receivable_disc_val           = parseInt(receivable_disc.get());
    var new_remaining_receivable_val  = parseInt(new_remaining_receivable.get());

    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Payment/add_temp_receivable",
        dataType: "json",
        data: {sales_id:sales_id, sales_invoice_date:sales_invoice_date, receivable_desc:receivable_desc, receivable_payment_val:receivable_payment_val, receivable_disc_val:receivable_disc_val, new_remaining_receivable_val:new_remaining_receivable_val},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Data Berhasil Di Tambah';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-receivable-list').DataTable().ajax.reload();
            get_header_receivable_pay();
            get_footer_receivable_pay();
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

  $('#btnsave').click(function(e){
    e.preventDefault();
    var customer_id             = $("#customer_id").val();
    var repayment_date          = $("#repayment_date").val();
    var payment_method_id       = $("#payment_method_id").val();
    var footer_total_pay_val    = parseInt(footer_total_pay.get());
    var footer_total_nota       = $("#footer_total_nota").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/save_receivable",
      dataType: "json",
      data: {customer_id:customer_id, repayment_date:repayment_date, payment_method_id:payment_method_id, footer_total_pay_val:footer_total_pay_val, footer_total_nota:footer_total_nota},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Payment/receivable";
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

  

  function clear_input()
  {
    $("#sales_inv").val("");
    $("#sales_id").val("");
    $("#sales_invoice_date").val("");
    $("#receivable_desc").val("");
    receivable_nominal.set(0);
    receivable_retur.set(0);
    receivable_payment.set(0);
    receivable_disc.set(0);
    new_remaining_receivable.set(0);
  }



</script>