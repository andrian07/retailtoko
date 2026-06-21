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
    color: #0d6efd;
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
    background: linear-gradient(135deg, #f0f7ff 0%, #f8fbff 100%);
    border: 1.5px dashed #90c0f8;
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
    box-shadow: 0 3px 8px rgba(13,110,253,0.3);
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
    color: #0d6efd;
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
    background: linear-gradient(135deg, #0d6efd, #0a58ca);
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
    border-left: 4px solid #0d6efd;
    padding-left: 12px;
  }
  #temp-purchase-list thead th {
    background: #0d6efd;
    color: #fff;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border: none;
    white-space: nowrap;
  }
  #temp-purchase-list {
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
          <div class="title-icon"><i class="fas fa-shopping-cart"></i></div>
          <div>
            <h3>Tambah Pembelian</h3>
            <small>Form input transaksi pembelian baru</small>
          </div>
        </div>
      </div>

      <!-- ===== CARD 1: Informasi Pembelian ===== -->
      <div class="col-md-12">
        <div class="card po-header-card">
          <div class="card-body">

            <!-- Section: Dokumen -->
            <div class="po-section-title"><i class="fas fa-file-invoice"></i> Informasi Dokumen</div>
            <div class="row">
              <div class="col-md-4 po-field-group">
                <label>No Invoice</label>
                <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly="">
                <input id="purchase_order_id" name="purchase_order_id" type="hidden">
              </div>
              <div class="col-md-4 po-field-group">
                <label>No Faktur Supplier</label>
                <input id="no_faktur_supplier" name="no_faktur_supplier" type="text" class="form-control" placeholder="Masukkan no faktur">
              </div>
              <div class="col-md-4 po-field-group">
                <label>Tanggal Pembelian</label>
                <input id="purchase_date" name="purchase_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 po-field-group">
                <label>No PO <small class="text-muted">(opsional)</small></label>
                <input id="po_inv" name="po_inv" type="text" class="form-control ui-autocomplete-input" placeholder="Ketik untuk mencari PO...">
                <input id="po_id" type="hidden" name="po_id">
              </div>
              <div class="col-md-4 po-field-group">
                <label>Tanggal Faktur</label>
                <input id="faktur_date" name="faktur_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
              </div>
              <div class="col-md-4 po-field-group">
                <label>Jatuh Tempo</label>
                <input id="purchase_due_date" name="purchase_due_date" type="date" class="form-control" value="">
              </div>
            </div>

            <!-- Section: Supplier & Pembayaran -->
            <div class="po-section-title mt-2"><i class="fas fa-truck"></i> Supplier & Pembayaran</div>
            <div class="row">
              <div class="col-md-5 po-field-group supplier-highlight-po">
                <label>Supplier</label>
                <select class="form-control input-full js-example-basic-single" id="purchase_supplier" name="purchase_supplier">
                  <option value="">-- Pilih Supplier --</option>
                  <?php foreach ($data['supplier_list'] as $row) { ?>
                    <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-3 po-field-group">
                <label>Metode Bayar</label>
                <select class="form-control input-full js-example-basic-single" id="purchase_payment_method" name="purchase_payment_method">
                  <option value="">-- Pilih Metode Bayar --</option>
                  <?php foreach ($data['payment_list'] as $row) { ?>
                    <option value="<?php echo $row->payment_id; ?>"><?php echo $row->payment_name; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-2 po-field-group">
                <label>Golongan Pajak</label>
                <select class="form-control" id="purchase_tax" name="purchase_tax">
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
                    <input id="temp_dpp" name="temp_dpp" type="hidden" value="Rp 0.00" required="">
                    <input id="temp_tax" name="temp_tax" type="hidden" value="Rp 0.00" readonly="" required="">
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
                    <button id="btnadd_temp" class="btn btn-primary btn-add-temp btn-add-temp-po" title="Tambah Item"><i class="fas fa-plus"></i></button>
                  </div>
                </div>
              </div>
            </form>

            <div class="table-responsive">
              <table id="temp-purchase-list" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Kode Prouk</th>
                    <th>Produk</th>
                    <th>Satuan</th>
                    <th>Harga</th>
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
                <div class="po-section-title"><i class="fas fa-sticky-note"></i> Catatan Pembelian</div>
                <textarea id="purchase_order_remark" name="purchase_order_remark" class="form-control" placeholder="Tuliskan catatan pembelian di sini..." maxlength="500" rows="9" style="border-radius:8px; resize:none;"></textarea>
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
                    <input id="footer_discount1" name="footer_discount1" type="hidden" value="Rp 0.00" readonly="">
                    <input id="footer_discount2" name="footer_discount2" type="hidden" value="Rp 0.00" readonly="">
                    <input id="footer_discount3" name="footer_discount3" type="hidden" value="Rp 0.00" readonly="">
                    <input id="footer_discount_percentage1" name="footer_discount_percentage1" type="hidden" value="0.00%" readonly="">
                    <input id="footer_discount_percentage2" name="footer_discount_percentage2" type="hidden" value="0.00%" readonly="">
                    <input id="footer_discount_percentage3" name="footer_discount_percentage3" type="hidden" value="0.00%" readonly="">
                    <input id="footer_total_discount" name="footer_total_discount" data-bs-toggle="modal" data-bs-target="#footerdiscount" type="text" class="summary-input" value="0" readonly="" style="cursor:pointer;" title="Klik untuk ubah diskon">
                  </div>
                  <div class="summary-row">
                    <span class="summary-label">DPP</span>
                    <input id="footer_dpp" name="footer_dpp" type="text" class="summary-input" value="0" readonly="">
                  </div>
                  <div class="summary-row">
                    <span class="summary-label">PPN 11%</span>
                    <input id="footer_total_ppn" name="footer_total_ppn" type="text" class="summary-input" value="0" readonly="">
                  </div>
                  <div class="summary-row">
                    <span class="summary-label">Ongkir</span>
                    <input id="footer_total_ongkir" name="footer_total_ongkir" type="text" class="summary-input" value="0" readonly="">
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

  $('#purchase_tax').prop('disabled', true);
  $('#po_user_id').prop('disabled', true);
  

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
    temppurchase_table();
  });

  function temppurchase_table(){
    $('#temp-purchase-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Purchase/temp_purchase_list',
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
            $('#temp-purchase-list').DataTable().ajax.reload();
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
          url: "<?php echo base_url(); ?>Purchase/delete_temp_purchase",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              $('#temp-purchase-list').DataTable().ajax.reload();
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

  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      let supplier = $('#purchase_supplier').val();
      if (!supplier) {
        Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Silahkan Isi Supplier Terlebih Dahulu',
				})
        $('#product_name').val('');
      }
      $.ajax({
        url: '<?php echo base_url(); ?>Globalext/search_product_purchase?supid='+$('#purchase_supplier').val(),
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

      var edit_footer_discount1_pop  = parseInt(edit_footer_discount1.get());
      var edit_footer_discount2_pop  = parseInt(edit_footer_discount2.get());
      var edit_footer_discount3_pop  = parseInt(edit_footer_discount3.get());

      var footer_sub_total_val  = parseInt(footer_sub_total.get());
      var footer_total_ongkir_val = parseInt(footer_total_ongkir.get());
      var purchase_tax = $('#purchase_tax').val();

      var total_disc = edit_footer_discount1_pop + edit_footer_discount2_pop + edit_footer_discount3_pop;
      footer_total_discount.set(total_disc);

      let dpp = footer_sub_total_val - total_disc;
      footer_dpp.set(dpp);

      console.log(purchase_tax);

      let ppn = 0; // deklarasi di luar if

      if(purchase_tax == 'PPN'){
          ppn = dpp * 11 / 100;
      }

      footer_total_ppn.set(ppn);

      let total_all_invoice = dpp + ppn + footer_total_ongkir_val;
      footer_total_invoice.set(total_all_invoice);

      $('#footerdiscount').modal('hide');
  });
   
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

  function edit_temp(id)
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/get_edit_temp_purchase",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          var row = data.result[0];
          $("#product_name").val(row.product_name);
          $("#product_id").val(row.temp_product_id);
          temp_price.set(row.temp_purchase_price);
          $("#temp_qty").val(row.temp_purchase_qty);
          $("#temp_weight").val(row.temp_purchase_weight);
          temp_delivery_price.set(row.temp_purchase_ongkir);
          $("#temp_total_weight").val(row.temp_purchase_total_weight);
          temp_ongkir.set(row.temp_purchase_total_ongkir);
          temp_total.set(row.temp_purchase_total);
          $("#temp_note").val(row.temp_purchase_note);
        }
      }
    });  
  }

  function check_tempt_data()
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/check_temp_purchase",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
          let row = data.data[0];
          footer_sub_total.set(row.sub_total);
          $('#po_inv').val(row.hd_po_invoice);
          $('#po_id').val(row.hd_po_id);
          $('#purchase_payment_method').val(row.hd_po_payment);
          $('#purchase_payment_method').trigger('change');;
          $('#purchase_tax').val(row.hd_po_tax);
          $('#purchase_supplier').val(row.hd_po_supplier);
          $('#purchase_supplier').trigger('change');
          edit_footer_discount_percentage1.set(row.hd_po_disc_percentage1);
          edit_footer_discount_percentage2.set(row.hd_po_disc_percentage2);
          edit_footer_discount_percentage3.set(row.hd_po_disc_percentage3);
          edit_footer_discount1.set(row.hd_po_disc_1);
          edit_footer_discount2.set(row.hd_po_disc_2);
          edit_footer_discount3.set(row.hd_po_disc_3);
          footer_total_discount.set(row.hd_po_total_discount);
          footer_dpp.set(row.hd_po_dpp);
          footer_total_ppn.set(row.hd_po_ppn);
          footer_total_invoice.set(row.hd_po_grand_total);
        }
      }
    });
  }

  function duedate_cal()
  {
    var purchase_top = document.getElementById("purchase_top").value;
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/cal_due_date",
      dataType: "json",
      data: {po_top:purchase_top},
      success : function(data){
        if (data.code == "200"){
          $('#purchase_due_date').val(data.result);
          $('#purchase_due_date').trigger('change');
        }
      }
    });
  }

  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var product_id              = $("#product_id").val();
    var temp_price_val          = parseInt(temp_price.get());
    var temp_qty                = $("#temp_qty").val();
    var temp_total_val          = parseInt(temp_total.get());
    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/add_temp_purchase",
        dataType: "json",
        data: {product_id:product_id, temp_price_val:temp_price_val, temp_qty:temp_qty, temp_total_val:temp_total_val},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Data Berhasil Di Tambah';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-purchase-list').DataTable().ajax.reload();
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
    var po_inv                                   = $("#po_inv").val();
    var po_id                                    = $("#po_id").val();
    var purchase_top                             = $("#purchase_top option:selected" ).text();
    var purchase_top_id                          = $("#purchase_top").val();
    var purchase_payment_method                  = $("#purchase_payment_method").val();
    var purchase_supplier                        = $("#purchase_supplier").val();
    var no_faktur_supplier                       = $("#no_faktur_supplier").val();
    var faktur_date                              = $("#faktur_date").val();
    var purchase_ekspedisi                       = $("#purchase_ekspedisi").val();
    var purchase_tax                             = $("#purchase_tax").val();
    var purchase_date                            = $("#purchase_date").val();
    var purchase_warehouse                       = $("#purchase_warehouse").val();
    var purchase_due_date                        = $("#purchase_due_date").val();
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
    var purchase_remark                         = $("#purchase_remark").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/save_purchase",
      dataType: "json",
      data: {po_inv:po_inv, po_id:po_id, purchase_top:purchase_top, purchase_top_id:purchase_top_id, purchase_payment_method:purchase_payment_method, purchase_supplier:purchase_supplier, no_faktur_supplier:no_faktur_supplier, faktur_date:faktur_date, purchase_ekspedisi:purchase_ekspedisi, purchase_tax:purchase_tax, purchase_date:purchase_date, purchase_warehouse:purchase_warehouse, purchase_due_date:purchase_due_date, footer_sub_total_submit:footer_sub_total_submit, footer_total_discount_submit:footer_total_discount_submit, edit_footer_discount_percentage1_submit:edit_footer_discount_percentage1_submit, edit_footer_discount_percentage2_submit:edit_footer_discount_percentage2_submit, edit_footer_discount_percentage3_submit:edit_footer_discount_percentage3_submit, edit_footer_discount1_submit:edit_footer_discount1_submit, edit_footer_discount2_submit:edit_footer_discount2_submit, edit_footer_discount3_submit:edit_footer_discount3_submit, footer_dpp_val:footer_dpp_val, footer_total_ppn_val:footer_total_ppn_val, footer_total_ongkir_val:footer_total_ongkir_val, footer_total_invoice_val:footer_total_invoice_val, purchase_remark:purchase_remark},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Purchase";
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
        url: "<?php echo base_url(); ?>Purchase/clear_temp_purchase",
        dataType: "json",
        data: {},
        success : function(data){
          if (data.code == "200"){
           window.location.href = "<?php echo base_url(); ?>/Purchase";
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