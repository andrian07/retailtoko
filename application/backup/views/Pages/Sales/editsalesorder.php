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
      <h3 class="fw-bold mb-3">Edit Sales Order </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>
              <div class="col-sm-3">
                <input id="sales_order_invoice" name="sales_order_invoice" type="text" class="form-control"  readonly="">
                <input id="sales_order_id" name="sales_order_id" type="hidden" class="form-control" value="<?php echo $_GET['id']; ?>">
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">T.O.P :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" onchange="duedate_cal()" id="sales_order_top" name="sales_order_top">
                  <option value="">-- Pilih T.O.P --</option>
                  <option value="0">CBD</option>
                  <option value="7">JT7</option>
                  <option value="15">JT15</option>
                  <option value="30">JT30</option>
                  <option value="45">JT45</option>
                  <option value="60">JT60</option>
                  <option value="90">JT90</option>
                </select>
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>
              <div class="col-sm-3">
                <input id="sales_order_date" name="sales_order_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Customer:</label>
              <div class="col-sm-3">
               <select class="form-control input-full js-example-basic-single" id="sales_order_customer" name="sales_order_customer">
                <option value="">-- Pilih Customer --</option>
                <?php foreach ($data['customer_list'] as $row) { ?>
                  <option value="<?php echo $row->customer_id; ?>"><?php echo $row->customer_name; ?></option>  
                <?php } ?>
              </select>
            </div>
            <label for="tanggal" class="col-sm-1 col-form-label text-right">Sales :</label>
            <div class="col-sm-3">
              <select class="form-control input-full js-example-basic-single" id="sales_order_salesman" name="sales_order_salesman">
                <option value="">-- Pilih Sales --</option>
                <?php foreach ($data['salesman_list'] as $row) { ?>
                  <option value="<?php echo $row->salesman_id; ?>"><?php echo $row->salesman_name; ?></option>  
                <?php } ?>
              </select>
            </div>
            <label for="tanggal" class="col-sm-1 col-form-label text-right">Gudang :</label>
            <div class="col-sm-3">
              <select class="form-control input-full js-example-basic-single" id="sales_order_warehouse" name="sales_order_warehouse">
                <option value="">-- Pilih Gudang --</option>
                <?php foreach ($data['warehouse_list'] as $row) { ?>
                  <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="noinvoice" class="col-sm-1 col-form-label text-right">Rate Customer:</label>
            <div class="col-sm-3">
              <input id="sales_order_rate_customer" name="sales_order_rate_customer" type="text" class="form-control" readonly="">
            </div>

            <label for="noinvoice" class="col-sm-1 col-form-label text-right">Disiapkan:</label>
            <div class="col-sm-3">
              <input id="sales_order_prepare" name="sales_order_prepare" type="text" class="form-control">
            </div>
            <label for="tanggal" class="col-sm-1 col-form-label text-right">Ekspedisi :</label>
            <div class="col-sm-3">
              <select class="form-control input-full js-example-basic-single" id="sales_order_ekspedisi" name="sales_order_ekspedisi">
                <option value="">-- Pilih Ekspedisi --</option>
                <?php foreach ($data['ekspedisi_list'] as $row) { ?>
                  <option value="<?php echo $row->ekspedisi_id; ?>"><?php echo $row->ekspedisi_name; ?></option>  
                <?php } ?>
              </select>
            </div>
          </div>


          <div class="form-group row">
            <label for="tanggal" class="col-sm-1 col-form-label text-right">Metode Bayar :</label>
            <div class="col-sm-3">
              <select class="form-control input-full js-example-basic-single" id="sales_order_payment" name="sales_order_payment">
                <option value="">-- Pilih Metode Bayar --</option>
                <?php foreach ($data['payment_list'] as $row) { ?>
                  <option value="<?php echo $row->payment_id; ?>"><?php echo $row->payment_name; ?></option>  
                <?php } ?>
              </select>
            </div>

            <label for="noinvoice" class="col-sm-1 col-form-label text-right">Jumlah Colly :</label>
            <div class="col-sm-3">
              <input id="sales_order_colly" name="sales_order_colly" type="text" class="form-control">
            </div>

            <label for="tanggal" class="col-sm-1 col-form-label text-right">User :</label>
            <div class="col-sm-3">
              <input id="po_user_id" name="po_user_id" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
            </div>
          </div>

          <div class="form-group row">
            <label for="tanggal" class="col-sm-1 col-form-label text-right">Jth Tempo :</label>
            <div class="col-sm-3">
              <input id="sales_order_due_date" name="sales_order_due_date" type="date" class="form-control" readonly>
            </div>

            <label for="noinvoice" class="col-sm-1 col-form-label text-right">dropship :</label>
            <div class="col-sm-3">
             <select class="form-control input-full js-example-basic-single" id="drop_ship" name="drop_ship">
               <option value="N">Tidak</option>
               <option value="Y">Ya</option>
             </select>
           </div>
         </div>

         

       </div>
     </div>
   </div>

   <div class="row" style="display:none;" id="dropship-container">
    <div class="card">
     <div class="card-body">
      <div class="row">
       <div class="col-md-6">
        <label>Nama:</label>
        <input id="dropship_name" name="dropship_name" type="text" class="form-control" placeholder="Nama Dropship Pelanggan">
        <label style="margin-top:10px;">No Telp:</label>
        <input id="dropship_phone" name="dropship_phone" type="text" class="form-control" placeholder="Telp Dropship Pelanggan">
      </div>
      <div class="col-md-6">
        <label>Alamat:</label>
        <textarea id="dropship_address" name="dropship_address" class="form-control" placeholder="Alamat Dropship" maxlength="500" rows="4"></textarea>
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
              <label>Produk</label>
              <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan nama produk" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
              <input id="product_id" type="hidden" name="product_id">
            </div>
          </div>

          <div class="col-sm-2">
            <div class="form-group">
              <label>Rate Produk</label>
              <select class="form-control input-full js-example-basic-single" id="temp_rate" name="temp_rate">
                <option value="Umum">Umum</option>
                <option value="Toko">Toko</option>
                <option value="Sales">Sales</option>
                <option value="Khusus">Khusus</option>
              </select>
            </div>
          </div>

          <div class="col-sm-2">
            <div class="form-group">
              <label>Harga Jual Per Unit</label>
              <input id="temp_price" name="temp_price" class="form-control text-right" value="0"  required="">
            </div>
          </div>

          
          <div class="col-sm-2">
           <div class="form-group">
            <label>Curent Stock</label>
            <input id="curent_stock" name="curent_stock" class="form-control text-right" value="0"  required="" readonly>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <label>Qty</label>
            <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" required="">
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <label>Discount</label>
            <input id="temp_discount" name="temp_discount" type="text" class="form-control text-right" value="0">
          </div>
        </div>

        <div class="col-sm-4">
          <div class="form-group">
            <label>Catatan</label>
            <input id="temp_note" name="temp_note" type="text" class="form-control text-left" >
          </div>
        </div>
        <div class="col-sm-5">

          <!-- text input -->

          <div class="form-group">

            <label>Total</label>

            <input id="temp_total" name="temp_total" type="text" class="form-control text-right" value="0" readonly="">

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
      <table id="temp-salesorder-list" class="display table table-striped table-hover" >
        <thead>
          <tr>
            <th>SKU</th>
            <th>produk</th>
            <th>Rate</th>
            <th>Qty</th>
            <th>Harga Satuan</th>
            <th>Discount</th>
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
            <textarea id="sales_order_remark" name="sales_order_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="8"></textarea>
          </div>
        </div>
      </div>

      <div class="col-lg-6 text-right">
        <div class="form-group row">
          <label for="footer_sub_total" class="col-sm-7 col-form-label text-right:">Sub Total:</label>
          <div class="col-sm-5">
            <input id="footer_sub_total" name="footer_sub_total" type="text" class="form-control text-right" value="0" readonly="">
          </div>
        </div>
        <div class="form-group row">
          <label for="footer_total_discount" class="col-sm-7 col-form-label text-right:">Discount :</label>
          <div class="col-sm-5">
            <input id="footer_discount1" name="footer_discount1" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="">
            <input id="footer_discount2" name="footer_discount2" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="">
            <input id="footer_discount3" name="footer_discount3" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="">
            <input id="footer_discount_percentage1" name="footer_discount_percentage1" type="hidden" class="form-control text-right" value="0.00%" readonly="">
            <input id="footer_discount_percentage2" name="footer_discount_percentage2" type="hidden" class="form-control text-right" value="0.00%" readonly="">
            <input id="footer_discount_percentage3" name="footer_discount_percentage3" type="hidden" class="form-control text-right" value="0.00%" readonly="">
            <input id="footer_total_discount" name="footer_total_discount" data-bs-toggle="modal" data-bs-target="#footerdiscount" type="text" class="form-control text-right" value="0" readonly="">
          </div>
        </div>
        <div class="form-group row">
          <label for="footer_total_ppn" class="col-sm-7 col-form-label text-right:">PPN 11% :</label>
          <div class="col-sm-4">
            <input id="footer_total_ppn" name="footer_total_ppn" type="text" class="form-control text-right" value="0" readonly="">
          </div>
          <div class="col-sm-1">
            <input class="form-check-input" type="checkbox" id="ppnchecked" style="width: 33px; height: 33px;">
          </div>
        </div>
        <div class="form-group row">
          <label for="footer_total_invoice" class="col-sm-7 col-form-label text-right:">Grand Total :</label>
          <div class="col-sm-5">
            <input id="footer_total_invoice" name="footer_total_invoice" type="text" class="form-control text-right" value="0" readonly="">
          </div>
        </div>
        <div class="form-group row">
          <label for="footer_dp" class="col-sm-7 col-form-label text-right:">DP :</label>
          <div class="col-sm-5">
            <input id="footer_dp" name="footer_dp" type="text" class="form-control text-right" value="0">
          </div>
        </div>
        <div class="form-group row">
          <label for="footer_remaining_debt" class="col-sm-7 col-form-label text-right:">Kredit :</label>
          <div class="col-sm-5">
            <input id="footer_remaining_debt" name="footer_remaining_debt" type="text" class="form-control text-right" value="0" readonly="">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-12">
            <button id="btncancel" class="btn btn-danger"><i class="fas fa-times-circle"></i> Batal</button>
            <button id="btnsave" class="btn btn-success button-header-custom-save"><i class="fas fa-save"></i> Simpan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Modal Discount -->
    <div class="modal fade" id="footerdiscount" tabindex="-1" aria-labelledby="exampleModaleditLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="title-frmfooterdiscount">Diskon</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="frmfooterdiscount" class="form-horizontal">
            <div class="modal-body">
              <div class="form-group">
                <div class="row">
                  <label for="edit_footer_discount1_lbl" class="col-sm-12">Diskon 1</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="edit_footer_discount_percentage1" name="edit_footer_discount_percentage1" value="0">
                  </div>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="edit_footer_discount1" name="edit_footer_discount1" value="0" readonly>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label for="edit_footer_discount2_lbl" class="col-sm-12">Diskon 2</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="edit_footer_discount_percentage2" name="edit_footer_discount_percentage2" value="0">
                  </div>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="edit_footer_discount2" name="edit_footer_discount2" value="0" readonly>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label for="edit_footer_discount3_lbl" class="col-sm-12">Diskon 3</label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="edit_footer_discount_percentage3" name="edit_footer_discount_percentage3" value="0">
                  </div>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="edit_footer_discount3" name="edit_footer_discount3" value="0" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
              <button type="button" id="btneditdisc"  class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- Footer Modal Discount -->

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


  let temp_discount = new AutoNumeric('#temp_discount', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_sub_total = new AutoNumeric('#footer_sub_total', {
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

  let footer_total_ppn = new AutoNumeric('#footer_total_ppn', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_dp = new AutoNumeric('#footer_dp', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let footer_remaining_debt = new AutoNumeric('#footer_remaining_debt', {
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

  let edit_footer_discount1 = new AutoNumeric('#edit_footer_discount1', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let edit_footer_discount2 = new AutoNumeric('#edit_footer_discount2', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let edit_footer_discount3 = new AutoNumeric('#edit_footer_discount3', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });
  

  let edit_footer_discount_percentage1 = new AutoNumeric('#edit_footer_discount_percentage1', {
    allowDecimalPadding: "floats",
    alwaysAllowDecimalCharacter: true,
    suffixText: "%"
  });

  let edit_footer_discount_percentage2 = new AutoNumeric('#edit_footer_discount_percentage2', {
    allowDecimalPadding: "floats",
    alwaysAllowDecimalCharacter: true,
    suffixText: "%"
  });

  let edit_footer_discount_percentage3 = new AutoNumeric('#edit_footer_discount_percentage3', {
    allowDecimalPadding: "floats",
    alwaysAllowDecimalCharacter: true,
    suffixText: "%"
  });


  $(document).ready(function() {
    temppurchase_table();
    get_edit_data();
  });

  function temppurchase_table(){
    $('#temp-salesorder-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Sales/temp_salesorder_list',
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


  $('#po_inv').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Purchase/search_po_purchase',
        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
          }else{
            $('#po_inv').val('');
          }
        },
      });
    },
    select: function(event, ui) {
      var po_id = ui.item.id;
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/copy_po_to_temp_purchase",
        dataType: "json",
        data: {po_id:po_id},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Berhasil Pilih PO';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-salesorder-list').DataTable().ajax.reload();
            check_tempt_data();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.result,
            })
          }
        }
      });
    },
  });

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
          }else{
            $('#submission_inv').val('');
          }
        },
      });
    },
    select: function(event, ui) {
      let id = ui.item.id;
      let product_name = ui.item.product_name;
      let product_id = ui.item.product_id;
      let product_price = ui.item.product_price;
      
      let curent_stock = ui.item.curent_stock;
      $('#product_name').val(product_name);
      $('#product_id').val(id);
      $('#temp_rate').val('Umum');
      $('#temp_rate').trigger('change');
      
      if(curent_stock == null){
        $('#curent_stock').val(0);
      }else{
        $('#curent_stock').val(curent_stock);
      }
      temp_price.set(product_price);
    },
  });


  function change_rate()
  {
    let product_id = $("product_id").val(); 
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Sales/get_rate",
      dataType: "json",
      data: {product_id:product_id},
      success : function(data){
        if (data.code == "200"){
          var row = data.result[0];
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.result,
          })
        }
      }
    });
  }

  $('#drop_ship').on('change', function() {
		var value = $(this).val();
		if (value == 'Y') {
			$('#dropship-container').show();
		}else{
		  $('#dropship-container').hide();
      $('#dropship_name').val("");
      $('#dropship_phone').val("");
			$('#dropship_address').val("");
		}
	});

  $('#temp_rate').on('change', function (event) {
    let product_id = $("#product_id").val();
    let rate_val   = $(this).val();  
    $.ajax({

      type: "POST",
      url: "<?php echo base_url(); ?>Sales/get_rate",
      dataType: "json",
      data: {product_id:product_id},
      success : function(data){
        if (data.code == "200"){
          var row = data.result[0];
          if(rate_val == 'Umum'){
            temp_price.set(row.Umum );
            calculation_total_temp();
          }else if(rate_val == 'Toko'){
            temp_price.set(row.Toko);
            calculation_total_temp();
          }else if(rate_val == 'Sales'){
            temp_price.set(row.Sales);
            calculation_total_temp();
          }else{
            temp_price.set(row.Khusus);
            calculation_total_temp();
          }
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.result,
          })
        }
      }
    });  
  })

  $('#temp_price').on('input', function (event) {
    calculation_total_temp();
  })

  $('#temp_qty').on('input', function (event) {
    calculation_total_temp();
  })

  $('#temp_discount').on('input', function (event) {
    calculation_total_temp();
  })

  function calculation_total_temp()
  {
    let temp_price_val     = parseInt(temp_price.get());
    let temp_qty_val       = $('#temp_qty').val();
    let temp_discount_val  = parseInt(temp_discount.get());
    let temp_total_val = temp_price_val * temp_qty_val - temp_discount_val;
    temp_total.set(temp_total_val);
  }


  function edit_temp(id)
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Sales/get_edit_temp_so",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          var row = data.result[0];
          $("#product_name").val(row.product_name);
          $("#product_id").val(row.temp_product_id);
          $('#temp_rate').val(row.temp_so_rate);
          $('#temp_rate').trigger('change');
          temp_price.set(row.temp_so_price);
          $("#temp_qty").val(row.temp_so_qty);
          $("#temp_note").val(row.temp_so_note);
          temp_discount.set(row.temp_so_discount);
          temp_total.set(row.temp_so_total);
        }
      }
    });  
  }


  function duedate_cal()
  {
    var purchase_top = document.getElementById("sales_order_top").value;
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/cal_due_date",
      dataType: "json",
      data: {po_top:purchase_top},
      success : function(data){
        if (data.code == "200"){
          $('#sales_order_due_date').val(data.result);
        }
      }
    });
  }

  function clear_input()
  {
    $('#product_name').val("");
    $('#product_id').val("");
    $('#temp_rate').val('Umum');
    $('#temp_rate').trigger('change');
    temp_price.set(0);
    $('#temp_qty').val(0);
    temp_discount.set(0);
    temp_total.set(0);
  }

  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var warehouse_id            = $("#sales_order_warehouse").val();
    var product_id              = $("#product_id").val();
    var temp_rate               = $("#temp_rate").val();
    var temp_price_val          = parseInt(temp_price.get());
    var temp_qty                = $("#temp_qty").val();
    var temp_discount_val       = parseInt(temp_discount.get());
    var temp_total_val          = parseInt(temp_total.get());
    var temp_note               = $("#temp_note").val();

    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Sales/add_temp_sales_order",
        dataType: "json",
        data: {warehouse_id:warehouse_id, product_id:product_id, temp_rate:temp_rate, temp_price_val:temp_price_val, temp_qty:temp_qty, temp_discount_val:temp_discount_val, temp_total_val:temp_total_val, temp_note:temp_note},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Data Berhasil Di Tambah';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-salesorder-list').DataTable().ajax.reload();
            edit_footer_discount_percentage1.set(0);
            edit_footer_discount1.set(0);
            edit_footer_discount_percentage2.set(0);
            edit_footer_discount2.set(0);
            edit_footer_discount_percentage3.set(0);
            edit_footer_discount3.set(0);
            footer_total_discount.set(0);
            footer_total_ppn.set(0);
             $('#ppnchecked').prop('checked', false);
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

  $('#btnsave').click(function(e){
    e.preventDefault();
    var sales_order_id                           = $("#sales_order_id").val();
    var sales_order_invoice                      = $("#sales_order_invoice").val();
    var sales_order_customer                     = $("#sales_order_customer").val();
    var sales_order_rate_customer                = $("#sales_order_rate_customer").val();
    var sales_order_payment                      = $("#sales_order_payment").val();
    var sales_order_top                          = $("#sales_order_top option:selected").text();
    var sales_order_top_id                       = $("#sales_order_top").val()
    var sales_order_salesman                     = $("#sales_order_salesman").val();
    var sales_order_prepare                      = $("#sales_order_prepare option:selected").text();
    var sales_order_prepare_id                   = $("#sales_order_prepare").val();
    var sales_order_colly                        = $("#sales_order_colly").val();
    var sales_order_warehouse                    = $("#sales_order_warehouse").val();
    var sales_order_ekspedisi                    = $("#sales_order_ekspedisi").val();
    var drop_ship                                = $("#drop_ship").val();
    var dropship_name                            = $("#dropship_name").val();
    var dropship_phone                           = $("#dropship_phone").val();
    var dropship_address                         = $("#dropship_address").val();
    var footer_sub_total_submit                  = parseInt(footer_sub_total.get());
    var footer_total_discount_submit             = parseInt(footer_total_discount.get());
    var edit_footer_discount_percentage1_submit  = parseInt(edit_footer_discount_percentage1.get());
    var edit_footer_discount_percentage2_submit  = parseInt(edit_footer_discount_percentage2.get());
    var edit_footer_discount_percentage3_submit  = parseInt(edit_footer_discount_percentage3.get());
    var edit_footer_discount1_submit             = parseInt(edit_footer_discount1.get());
    var edit_footer_discount2_submit             = parseInt(edit_footer_discount2.get());
    var edit_footer_discount3_submit             = parseInt(edit_footer_discount3.get());
    var footer_total_ppn_val                     = parseInt(footer_total_ppn.get());
    var footer_total_invoice_val                 = parseInt(footer_total_invoice.get());
    var footer_dp_val                            = parseInt(footer_dp.get());
    var footer_remaining_debt_val                = parseInt(footer_remaining_debt.get());
    var sales_order_remark                       = $("#sales_order_remark").val();
    var sales_order_due_date                     = $("#sales_order_due_date").val();
    var sales_order_date                         = $("#sales_order_date").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Sales/edit_save_salesorder",
      dataType: "json",
      data: {sales_order_id:sales_order_id, sales_order_invoice:sales_order_invoice, sales_order_customer:sales_order_customer, sales_order_rate_customer:sales_order_rate_customer, sales_order_payment:sales_order_payment, sales_order_top:sales_order_top, sales_order_top_id:sales_order_top_id, sales_order_salesman:sales_order_salesman, sales_order_prepare:sales_order_prepare, sales_order_colly:sales_order_colly, sales_order_warehouse:sales_order_warehouse, sales_order_ekspedisi:sales_order_ekspedisi, drop_ship:drop_ship, dropship_name:dropship_name, dropship_phone:dropship_phone, dropship_address:dropship_address, footer_sub_total_submit:footer_sub_total_submit, footer_total_discount_submit:footer_total_discount_submit, edit_footer_discount_percentage1_submit:edit_footer_discount_percentage1_submit, edit_footer_discount_percentage2_submit:edit_footer_discount_percentage2_submit, edit_footer_discount_percentage3_submit:edit_footer_discount_percentage3_submit, edit_footer_discount1_submit:edit_footer_discount1_submit, edit_footer_discount2_submit:edit_footer_discount2_submit, edit_footer_discount3_submit:edit_footer_discount3_submit, footer_total_ppn_val:footer_total_ppn_val, footer_total_invoice_val:footer_total_invoice_val, footer_dp_val:footer_dp_val, footer_remaining_debt_val:footer_remaining_debt_val, sales_order_remark:sales_order_remark, sales_order_due_date:sales_order_due_date, sales_order_date:sales_order_date},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Sales/salesorder";
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

$('#edit_footer_discount_percentage1').on('input', function (event) {
  let footer_sub_total_val = parseInt(footer_sub_total.get());
  let edit_footer_discount_percentage1_val = parseInt(edit_footer_discount_percentage1.get());
  let edit_footer_discount1_val = footer_sub_total_val * edit_footer_discount_percentage1_val / 100;
  edit_footer_discount1.set(edit_footer_discount1_val);
})

$('#edit_footer_discount_percentage2').on('input', function (event) {
  let footer_sub_total_val = parseInt(footer_sub_total.get());
  let edit_footer_discount_percentage2_val = parseInt(edit_footer_discount_percentage2.get());
  let edit_footer_discount1_val = parseInt(edit_footer_discount1.get());
  let edit_footer_discount2_val = (footer_sub_total_val - edit_footer_discount1_val) * edit_footer_discount_percentage2_val / 100;
  edit_footer_discount2.set(edit_footer_discount2_val);
})

$('#edit_footer_discount_percentage3').on('input', function (event) {
  let footer_sub_total_val = parseInt(footer_sub_total.get());
  let edit_footer_discount_percentage3_val = parseInt(edit_footer_discount_percentage3.get());
  let edit_footer_discount1_val = parseInt(edit_footer_discount1.get());
  let edit_footer_discount2_val = parseInt(edit_footer_discount2.get());
  let edit_footer_discount3_val = (footer_sub_total_val - edit_footer_discount1_val - edit_footer_discount2_val) * edit_footer_discount_percentage3_val / 100;
  edit_footer_discount3.set(edit_footer_discount3_val);
})

$('#btneditdisc').click(function(e){
  e.preventDefault();
  var edit_footer_discount_percentage1_pop  = parseInt(edit_footer_discount_percentage1.get());
  var edit_footer_discount_percentage2_pop  = parseInt(edit_footer_discount_percentage2.get());
  var edit_footer_discount_percentage3_pop  = parseInt(edit_footer_discount_percentage3.get());
  var edit_footer_discount1_pop             = parseInt(edit_footer_discount1.get());
  var edit_footer_discount2_pop             = parseInt(edit_footer_discount2.get());
  var edit_footer_discount3_pop             = parseInt(edit_footer_discount3.get());
  var footer_sub_total_val                  = parseInt(footer_sub_total.get());
  var total_disc = parseInt(edit_footer_discount1_pop + edit_footer_discount2_pop + edit_footer_discount3_pop);
  footer_total_discount.set(total_disc);
  footer_total_invoice.set(footer_sub_total_val - total_disc);
  footer_remaining_debt.set(footer_sub_total_val - total_disc);
  $('#footerdiscount').modal('hide')
});

$('#ppnchecked').on('change', function (event) {
  const checked = $(this).is(':checked');
  if (checked == true) {
    let footer_sub_total_val = parseInt(footer_sub_total.get());
    let footer_total_discount_val = parseInt(footer_total_discount.get());
    let footer_dp_val = parseInt(footer_dp.get());
    let ppn = (footer_sub_total_val - footer_total_discount_val) * 11 / 100;
    footer_total_ppn.set(ppn);
    footer_total_invoice.set(footer_sub_total_val - footer_total_discount_val + ppn);
    footer_remaining_debt.set(footer_sub_total_val - footer_total_discount_val + ppn - footer_dp_val);
  }else{
    footer_total_ppn.set(0);
  }
})

$('#footer_dp').on('input', function (event) {
 let footer_dp_val =  parseInt(footer_dp.get());
 let footer_total_invoice_val = parseInt(footer_total_invoice.get());
 footer_remaining_debt.set(footer_total_invoice_val - footer_dp_val);
})


$('#sales_order_customer').on('change', function (event) {
  let customer_id = this.value;
  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>Sales/get_customer_rate",
    dataType: "json",
    data: {customer_id:customer_id},
    success : function(data){
      if (data.code == "200"){
        $('#sales_order_rate_customer').val(data.result[0].customer_rate)
      }
    }
  });
})

function get_edit_data()
{
  let sales_order_id = $("#sales_order_id").val();

  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>Sales/get_edit_sales_order_data",
    dataType: "json",
    data: {sales_order_id:sales_order_id},
    success : function(data){
      if (data.code == "200"){
        let header = data.header[0];
        let detail = data.detail[0];

        $("#sales_order_invoice").val(header.hd_sales_order_inv);

        $("#sales_order_top").val(header.hd_sales_order_top_id).trigger('change');
        $("#sales_order_customer").val(header.hd_sales_order_customer).trigger('change');
        $("#sales_order_payment").val(header.hd_sales_order_payment).trigger('change');
        $("#sales_order_salesman").val(header.hd_sales_order_salesman).trigger('change');

        $("#sales_order_prepare").val(header.hd_sales_order_prepare);
        $("#sales_order_colly").val(header.hd_sales_order_colly);

        $("#sales_order_warehouse").val(header.hd_sales_order_warehouse).trigger('change');
        $("#sales_order_ekspedisi").val(header.hd_sales_order_ekspedisi).trigger('change');

        $('#drop_ship').val(header.hd_sales_order_dropship).trigger('change');

        if(header.hd_sales_order_dropship == 'Y'){
          $("#dropship_name").val(header.hd_sales_order_dropship_name);
          $("#dropship_phone").val(header.hd_sales_order_dropship_phone);
          $("#dropship_address").val(header.hd_sales_order_dropship_address);
        }
        edit_footer_discount_percentage1.set(header.hd_sales_order_percentage1);
        edit_footer_discount1.set(header.hd_sales_order_disc1);
        edit_footer_discount_percentage2.set(header.hd_sales_order_percentage2);
        edit_footer_discount2.set(header.hd_sales_order_disc2);
        edit_footer_discount_percentage3.set(header.hd_sales_order_percentage3);
        edit_footer_discount3.set(header.hd_sales_order_disc3);
        footer_total_discount.set(header.hd_sales_order_total_discount);
        footer_total_ppn.set(header.hd_sales_order_ppn);
        if(header.hd_sales_order_ppn > 0 ){
          $('#ppnchecked').prop('checked', true);
        }else{
          $('#ppnchecked').prop('checked', false);
        }
        
      }
    },
    error: function(xhr, status, error){
      console.log("ERROR AJAX:", error);
      console.log("RESPONSE:", xhr.responseText);
    }
  });
}


function check_tempt_data()
{
  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>Sales/check_temp_so",
    dataType: "json",
    data: {},
    success : function(data){
      if (data.code == "200"){
        let sub_total = data.data[0].sub_total;
        $("#sales_id").val(data.data[0].temp_so_id);
        footer_sub_total.set(sub_total);
        footer_total_invoice.set(sub_total);
        footer_remaining_debt.set(sub_total);
      }
    }
  });
}

function deletes(id)
{
  Swal.fire({
    title: 'Konfirmasi?',
    text: "Apakah Anda Yakin Menghapus Data?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Hapus'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Sales/delete_temp_so",
        dataType: "json",
        data: {id:id},
        success : function(data){
          if (data.code == "200"){
            $('#temp-salesorder-list').DataTable().ajax.reload();
            let title = 'Hapus Data';
            let message = 'Data Berhasil Di Hapus';
            let state = 'danger';
            notif_success(title, message, state);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.msg,
            })
          }
        }
      });
    }
  })
}

$("#btncancel").click(function (e) {
  Swal.fire({
    title: 'Konfirmasi?',
    text: "Apakah Anda Yakin Membatalkan Inputan",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Hapus'
  }).then((result) => {
    if (result.isConfirmed) {
     $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Sales/clear_temp",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
         window.location.href = "<?php echo base_url(); ?>/Sales/salesorder";
       }else {
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
});

new bootstrap.Modal(document.getElementById('footerdiscount'), {backdrop: 'static', keyboard: false})  

</script>