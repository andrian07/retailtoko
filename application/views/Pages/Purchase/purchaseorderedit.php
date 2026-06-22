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
  .po-section-title i {
    color: #fd7e14;
    font-size: 0.9rem;
  }
  .card.po-header-card {
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    border-radius: 12px;
  }
  .card.po-header-card .card-body {
    padding: 24px 28px;
  }
  .po-field-group {
    margin-bottom: 18px;
  }
  .po-field-group label {
    font-size: 0.78rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
    display: block;
  }
  .po-field-group .form-control {
    border-radius: 8px;
    font-size: 0.875rem;
  }
  .po-field-group .form-control[readonly] {
    background-color: #f8f9fa;
    color: #6c757d;
  }
  .card.po-detail-card {
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    border-radius: 12px;
    margin-top: 8px;
  }
  .card.po-detail-card .card-body {
    padding: 24px 28px;
  }
  .input-temp-wrapper-po {
    background: linear-gradient(135deg, #fff8f0 0%, #fffaf5 100%);
    border: 1.5px dashed #ffc078;
    border-radius: 10px;
    padding: 18px 20px 8px 20px;
    margin-bottom: 20px;
  }
  .btn-add-temp-po {
    height: 38px;
    width: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    font-size: 1rem;
    box-shadow: 0 3px 8px rgba(253,126,20,0.3);
  }
  .po-summary-card {
    background: linear-gradient(135deg, #f4f6f9 0%, #eaecef 100%);
    border: 1px solid #dee2e6;
    border-radius: 12px;
    padding: 20px 24px;
    color: #343a40;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  }
  .po-summary-card .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 0;
    border-bottom: 1px solid #dee2e6;
    font-size: 0.875rem;
  }
  .po-summary-card .summary-row:last-child {
    border-bottom: none;
  }
  .po-summary-card .summary-row .summary-label {
    color: #6c757d;
    font-weight: 600;
  }
  .po-summary-card .summary-row .summary-input {
    background: #fff;
    border: 1px solid #ced4da;
    border-radius: 6px;
    color: #343a40;
    text-align: right;
    font-weight: 600;
    width: 170px;
    padding: 4px 10px;
    font-size: 0.875rem;
  }
  .po-summary-card .summary-row .summary-input[readonly] {
    cursor: default;
    background: #f8f9fa;
  }
  .po-summary-card .summary-row.ppn-row {
    align-items: center;
    gap: 8px;
  }
  .po-summary-card .summary-row.ppn-row .ppn-check {
    width: 20px;
    height: 20px;
    accent-color: #fd7e14;
    cursor: pointer;
    flex-shrink: 0;
  }
  .po-summary-card .summary-row.grand-total-row {
    padding-top: 10px;
    font-size: 1rem;
    font-weight: 700;
    border-top: 2px solid #adb5bd;
  }
  .po-summary-card .summary-row.grand-total-row .summary-label {
    color: #212529;
  }
  .po-summary-card .summary-row.grand-total-row .summary-input {
    font-size: 1rem;
    background: #e9ecef;
    border-color: #adb5bd;
    color: #fd7e14;
  }
  .po-page-title-bar {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
  }
  .po-page-title-bar .title-icon {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, #fd7e14, #e8650a);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.1rem;
    flex-shrink: 0;
  }
  .po-page-title-bar h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: #2d3748;
  }
  .po-page-title-bar small {
    color: #6c757d;
    font-size: 0.8rem;
  }
  .supplier-highlight-po {
    border-left: 4px solid #fd7e14;
    padding-left: 12px;
  }
  #temp-po-list thead th {
    background: #fd7e14;
    color: #fff;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border: none;
    white-space: nowrap;
  }
  #temp-po-list {
    border-radius: 8px;
    overflow: hidden;
    font-size: 0.86rem;
  }
</style>

<div class="container">
  <div class="page-inner">
    <div class="page-header"></div>
    <div class="row">

      <!-- Page Title -->
      <div class="col-md-12 mb-2">
        <div class="po-page-title-bar">
          <div class="title-icon"><i class="fas fa-edit"></i></div>
          <div>
            <h3>Edit Purchase Order</h3>
            <small>Ubah data PO pembelian ke supplier</small>
          </div>
        </div>
      </div>

      <!-- ===== CARD 1: Informasi PO ===== -->
      <div class="col-md-12">
        <div class="card po-header-card">
          <div class="card-body">

            <!-- Section: Dokumen -->
            <div class="po-section-title"><i class="fas fa-file-invoice"></i> Informasi Dokumen</div>
            <div class="row">
              <div class="col-md-4 po-field-group">
                <label>No Invoice PO</label>
                <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly="">
                <input id="purchase_order_id" name="purchase_order_id" type="hidden" value="<?php echo $_GET['id']; ?>">
              </div>
              <div class="col-md-4 po-field-group">
                <label>Tanggal PO</label>
                <input id="po_date" name="po_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly="">
              </div>
              <div class="col-md-4 po-field-group">
                <label>Jatuh Tempo</label>
                <input id="purchase_order_due_date" name="purchase_order_due_date" type="date" class="form-control" value="" readonly="">
              </div>
            </div>

            <!-- Section: Supplier & Pembayaran -->
            <div class="po-section-title mt-2"><i class="fas fa-truck"></i> Supplier & Pembayaran</div>
            <div class="row">
              <div class="col-md-5 po-field-group supplier-highlight-po">
                <label>Supplier</label>
                <select class="form-control input-full js-example-basic-single" id="po_supplier" name="po_supplier">
                  <option value="">-- Pilih Supplier --</option>
                  <?php foreach ($data['supplier_list'] as $row) { ?>
                    <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>
                  <?php } ?>
                </select>
                <input id="po_supplier_code" name="po_supplier_code" type="hidden" value="" readonly="">
              </div>
              <div class="col-md-3 po-field-group">
                <label>Metode Bayar</label>
                <select class="form-control input-full js-example-basic-single" id="po_payment_method" name="po_payment_method">
                  <option value="">-- Pilih Metode Bayar --</option>
                  <?php foreach ($data['payment_list'] as $row) { ?>
                    <option value="<?php echo $row->payment_id; ?>"><?php echo $row->payment_name; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-2 po-field-group">
                <label>Golongan Pajak</label>
                <select class="form-control" id="po_tax" name="po_tax">
                  <option value="PPN">BKP</option>
                  <option value="NON PPN">NON BKP</option>
                </select>
              </div>
              <div class="col-md-2 po-field-group">
                <label>User</label>
                <input id="po_user_id" name="po_user_id" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- ===== CARD 2: Detail Produk ===== -->
      <div class="col-md-12">
        <div class="card po-detail-card">
          <div class="card-body">

            <div class="po-section-title"><i class="fas fa-boxes"></i> Detail Produk</div>

            <form id="formaddtemp">
              <input id="item_id" name="item_id" type="hidden" value="">
              <div class="input-temp-wrapper-po">
                <div class="row align-items-end">
                  <div class="col-sm-5 po-field-group mb-2">
                    <label>Produk</label>
                    <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="Ketikkan nama produk..." value="" required="" autocomplete="off" data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                    <input id="product_id" type="hidden" name="product_id">
                  </div>
                  <div class="col-sm-2 po-field-group mb-2">
                    <label>Harga Beli / Unit</label>
                    <input id="temp_price" name="temp_price" class="form-control text-right" value="0" required="">
                  </div>
                  <div class="col-sm-2 po-field-group mb-2">
                    <label>Qty</label>
                    <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="">
                  </div>
                  <div class="col-sm-2 po-field-group mb-2">
                    <label>Total</label>
                    <input id="temp_total" name="temp_total" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                  <div class="col-sm-1 mb-2 d-flex flex-column align-items-center">
                    <label>&nbsp;</label>
                    <button id="btnadd_temp" class="btn btn-warning btn-add-temp btn-add-temp-po" title="Tambah Item"><i class="fas fa-plus"></i></button>
                  </div>
                </div>
              </div>
            </form>

            <div class="table-responsive">
              <table id="temp-po-list" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Kode Produk</th>
                    <th>Produk</th>
                    <th>Satuan</th>
                    <th>Harga Beli</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>

            <!-- Footer: Catatan & Ringkasan -->
            <div class="row mt-4">
              <div class="col-lg-6">
                <div class="po-section-title"><i class="fas fa-sticky-note"></i> Catatan PO</div>
                <textarea id="purchase_remark" name="purchase_remark" class="form-control" placeholder="Tuliskan catatan PO di sini..." maxlength="500" rows="9" style="border-radius:8px; resize:none;"></textarea>
              </div>

              <div class="col-lg-6">
                <div class="po-section-title"><i class="fas fa-calculator"></i> Ringkasan Pembayaran</div>
                <div class="po-summary-card">
                  <div class="summary-row">
                    <span class="summary-label">Sub Total</span>
                    <input id="footer_sub_total" name="footer_sub_total" type="text" class="summary-input" value="0" readonly="">
                  </div>
                  <div class="summary-row">
                    <span class="summary-label">Discount</span>
                    <input id="footer_discount1" name="footer_discount1" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="">
                    <input id="footer_discount2" name="footer_discount2" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="">
                    <input id="footer_discount3" name="footer_discount3" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="">
                    <input id="footer_discount_percentage1" name="footer_discount_percentage1" type="hidden" class="form-control text-right" value="0.00%" readonly="">
                    <input id="footer_discount_percentage2" name="footer_discount_percentage2" type="hidden" class="form-control text-right" value="0.00%" readonly="">
                    <input id="footer_discount_percentage3" name="footer_discount_percentage3" type="hidden" class="form-control text-right" value="0.00%" readonly="">
                    <input id="footer_total_discount" name="footer_total_discount" data-bs-toggle="modal" data-bs-target="#footerdiscount" type="text" class="summary-input" value="0" readonly="" style="cursor:pointer;" title="Klik untuk ubah diskon">
                  </div>
                  <div class="summary-row">
                    <span class="summary-label">DPP</span>
                    <input id="footer_dpp" name="footer_dpp" type="text" class="summary-input" value="0" readonly="">
                  </div>
                  <div class="summary-row ppn-row">
                    <span class="summary-label">PPN 11%</span>
                    <div class="d-flex align-items-center" style="gap:8px;">
                      <input id="footer_total_ppn" name="footer_total_ppn" type="text" class="summary-input" value="0" readonly="" style="width:140px;">
                      <input class="form-check-input ppn-check" type="checkbox" value="" id="ppn_cheked" title="Aktifkan PPN">
                    </div>
                  </div>
                  <div class="summary-row grand-total-row">
                    <span class="summary-label">Grand Total</span>
                    <input id="footer_total_invoice" name="footer_total_invoice" type="text" class="summary-input" value="0" readonly="">
                  </div>
                </div>
                <div class="mt-3 d-flex justify-content-end" style="gap:10px;">
                  <button id="btncancel" class="btn btn-danger px-4" style="border-radius:8px;"><i class="fas fa-times-circle"></i> Batal</button>
                  <button id="btnsave" class="btn btn-success button-header-custom-save px-4" style="border-radius:8px;"><i class="fas fa-save"></i> Simpan</button>
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
                      <button type="button" id="btneditdisc" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
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
        {data: 6}
      ]
    });
    check_tempt_data();
  }


  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      let supplier = $('#po_supplier').val();
      if (!supplier) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Silahkan Isi Supplier Terlebih Dahulu',
        })
        $('#product_name').val('');
      }
      $.ajax({
        url: '<?php echo base_url(); ?>Globalext/search_product_purchase?supid='+$('#po_supplier').val(),
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
      let product_price = ui.item.product_price;
      $('#product_id').val(id);
      $('#temp_qty').val(1);
      temp_price.set(product_price);
      temp_total.set(product_price);
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
    console.log(temp_total_Val);
    temp_total.set(temp_total_Val);
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
    var product_id              = $("#product_id").val();
    var po_supplier             = $("#po_supplier").val();
    var temp_price_val          = parseInt(temp_price.get());
    var temp_qty                = $("#temp_qty").val();
    var temp_total_val          = parseInt(temp_total.get());

    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/add_temp_po",
        dataType: "json",
        data: {product_id:product_id, po_supplier:po_supplier, temp_price_val:temp_price_val, temp_qty:temp_qty, temp_total_val:temp_total_val},
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
    var purchase_order_due_date                  = $("#purchase_order_due_date").val();
    var po_payment_method                        = $("#po_payment_method").val();
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
    var footer_total_invoice_val                 = parseInt(footer_total_invoice.get());
    var purchase_order_remark                    = $("#purchase_order_remark").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/save_edit_po",
      dataType: "json",
      data: {purchase_order_id:purchase_order_id, purchase_order_invoice:purchase_order_invoice, po_supplier:po_supplier, po_date:po_date, po_tax:po_tax, purchase_order_due_date:purchase_order_due_date, po_payment_method:po_payment_method, footer_sub_total_submit:footer_sub_total_submit, footer_total_discount_submit:footer_total_discount_submit, edit_footer_discount_percentage1_submit:edit_footer_discount_percentage1_submit, edit_footer_discount_percentage2_submit:edit_footer_discount_percentage2_submit, edit_footer_discount_percentage3_submit:edit_footer_discount_percentage3_submit, edit_footer_discount1_submit:edit_footer_discount1_submit, edit_footer_discount2_submit:edit_footer_discount2_submit, edit_footer_discount3_submit:edit_footer_discount3_submit, footer_dpp_val:footer_dpp_val, footer_total_ppn_val:footer_total_ppn_val, footer_total_invoice_val:footer_total_invoice_val, purchase_order_remark:purchase_order_remark},
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
          let po_ppn = row.hd_po_ppn;
          if(po_ppn > 0){
            $('#ppn_cheked').prop('checked', true);
            
          }else{
            $('#ppn_cheked').prop('checked', false);
          }
          $("#purchase_order_invoice").val(row.hd_po_invoice);
          $("#purchase_order_id").val(row.hd_po_id);
          $("#po_supplier").val(row.supplier_id);
          $('#po_supplier').trigger('change');
          $("#po_payment_method").val(row.hd_po_payment); 
          $('#po_payment_method').trigger('change');
          $("#purchase_order_due_date").val(row.hd_po_due_date);
          edit_footer_discount_percentage1.set(row.hd_po_disc_percentage1); 
          edit_footer_discount1.set(row.hd_po_disc_1); 
          edit_footer_discount_percentage2.set(row.hd_po_disc_percentage2); 
          edit_footer_discount2.set(row.hd_po_disc_2); 
          edit_footer_discount_percentage3.set(row.hd_po_disc_percentage3); 
          edit_footer_discount3.set(row.hd_po_disc_3); 
          footer_dpp.set(row.hd_po_dpp);
          footer_total_discount.set(row.hd_po_total_discount); 
          footer_total_invoice.set(row.hd_po_grand_total);
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
          $("#product_name").val(row.product_name);
          $("#product_id").val(row.product_id);
          temp_price.set(row.temp_po_price);
          $("#temp_qty").val(row.temp_po_qty);
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
            footer_total_invoice.set(0);
          }else{
            $("#po_supplier").val(data.supplier_id);
            $('#po_supplier').trigger('change');
            $("#po_supplier_code").val(data.supplier_code);
            $('#po_tax').val(data.product_tax);
            $('#po_tax').prop('disabled', true);
         
            footer_sub_total.set(data.sub_total);
            let footer_dpp_val = parseInt(data.sub_total - footer_total_discount.get());
            footer_dpp.set(footer_dpp_val); 
            var ppn_cal = 0;
            if(footer_dpp_val > 0){
              ppn_cal = footer_dpp_val * 11 / 100;
            }
            footer_total_ppn.set(ppn_cal);
            var data_sub_total = parseInt(data.sub_total, 0);
            var data_ppn_cal = parseInt(ppn_cal, 0);
            var footer_total_invoice_cal = (data_sub_total + data_ppn_cal);
            footer_total_invoice.set(footer_total_invoice_cal);
          }
        }
      }
    });
  }

  function clear_input()
  {

    $('#product_name').val('');
    $('#product_id').val('');
    temp_price.set(0);
    $('#temp_qty').val(0);
    temp_total.set(0);
    footer_total_discount.set(0);
    edit_footer_discount_percentage1.set(0);
    edit_footer_discount1.set(0);
     edit_footer_discount_percentage2.set(0);
    edit_footer_discount2.set(0);
     edit_footer_discount_percentage3.set(0);
    edit_footer_discount3.set(0);
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
    var po_tax                                = $('#po_tax').val();
    var total_disc = parseInt(edit_footer_discount1_pop + edit_footer_discount2_pop + edit_footer_discount3_pop);
    footer_total_discount.set(total_disc);
    footer_dpp.set(footer_sub_total_val - total_disc);
    var ppn_val = 0;
    if(po_tax == 'PPN' && $('#ppn_cheked').is(':checked')){
      ppn_val = (footer_sub_total_val - total_disc) * 11 / 100;
    }
    footer_total_ppn.set(ppn_val);
    footer_total_invoice.set(((footer_sub_total_val - total_disc) + ppn_val));
    $('#footerdiscount').modal('hide')
  });

  $('#ppn_cheked').change(function() {
    var footer_sub_total_val = parseInt(footer_sub_total.get());
    var total_disc = parseInt(footer_total_discount.get());
    var ppn_val = 0;
    if($(this).is(':checked')){
      ppn_val = (footer_sub_total_val - total_disc) * 11 / 100;
      $('#po_tax').val('PPN');
    }

    if(!$(this).is(':checked')){
      ppn_val = 0;
      $('#po_tax').val('NON PPN');
    }

    footer_total_ppn.set(ppn_val);
    footer_total_invoice.set(((footer_sub_total_val - total_disc) + ppn_val));
  });


  new bootstrap.Modal(document.getElementById('footerdiscount'), {backdrop: 'static', keyboard: false})  
  
</script>