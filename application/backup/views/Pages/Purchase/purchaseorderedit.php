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
      <h3 class="fw-bold mb-3">Tambah PO </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>
              <div class="col-sm-3">
                <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly="">
                <input id="purchase_order_id" name="purchase_order_id" type="hidden" class="form-control" value="<?php echo $_GET['id']; ?>">
              </div> 
              <label for="tanggal" class="col-sm-1 col-form-label text-right">T.O.P :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" onchange="duedate_cal()" id="po_top" name="po_top">
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
                <input id="po_date" name="po_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly="">
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Supplier Baru:</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="po_supplier" name="po_supplier">
                  <option value="">-- Pilih Supplier --</option>
                  <?php foreach ($data['supplier_list'] as $row) { ?>
                    <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>  
                  <?php } ?>
                </select>
                <input id="po_supplier_code" name="po_supplier_code" type="hidden" class="form-control" value="" readonly="">
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Jatuh Tempo :</label>
              <div class="col-sm-3">
                <input id="purchase_order_due_date" name="purchase_order_due_date" type="date" class="form-control" value="" readonly="">
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Gudang :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="po_warehouse" name="po_warehouse">
                  <option value="">-- Pilih Gudang --</option>
                  <?php foreach ($data['warehouse_list'] as $row) { ?>
                    <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Golongan :</label>
              <div class="col-sm-3">
                <select class="form-control" id="po_tax" name="po_tax">
                  <option value="PPN">BKP</option>
                  <option value="NON PPN">NON BKP</option>
                </select>
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Metode Bayar :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="po_payment_method" name="po_payment_method">
                  <option value="">-- Pilih Metode Bayar --</option>
                  <?php foreach ($data['payment_list'] as $row) { ?>
                    <option value="<?php echo $row->payment_id; ?>"><?php echo $row->payment_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">User :</label>
              <div class="col-sm-3">
                <input id="po_user_id" name="po_user_id" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Ekspedisi :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="po_ekspedisi" name="po_ekspedisi">
                  <option value="">-- Pilih Ekspedisi --</option>
                  <?php foreach ($data['ekspedisi_list'] as $row) { ?>
                    <option value="<?php echo $row->ekspedisi_id; ?>"><?php echo $row->ekspedisi_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
              <div class="col-sm-8"></div>
            </div>


          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form id="formaddtemp">
              <div class="row well well-sm input-temp">
                <input id="temp_po_id" name="temp_po_id" type="hidden" value="">
                <input id="item_id" name="item_id" type="hidden" value="">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>No Pengajuan:</label>
                    <input id="submission_inv" name="submission_inv" type="text" class="form-control ui-autocomplete-input" placeholder="Pilih Pengajuan">
                    <input id="submission_id" type="hidden" name="submission_id">
                    <input id="submission_code" type="hidden" name="submission_code">
                  </div>
                </div>


                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Produk</label>
                    <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan nama produk" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk"required="">
                    <input id="product_id" type="hidden" name="product_id">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Harga Beli Per Unit</label>
                    <input id="temp_price" name="temp_price" class="form-control text-right" value="0" required="">
                    <input id="temp_dpp" name="temp_dpp" type="hidden" class="form-control text-right" value="Rp 0.00" required="">
                    <input id="temp_tax" name="temp_tax" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="" required="">
                  </div>
                </div>


                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Qty</label>
                    <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="">
                  </div>
                </div>



                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Berat</label>
                    <input id="temp_weight" name="temp_weight" type="text" class="form-control text-right" value="0">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Ongkir</label>
                    <input id="temp_delivery_price" name="temp_delivery_price" type="text" class="form-control text-right" value="0">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Total Berat</label>
                    <input id="temp_total_weight" name="temp_total_weight" type="text" class="form-control text-right" value="0" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Total Ongkir</label>
                    <input id="temp_ongkir" name="temp_ongkir" type="text" class="form-control text-right" value="0" readonly>
                  </div>
                </div>


                <div class="col-sm-3">

                  <!-- text input -->

                  <div class="form-group">

                    <label>Total</label>

                    <input id="temp_total" name="temp_total" type="text" class="form-control text-right" value="0" readonly="">

                  </div>

                </div>

                  <div class="col-sm-11">

                  <!-- text input -->

                  <div class="form-group">

                    <label>Catatan</label>

                    <input id="temp_note" name="temp_note" type="text" class="form-control">

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
              <table id="temp-po-list" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>No Pengajuan</th>
                    <th>SKU</th>
                    <th>Produk</th>
                    <th>Satuan</th>
                    <th>Harga Beli</th>
                    <th>Qty</th>
                    <th>Ongkir per pcs</th>
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
                    <textarea id="purchase_remark" name="purchase_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="8"></textarea>
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
                  <label for="footer_dpp" class="col-sm-7 col-form-label text-right:">DPP :</label>
                  <div class="col-sm-5">
                    <input id="footer_dpp" name="footer_dpp" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="footer_total_ppn" class="col-sm-7 col-form-label text-right:">PPN 11% :</label>
                  <div class="col-sm-5">
                    <input id="footer_total_ppn" name="footer_total_ppn" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="footer_total_ongkir" class="col-sm-7 col-form-label text-right:">Ongkir:</label>
                  <div class="col-sm-5">
                    <input id="footer_total_ongkir" name="footer_total_ongkir" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="footer_total_invoice" class="col-sm-7 col-form-label text-right:">Grand Total :</label>
                  <div class="col-sm-5">
                    <input id="footer_total_invoice" name="footer_total_invoice" type="text" class="form-control text-right" value="0" readonly="">
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

  let footer_dpp = new AutoNumeric('#footer_dpp', {
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

  let footer_total_ongkir = new AutoNumeric('#footer_total_ongkir', {
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
    temppo_table();
    get_header_edit();
  });

  function temppo_table(){
    $('#temp-po-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Purchase/temp_po_list',
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
        {data: 8},
        {data: 9},
      ]
    });
    check_tempt_data();
  }

  $('#submission_inv').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Purchase/search_submission',
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
      let product_weight = ui.item.product_weight;
      let qty = ui.item.qty;
      let code = ui.item.code;
      $('#submission_id').val(id);
      $('#submission_code').val(code);
      $('#product_name').val(product_name);
      $('#product_id').val(product_id);
      $('#temp_qty').val(qty);
      temp_price.set(product_price);
      $('#temp_weight').val(product_weight);
      let temp_qty_val = $('#temp_qty').val();
      let temp_weight_val = $('#temp_weight').val();
      let temp_total_weight_val = temp_qty_val * temp_weight_val;
      $('#temp_total_weight').val(temp_total_weight_val);
      let temp_total_val = product_price * qty;
      temp_total.set(temp_total_val);
    },
  });


  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Purchase/search_product',
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
      let product_weight = ui.item.product_weight;
      //$('#submission_id').val(id);
      //$('#submission_code').val('');
      //$('#product_name').val(product_name);
      $('#product_id').val(id);
      temp_price.set(product_price);
      $('#temp_weight').val(product_weight);
    },
  });

  

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

  $('#temp_qty').on('input', function (event) {
    let temp_price_val = parseInt(temp_price.get());
    let temp_qty_val = $('#temp_qty').val();
    let temp_weight_val = $('#temp_weight').val();
    let temp_total_weight_val = temp_qty_val * temp_weight_val;
    $('#temp_total_weight').val(temp_total_weight_val);
    let temp_ongkir_val = parseInt(temp_ongkir.get());
    let temp_total_val = temp_price_val * temp_qty_val + temp_ongkir_val;
    temp_total.set(temp_total_val);
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
      let temp_total_weight_val = $('#temp_total_weight').val();
      let temp_ongkir_val = temp_delivery_price_val * temp_total_weight_val;
      temp_ongkir.set(temp_ongkir_val);
      let temp_total_val = temp_price_val * temp_qty_val + temp_ongkir_val;
      temp_total.set(temp_total_val);
    }
  })

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
  

  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var submission_id           = $("#submission_id").val();
    var submission_code         = $("#submission_code").val();
    var product_id              = $("#product_id").val();
    var po_supplier             = $("#po_supplier").val();
    var temp_price_val          = parseInt(temp_price.get());
    var temp_qty                = $("#temp_qty").val();
    var temp_weight             = $("#temp_weight").val();
    var temp_delivery_price_val = parseInt(temp_delivery_price.get());
    var temp_total_weight       = $("#temp_total_weight").val();
    var temp_ongkir_val         = parseInt(temp_ongkir.get());
    var temp_total_val          = parseInt(temp_total.get());
    var temp_po_note            = $("#temp_note").val();

    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/add_temp_po",
        dataType: "json",
        data: {submission_id:submission_id, submission_code:submission_code, product_id:product_id, po_supplier:po_supplier, temp_price_val:temp_price_val, temp_qty:temp_qty, temp_weight:temp_weight, temp_delivery_price_val:temp_delivery_price_val, temp_total_weight:temp_total_weight, temp_ongkir_val:temp_ongkir_val, temp_total_val:temp_total_val, temp_note:temp_po_note},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Data Berhasil Di Tambah';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-po-list').DataTable().ajax.reload();
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
    var purchase_order_id                        = $("#purchase_order_id").val();
    var purchase_order_invoice                   = $("#purchase_order_invoice").val();
    var po_supplier                              = $("#po_supplier").val();
    var po_date                                  = $("#po_date").val();
    var po_tax                                   = $("#po_tax").val();
    var po_ekspedisi                             = $("#po_ekspedisi").val();
    var po_top                                   = $("#po_top option:selected" ).text();
    var purchase_order_due_date                  = $("#purchase_order_due_date").val();
    var po_payment_method                        = $("#po_payment_method").val();
    var po_warehouse                             = $("#po_warehouse").val();
    var footer_sub_total_submit                  = parseInt(footer_sub_total.get());
    var footer_total_discount_submit             = parseInt(footer_total_discount.get());
    var edit_footer_discount_percentage1_submit  = parseInt(edit_footer_discount_percentage1.get());
    var edit_footer_discount_percentage2_submit  = parseInt(edit_footer_discount_percentage2.get());
    var edit_footer_discount_percentage3_submit  = parseInt(edit_footer_discount_percentage3.get());
    var edit_footer_discount1_submit             = parseInt(edit_footer_discount1.get());
    var edit_footer_discount2_submit             = parseInt(edit_footer_discount2.get());
    var edit_footer_discount3_submit             = parseInt(edit_footer_discount3.get());
    var footer_dpp_val                           = parseInt(footer_dpp.get());
    var footer_total_ppn_val                     = parseInt(footer_total_ppn.get());
    var footer_total_ongkir_val                  = parseInt(footer_total_ongkir.get());
    var footer_total_invoice_val                 = parseInt(footer_total_invoice.get());
    var purchase_order_remark                    = $("#purchase_order_remark").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/save_edit",
      dataType: "json",
      data: {purchase_order_id:purchase_order_id, purchase_order_invoice:purchase_order_invoice, po_supplier:po_supplier, po_date:po_date, po_tax:po_tax, po_ekspedisi:po_ekspedisi, po_top:po_top, purchase_order_due_date:purchase_order_due_date, po_payment_method:po_payment_method, po_warehouse:po_warehouse, footer_sub_total_submit:footer_sub_total_submit, footer_total_discount_submit:footer_total_discount_submit, edit_footer_discount_percentage1_submit:edit_footer_discount_percentage1_submit, edit_footer_discount_percentage2_submit:edit_footer_discount_percentage2_submit, edit_footer_discount_percentage3_submit:edit_footer_discount_percentage3_submit, edit_footer_discount1_submit:edit_footer_discount1_submit, edit_footer_discount2_submit:edit_footer_discount2_submit, edit_footer_discount3_submit:edit_footer_discount3_submit, footer_dpp_val:footer_dpp_val, footer_total_ppn_val:footer_total_ppn_val, footer_total_ongkir_val:footer_total_ongkir_val, footer_total_invoice_val:footer_total_invoice_val, purchase_order_remark:purchase_order_remark},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Purchase/po";
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
          url: "<?php echo base_url(); ?>Purchase/delete_temp_po",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){

              let title = 'Hapus Data';
              let message = 'Data Berhasil Di Hapus';
              let state = 'danger';
              notif_success(title, message, state);
              check_tempt_data();
              $('#temp-po-list').DataTable().ajax.reload();
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

  function get_header_edit()
  {

    let purchase_order_id =  $("#purchase_order_id").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/get_header_edit",
      dataType: "json",
      data: {purchase_order_id:purchase_order_id},
      success : function(data){
        if (data.code == "200"){
          var row = data.data[0];
          
          $("#purchase_order_invoice").val(row.hd_po_invoice);
          $("#purchase_order_id").val(row.hd_po_id);
          $("#po_supplier").val(row.supplier_id);
          $('#po_supplier').trigger('change');
          $("#po_ekspedisi").val(row.ekspedisi_id);  
          $('#po_ekspedisi').trigger('change');  
          $("#po_payment_method").val(row.hd_po_payment); 
          $('#po_payment_method').trigger('change');
          $("#po_warehouse").val(row.hd_po_warehouse); 
          $('#po_warehouse').trigger('change');
        }
      }
    });  
  }

  function edit_temp(id)
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/get_edit_temp_po",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          var row = data.result[0];
          if(row.temp_submission_id != 0){
            $("#submission_inv").val(row.product_name+'('+row.submission_invoice +')');
            $("#submission_code").val(row.submission_invoice );
            $("#submission_id").val(row.submission_id);
          }else{
            $("#submission_inv").val("");
            $("#submission_code").val("");
            $("#submission_id").val(0);
          }
          $("#product_name").val(row.product_name);
          $("#product_id").val(row.product_id);
          temp_price.set(row.temp_po_price);
          $("#temp_qty").val(row.temp_po_qty);
          $("#temp_weight").val(row.temp_po_weight);
          temp_delivery_price.set(row.temp_po_ongkir);
          $("#temp_total_weight").val(row.temp_po_total_weight);
           $("#temp_note").val(row.temp_po_note);
          temp_ongkir.set(row.temp_po_total_ongkir);
          temp_total.set(row.temp_po_total);
        }
      }
    });  
  }


  function check_tempt_data()
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/check_temp_po",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
          if(data.supplier == 0){
            $('#po_tax').val('');
            $('#po_tax').prop('disabled', false);
            footer_sub_total.set(0);
            footer_dpp.set(0); 
            footer_total_ppn.set(0);
            footer_total_ongkir.set(0);
            footer_total_invoice.set(0);
          }else{
            $("#po_supplier").val(data.supplier_id);
            $('#po_supplier').trigger('change');
            $("#po_supplier_code").val(data.supplier_code);
            $('#po_tax').val(data.product_tax);
            $('#po_tax').prop('disabled', true);
            footer_sub_total.set(data.sub_total);
            footer_dpp.set(data.sub_total); 
            if(data.product_tax == 'PPN'){
              var ppn_cal = data.sub_total * 11 / 100;
              footer_total_ppn.set(ppn_cal);
            }else{
              var ppn_cal = 0;
              footer_total_ppn.set(ppn_cal);
            }
            footer_total_ongkir.set(data.ongkir);
            var data_ongkir = parseInt(data.ongkir, 0);
            var data_sub_total = parseInt(data.sub_total, 0);
            var data_ppn_cal = parseInt(ppn_cal, 0);
            var footer_total_invoice_cal = (data_ongkir + data_sub_total + data_ppn_cal);
            footer_total_invoice.set(footer_total_invoice_cal);
          }
        }
      }
    });
  }

  function clear_input()
  {
    $('#submission_inv').val('');
    $("#submission_code").val('');
    $('#submission_id').val('');
    $('#product_name').val('');
    $('#product_id').val('');
    temp_price.set(0);
    $('#temp_qty').val('');
    $('#temp_weight').val('');
    temp_delivery_price.set(0);
    $('#temp_total_weight').val(0);
    $('#temp_note').val('');
    temp_ongkir.set(0);
    temp_total.set(0);
  }

  function duedate_cal()
  {
    var po_top = document.getElementById("po_top").value;
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/cal_due_date",
      dataType: "json",
      data: {po_top:po_top},
      success : function(data){
        if (data.code == "200"){
          $('#purchase_order_due_date').val(data.result);
        }
      }
    });
  }


  $('#btneditdisc').click(function(e){
    e.preventDefault();
    var edit_footer_discount_percentage1_pop  = parseInt(edit_footer_discount_percentage1.get());
    var edit_footer_discount_percentage2_pop  = parseInt(edit_footer_discount_percentage2.get());
    var edit_footer_discount_percentage3_pop  = parseInt(edit_footer_discount_percentage3.get());
    var edit_footer_discount1_pop             = parseInt(edit_footer_discount1.get());
    var edit_footer_discount2_pop             = parseInt(edit_footer_discount2.get());
    var edit_footer_discount3_pop             = parseInt(edit_footer_discount3.get());
    var footer_sub_total_val                  = parseInt(footer_sub_total.get());
    var footer_total_ongkir_val               = parseInt(footer_total_ongkir.get());
    var po_tax                                = $('#po_tax').val();
    var total_disc = parseInt(edit_footer_discount1_pop + edit_footer_discount2_pop + edit_footer_discount3_pop);
    footer_total_discount.set(total_disc);
    footer_dpp.set(footer_sub_total_val - total_disc);
    if(po_tax == 'PPN'){
      footer_total_ppn.set((footer_sub_total_val - total_disc) * 11 / 100);
    }
    footer_total_invoice.set(((footer_sub_total_val - total_disc) + (footer_sub_total_val - total_disc) * 11 / 100) + footer_total_ongkir_val);
    $('#footerdiscount').modal('hide')
  });

  

  new bootstrap.Modal(document.getElementById('footerdiscount'), {backdrop: 'static', keyboard: false})  
  
</script>