<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<style>
	/* ===== Page Layout ===== */
	.retur-page-wrapper { background: #f0f4f8; min-height: 100vh; padding-bottom: 40px; }
	.page-title-bar { margin-top: 84px; background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%); color: #fff; padding: 18px 28px; border-radius: 12px; margin-bottom: 22px; display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 15px rgba(124,45,18,.25); }
	.page-title-bar i { font-size: 1.8rem; opacity: .9; }
	.page-title-bar h4 { margin: 0; font-weight: 700; font-size: 1.25rem; letter-spacing: .3px; }
	.page-title-bar small { opacity: .75; font-size: .8rem; }

	/* ===== Cards ===== */
	.sales-card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.08); margin-bottom: 20px; overflow: visible; }
	.sales-card .card-header { border-radius: 12px 12px 0 0 !important; padding: 12px 20px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: .95rem; border-bottom: none; }
	.sales-card .card-header i { font-size: 1rem; }
	.sales-card .card-body { padding: 20px 24px; }
	.header-red  { background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%); color: #fff; }
	.header-teal { background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%); color: #fff; }

	/* ===== Priority Badges & Pills ===== */
	.priority-badge { display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; border-radius: 50%; background: #7c2d12; color: #fff; font-size: .7rem; font-weight: 700; margin-right: 5px; flex-shrink: 0; vertical-align: middle; }
	.section-pill { border-radius: 8px; padding: 4px 12px; font-size: .75rem; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px; margin-bottom: 14px; }
	.pill-required { background: #fee2e2; color: #b91c1c; }
	.pill-auto    { background: #dcfce7; color: #15803d; }
	.info-divider { border-right: 2px dashed #e5e7eb; }

	/* ===== Form Styling ===== */
	.form-label-custom { font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: 4px; display: block; text-transform: uppercase; letter-spacing: .4px; }
	.form-control-custom { border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 8px 12px; font-size: .9rem; transition: border-color .2s, box-shadow .2s; background: #fff; }
	.form-control-custom:focus { border-color: #c2410c; box-shadow: 0 0 0 3px rgba(194,65,12,.12); outline: none; }
	.form-control-custom[readonly] { background: #f8fafc; color: #6b7280; }
	.select2-container .select2-selection--single { height: 40px !important; border: 1.5px solid #e5e7eb !important; border-radius: 8px !important; }
	.select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 38px !important; font-size: .9rem; }
	.select2-container--default .select2-selection--single .select2-selection__arrow { height: 38px !important; }

	/* ===== Product Input Panel ===== */
	.product-input-panel { background: linear-gradient(135deg, #fff7ed, #ffedd5); border: 1.5px dashed #fdba74; border-radius: 10px; padding: 16px 20px; margin-bottom: 16px; }

	/* ===== Table ===== */
	#temp-retur-sales-list thead th { background: #1e3a5f; color: #fff; font-size: .82rem; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; border: none; padding: 10px 12px; }
	#temp-retur-sales-list tbody tr:hover { background: #fff7ed; }
	#temp-retur-sales-list tbody td { vertical-align: middle; font-size: .88rem; padding: 9px 12px; border-color: #e5e7eb; }

	/* ===== Summary Card ===== */
	.summary-card { background: #fff; border-radius: 12px; border: none; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
	.summary-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #f3f4f6; }
	.summary-row:last-child { border-bottom: none; }
	.summary-label { color: #6b7280; font-size: .88rem; font-weight: 500; }
	.summary-value input { border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 6px 10px; font-size: .88rem; text-align: right; background: #f8fafc; width: 180px; }
	.summary-grand { background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%); border-radius: 10px; padding: 12px 16px; margin: 10px 0; }
	.summary-grand .summary-label { color: #e5e7eb; font-weight: 600; }
	.summary-grand input { background: transparent; border: 1.5px solid rgba(255,255,255,.35) !important; color: #fff; font-size: 1.05rem; font-weight: 700; }

	/* ===== Buttons ===== */
	.btn-save-main { background: linear-gradient(135deg, #059669, #10b981); color: #fff; border: none; border-radius: 10px; padding: 10px 28px; font-weight: 600; font-size: .95rem; transition: all .2s; }
	.btn-save-main:hover { background: linear-gradient(135deg, #047857, #059669); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(5,150,105,.3); }
	.btn-cancel-main { background: #fff; color: #dc2626; border: 1.5px solid #dc2626; border-radius: 10px; padding: 10px 28px; font-weight: 600; font-size: .95rem; transition: all .2s; }
	.btn-cancel-main:hover { background: #dc2626; color: #fff; transform: translateY(-1px); }
	.btn-add-item { background: linear-gradient(135deg, #7c2d12, #c2410c); color: #fff; border: none; border-radius: 8px; padding: 8px 18px; font-weight: 600; font-size: .88rem; white-space: nowrap; }
	.btn-add-item:hover { background: linear-gradient(135deg, #7c2d12, #9a3412); color: #fff; }
</style>

<div class="retur-page-wrapper">
<div class="container-fluid px-4">

	<!-- Page Title -->
	<div class="page-title-bar">
		<i class="fas fa-undo-alt"></i>
		<div>
			<h4>Tambah Retur Penjualan</h4>
			<small>Buat transaksi retur penjualan baru</small>
		</div>
	</div>

	<!-- ===== ROW 1: Info Transaksi ===== -->
	<div class="sales-card card">
		<div class="card-header header-red">
			<i class="fas fa-file-invoice"></i> Informasi Transaksi
		</div>
		<div class="card-body pb-3">
			<div class="row g-0">

				<!-- LEFT: Wajib Diisi -->
				<div class="col-lg-7 pe-lg-4 info-divider">
					<span class="section-pill pill-required"><i class="fas fa-pencil-alt"></i> Wajib Diisi</span>
					<div class="row g-3">

						<!-- Customer -->
						<div class="col-md-6">
							<label class="form-label-custom">
								<span class="priority-badge">1</span> Customer
							</label>
							<select class="form-control form-control-custom js-example-basic-single" id="sales_customer" name="sales_customer">
								<option value="">-- Pilih Customer --</option>
								<?php foreach ($data['customer_list'] as $row) { ?>
									<option value="<?php echo $row->customer_id; ?>"><?php echo $row->customer_name; ?></option>
								<?php } ?>
							</select>
						</div>

						<!-- Tanggal -->
						<div class="col-md-6">
							<label class="form-label-custom">
								<span class="priority-badge">2</span> Tanggal Retur
							</label>
							<input id="retur_sales_date" name="retur_sales_date" type="date" class="form-control form-control-custom" value="<?php echo date('Y-m-d'); ?>">
						</div>

            <!-- Jenis Potongan -->
						<div class="col-md-6">
							<label class="form-label-custom">
								<span class="priority-badge">3</span> Jenis Potongan
							</label>
							<select class="form-control form-control-custom js-example-basic-single" id="payment_type" name="payment_type">
								<option value="">-- Pilih Jenis Potongan --</option>
								<option value="CASH">CASH</option>
                <option value="PN">Potongan Nota</option>
							</select>
						</div>

					</div>
				</div>

				<!-- RIGHT: Otomatis -->
				<div class="col-lg-5 ps-lg-4 mt-4 mt-lg-0">
					<span class="section-pill pill-auto"><i class="fas fa-magic"></i> Terisi Otomatis</span>

					<input id="purchase_order_id" name="purchase_order_id" type="hidden">

					<div class="row g-3">
						<!-- No Invoice -->
						<div class="col-12">
							<label class="form-label-custom">
								<i class="fas fa-lock fa-xs me-1 text-muted"></i> No Invoice
							</label>
							<div class="input-group">
								<span class="input-group-text" style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-right:none;border-radius:8px 0 0 8px;color:#15803d;font-size:.8rem;">AUTO</span>
								<input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control form-control-custom" style="border-radius:0 8px 8px 0;border-left:none;" value="AUTO" readonly="">
							</div>
						</div>

						<!-- User -->
						<div class="col-12">
							<label class="form-label-custom">
								<i class="fas fa-lock fa-xs me-1 text-muted"></i> User
							</label>
							<input id="po_user_id" name="po_user_id" type="text" class="form-control form-control-custom" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- ===== ROW 2: Detail Barang ===== -->
	<div class="sales-card card">
		<div class="card-header header-teal">
			<i class="fas fa-boxes"></i> Detail Barang Retur
		</div>
		<div class="card-body">

			<!-- Product Input Panel -->
			<form id="formaddtemp">
				<div class="product-input-panel">
					<div class="row g-3 align-items-end">

						<div class="col-md-4">
							<label class="form-label-custom">No Invoice Penjualan</label>
							<input id="sales_inv" name="sales_inv" type="text" class="form-control form-control-custom ui-autocomplete-input" placeholder="Ketikkan No Invoice..." value="" required="" autocomplete="off" data-parsley-required data-parsley-required-message="*Masukan No Invoice">
							<input id="sales_id" type="hidden" name="sales_id">
						</div>

						<div class="col-md-4">
							<label class="form-label-custom">Produk</label>
							<input id="product_name" name="product_name" type="text" class="form-control form-control-custom ui-autocomplete-input" placeholder="Ketikkan nama produk..." value="" required="" autocomplete="off" data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
							<input id="product_id" type="hidden" name="product_id">
						</div>

						<div class="col-md-4">
							<label class="form-label-custom">Harga Jual / Unit</label>
							<input id="temp_price" name="temp_price" type="text" class="form-control form-control-custom text-end" value="0" required="">
						</div>

						<div class="col-md-2">
							<label class="form-label-custom">Qty Retur</label>
							<input id="temp_qty" name="temp_qty" type="text" class="form-control form-control-custom text-end" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="">
						</div>

						<div class="col-md-2">
							<label class="form-label-custom">Qty Jual</label>
							<input id="temp_qty_sell" name="temp_qty_sell" type="text" class="form-control form-control-custom text-end" value="0" readonly="">
						</div>

						<div class="col-md-3">
							<label class="form-label-custom">Total</label>
							<input id="temp_total" name="temp_total" type="text" class="form-control form-control-custom text-end fw-bold" value="0" readonly="">
						</div>

						<div class="col-md-4">
							<label class="form-label-custom">Catatan Item</label>
							<input id="temp_note" name="temp_note" type="text" class="form-control form-control-custom">
						</div>

						<div class="col-md-1 d-flex align-items-end">
							<button id="btnadd_temp" class="btn btn-add-item btn-add-temp" title="Tambah Item"><i class="fas fa-plus"></i></button>
						</div>

					</div>
				</div>
			</form>

			<!-- Items Table -->
			<div class="table-responsive">
				<table id="temp-retur-sales-list" class="display table table-hover" style="width:100%">
					<thead>
						<tr>
							<th>SKU</th>
							<th>Produk</th>
							<th>Satuan</th>
							<th>Qty</th>
							<th>Total</th>
							<th>Catatan</th>
							<th style="text-align:center;">Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

			<!-- ===== Footer: Notes + Summary ===== -->
			<div class="row mt-4 g-4">

				<!-- Catatan -->
				<div class="col-lg-5">
					<label class="form-label-custom mb-2"><i class="fas fa-sticky-note me-1"></i> Catatan</label>
					<textarea id="sales_retur_remark" name="sales_retur_remark" class="form-control form-control-custom" placeholder="Tulis catatan transaksi di sini..." maxlength="500" rows="9"></textarea>
				</div>

				<!-- Summary -->
				<div class="col-lg-7">
					<div class="summary-card p-4">

						<div class="summary-grand my-2">
							<div class="d-flex justify-content-between align-items-center">
								<span class="summary-label fs-6"><i class="fas fa-money-bill-wave me-2"></i>Total Retur</span>
								<div class="summary-value">
									<input id="footer_total_invoice" name="footer_total_invoice" type="text" value="0" readonly="" style="width:200px;">
								</div>
							</div>
						</div>

						<!-- Action Buttons -->
						<div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
							<button id="btncancel" class="btn btn-cancel-main">
								<i class="fas fa-times-circle me-2"></i> Batal
							</button>
							<button id="btnsave" class="btn btn-save-main button-header-custom-save">
								<i class="fas fa-save me-2"></i> Simpan Retur
							</button>
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
    temp_retur_sales_table();
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

  function temp_retur_sales_table(){
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
    var payment_type                             = $('#payment_type').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Sales/save_retur_sales",
      dataType: "json",
      data: {retur_sales_customer:retur_sales_customer, retur_sales_date:retur_sales_date, footer_total_invoice_val:footer_total_invoice_val, sales_retur_remark:sales_retur_remark, payment_type:payment_type},
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