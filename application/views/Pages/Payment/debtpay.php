<?php
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/payment-form.css?v=<?php echo @filemtime(FCPATH.'dist/css/payment-form.css'); ?>">

<div class="container">
  <div class="page-inner pay-page">

    <!-- ===== Judul ===== -->
    <div class="pay-hero">
      <div class="pay-hero-title">
        <div class="pay-hero-icon"><i class="fas fa-wallet"></i></div>
        <div>
          <h3>Pelunasan Hutang</h3>
          <p>Kelola pembayaran hutang ke supplier.</p>
        </div>
      </div>
      <div class="pay-breadcrumb">
        <a href="<?php echo base_url(); ?>Dashboard"><i class="fas fa-home"></i></a>
        <i class="fas fa-chevron-right sep"></i>
        <a href="<?php echo base_url(); ?>Payment/debt">Pelunasan</a>
        <i class="fas fa-chevron-right sep"></i>
        <span class="current">Hutang</span>
      </div>
    </div>

    <!-- ===== Info pembayaran ===== -->
    <div class="pay-card">
      <input id="supplier_id" name="supplier_id" type="hidden" value="<?php echo htmlspecialchars(isset($_GET['id']) ? $_GET['id'] : ''); ?>" readonly="">
      <div class="pay-grid pay-grid-head">
        <div class="pay-field">
          <label><i class="fas fa-university"></i> Nama Supplier</label>
          <div class="pay-input"><i class="fas fa-university"></i><input id="supplier_name" name="supplier_name" type="text" class="form-control" readonly=""></div>
        </div>
        <div class="pay-field">
          <label>Tanggal Pembayaran</label>
          <div class="pay-input"><i class="far fa-calendar-alt"></i><input id="repayment_date" name="repayment_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"></div>
        </div>
        <div class="pay-field">
          <label>Metode Pembayaran</label>
          <div class="pay-input"><i class="far fa-credit-card"></i>
            <select class="form-control input-full js-example-basic-single" id="payment_method_id" name="payment_method_id">
              <option value="">-- Pilih Metode Bayar --</option>
              <?php foreach ($data['payment_list'] as $row) { ?>
                <option value="<?php echo $row->payment_id; ?>"><?php echo $row->payment_name; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="pay-field">
          <label>User</label>
          <div class="pay-input"><i class="far fa-user"></i><input id="display_user" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly=""></div>
        </div>
        <div class="pay-total">
          <div class="pay-total-icon"><i class="fas fa-coins"></i></div>
          <div style="min-width:0;">
            <label>Total Hutang Supplier</label>
            <input id="supplier_total_debt" name="supplier_total_debt" type="text" class="form-control" value="0" readonly="">
          </div>
        </div>
      </div>
    </div>

    <!-- ===== Input invoice ===== -->
    <div class="pay-card">
      <form id="formaddtemp">
        <div class="pay-grid pay-grid-inv">
          <div class="pay-field">
            <label>No Invoice Pembelian</label>
            <div class="pay-input"><i class="fas fa-search"></i>
              <input id="purchase_inv" name="purchase_inv" type="text" class="form-control ui-autocomplete-input" placeholder="Ketikkan No Invoice..." value="" required="" autocomplete="off" data-parsley-required data-parsley-required-message="*Masukan No Invoice">
              <input id="purchase_id" type="hidden" name="purchase_id">
            </div>
          </div>
          <div class="pay-field">
            <label>Tgl Invoice</label>
            <div class="pay-input"><i class="far fa-calendar-alt"></i><input id="purchase_invoice_date" name="purchase_invoice_date" type="date" class="form-control ui-autocomplete-input"></div>
          </div>
          <div class="pay-field">
            <label>Keterangan</label>
            <div class="pay-input"><i class="far fa-sticky-note"></i><input id="debt_desc" name="debt_desc" type="text" class="form-control" placeholder="Keterangan (opsional)"></div>
          </div>
        </div>

        <div class="pay-grid pay-grid-money">
          <div class="pay-field">
            <label>Saldo Hutang</label>
            <div class="pay-input"><i class="fas fa-coins"></i><input id="debt_nominal" name="debt_nominal" type="text" class="form-control text-right" value="0" readonly></div>
          </div>
          <div class="pay-field">
            <label>Total Retur</label>
            <div class="pay-input"><i class="fas fa-undo"></i><input id="debt_retur" name="debt_retur" type="text" class="form-control text-right" value="0" readonly></div>
          </div>
          <div class="pay-field">
            <label>Pembayaran</label>
            <div class="pay-input"><i class="far fa-credit-card"></i><input id="debt_payment" name="debt_payment" type="text" class="form-control text-right" value="0"></div>
          </div>
          <div class="pay-field">
            <label>Pembulatan / Disc</label>
            <div class="pay-input"><i class="fas fa-percent"></i><input id="debt_disc" name="debt_disc" type="text" class="form-control text-right" value="0"></div>
          </div>
          <div class="pay-field">
            <label>Sisa Hutang</label>
            <div class="pay-input"><i class="far fa-clock"></i><input id="new_remaining_debt" name="new_remaining_debt" type="text" class="form-control text-right" value="0" readonly></div>
          </div>
          <div class="pay-field">
            <button id="btnadd_temp" class="btn-pay-add btn-add-temp" title="Tambah ke daftar"><i class="fas fa-plus"></i></button>
          </div>
        </div>
      </form>
    </div>

    <!-- ===== Daftar invoice + ringkasan ===== -->
    <div class="pay-card">
      <div class="table-responsive pay-table">
        <table id="temp-debt-list" class="display table table-hover">
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

      <div class="pay-bottom">
        <div class="pay-note">
          <h6><i class="far fa-edit"></i>Catatan</h6>
          <textarea id="purchase_retur_remark" name="purchase_retur_remark" class="form-control" placeholder="Tambahkan catatan..." maxlength="500" rows="4"></textarea>
        </div>
        <div class="pay-summary">
          <div class="pay-sum-row"><span><i class="fas fa-coins"></i>Total Pembayaran</span><input id="footer_total_pay" name="footer_total_pay" type="text" value="0" readonly=""></div>
          <div class="pay-sum-row"><span><i class="fas fa-percent"></i>Total Discount</span><input id="footer_total_discount" name="footer_total_discount" type="text" value="0" readonly=""></div>
          <div class="pay-sum-row"><span><i class="fas fa-undo"></i>Total Retur</span><input id="footer_total_retur" name="footer_total_retur" type="text" value="0" readonly=""></div>
          <div class="pay-sum-row pay-sum-total"><span><i class="fas fa-file-invoice-dollar"></i>Total Nota</span><input id="footer_total_nota" name="footer_total_nota" type="text" value="0" readonly=""></div>
        </div>
      </div>

      <div class="pay-actions">
        <button id="btncancel" class="btn btn-cancel"><i class="far fa-times-circle"></i> Batal</button>
        <button id="btnsave" class="btn btn-save"><i class="fas fa-save"></i> Simpan Pembayaran</button>
      </div>
    </div>

  </div>
</div>

<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script>



  $('#purchase_warehouse').prop('disabled', true);

  let supplier_total_debt = new AutoNumeric('#supplier_total_debt', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let debt_nominal = new AutoNumeric('#debt_nominal', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let debt_payment = new AutoNumeric('#debt_payment', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let debt_retur = new AutoNumeric('#debt_retur', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let debt_disc = new AutoNumeric('#debt_disc', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let new_remaining_debt = new AutoNumeric('#new_remaining_debt', {
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
    get_header_debt_pay();
    get_footer_debt_pay();
    tempdebt_table();
  });

  function tempdebt_table(){
    $('#temp-debt-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Payment/temp_debt_list',
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

  function get_header_debt_pay() {
    let supplier_id = $("#supplier_id").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/get_header_debt_pay",
      dataType: "json",
      data: {supplier_id:supplier_id},
      success : function(data){
        if (data.code == "200"){
          let data_result = data.result[0];
          $("#supplier_name").val(data_result.supplier_name);
          supplier_total_debt.set(data_result.total_hutang);
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

  function get_footer_debt_pay() {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/get_footer_debt_pay",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
          let data_result = data.result[0];
          footer_total_pay.set(data_result.total_payment_debt);
          footer_total_discount.set(data_result.total_payment_discount);
          footer_total_retur.set(data_result.total_retur_debt);
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
      url: "<?php echo base_url(); ?>Payment/get_debt_temp_by_id",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          let data_row = data.result[0];
          $("#purchase_inv").val(data_row.hd_purchase_invoice);
          $("#purchase_id").val(data_row.hd_purchase_id);
          $("#purchase_invoice_date").val(data_row.hd_purchase_date);
          $("#debt_desc").val(data_row.temp_payment_debt_desc);
          debt_nominal.set(data_row.hd_purchase_remaining_debt);
          debt_payment.set(data_row.temp_payment_debt_nominal);
          debt_retur.set(data_row.temp_payment_debt_retur);
          debt_disc.set(data_row.temp_payment_debt_discount);
          new_remaining_debt.set(data_row.temp_payment_debt_new_remaining);
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

  $('#debt_payment').on('input', function (event) {
    debt_nominal_val = parseInt(debt_nominal.get());
    debt_retur_val   = parseInt(debt_retur.get());
    debt_payment_val = parseInt(debt_payment.get());
    debt_disc_val    = parseInt(debt_disc.get());    
    new_remaining_debt.set(debt_nominal_val - debt_retur_val - debt_payment_val - debt_disc_val);
  })

  $('#debt_disc').on('input', function (event) {
    debt_nominal_val = parseInt(debt_nominal.get());
    debt_retur_val   = parseInt(debt_retur.get());
    debt_payment_val = parseInt(debt_payment.get());
    debt_disc_val    = parseInt(debt_disc.get());    
    new_remaining_debt.set(debt_nominal_val - debt_retur_val - debt_payment_val - debt_disc_val);
  })
  
  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var purchase_id             = $("#purchase_id").val();
    var purchase_invoice_date   = $("#purchase_invoice_date").val();
    var debt_desc               = $("#debt_desc").val();
    var debt_payment_val        = parseInt(debt_payment.get());
    var debt_disc_val           = parseInt(debt_disc.get());
    var new_remaining_debt_val  = parseInt(new_remaining_debt.get());

    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Payment/add_temp_debt",
        dataType: "json",
        data: {purchase_id:purchase_id, purchase_invoice_date:purchase_invoice_date, debt_desc:debt_desc, debt_payment_val:debt_payment_val, debt_disc_val:debt_disc_val, new_remaining_debt_val:new_remaining_debt_val},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Data Berhasil Di Tambah';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-debt-list').DataTable().ajax.reload();
            get_header_debt_pay();
            get_footer_debt_pay();
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
    var supplier_id                  = $("#supplier_id").val();
    var repayment_date               = $("#repayment_date").val();
    var payment_method_id            = $("#payment_method_id").val();
    var footer_total_pay_val         = parseInt(footer_total_pay.get());
    var footer_total_discount_val    = parseInt(footer_total_discount.get());
    var footer_total_retur_val       = parseInt(footer_total_retur.get());
    var footer_total_nota            = $("#footer_total_nota").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/save_debt",
      dataType: "json",
      data: {supplier_id:supplier_id, repayment_date:repayment_date, payment_method_id:payment_method_id, footer_total_pay_val:footer_total_pay_val, footer_total_discount_val:footer_total_discount_val, footer_total_retur_val:footer_total_retur_val, footer_total_nota:footer_total_nota},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Payment/debt";
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
    $("#purchase_inv").val("");
    $("#purchase_id").val("");
    $("#purchase_invoice_date").val("");
    $("#debt_desc").val("");
    debt_nominal.set(0);
    debt_retur.set(0);
    debt_payment.set(0);
    debt_disc.set(0);
    new_remaining_debt.set(0);
  }



</script>