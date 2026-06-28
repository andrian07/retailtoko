<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<style>
/* ===== Opname Page Styles ===== */
.opname-page-header {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 24px;
}
.opname-page-header .page-icon {
  width: 48px; height: 48px;
  background: #eef2ff;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  color: #4f6ef7;
  font-size: 1.3rem;
  flex-shrink: 0;
}
.opname-page-header h3 {
  font-size: 1.35rem;
  font-weight: 700;
  margin: 0;
  color: #1e2a4a;
}
.opname-page-header p {
  margin: 0;
  font-size: .82rem;
  color: #8a94a6;
}

/* Card wrapper */
.opname-card {
  border: none;
  border-radius: 14px;
  box-shadow: 0 2px 18px rgba(0,0,0,0.07);
  margin-bottom: 20px;
}
.opname-card .card-header-custom {
  padding: 16px 24px 14px;
  border-bottom: 1px solid #f0f2f7;
  display: flex;
  align-items: center;
  gap: 10px;
}
.opname-card .card-header-custom .ch-icon {
  width: 32px; height: 32px;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: .85rem;
  flex-shrink: 0;
}
.opname-card .card-header-custom .ch-title {
  font-size: .92rem;
  font-weight: 700;
  color: #1e2a4a;
}
.opname-card .card-body-custom { padding: 20px 24px; }

/* Info grid */
.info-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px 32px;
}
@media (max-width: 576px) { .info-grid { grid-template-columns: 1fr; } }

.info-field label {
  display: block;
  font-size: .75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .05em;
  color: #8a94a6;
  margin-bottom: 5px;
}
.info-field .form-control,
.info-field .form-select {
  border: 1.5px solid #e8ecf3;
  border-radius: 9px;
  font-size: .88rem;
  padding: 9px 13px;
  color: #1e2a4a;
  background: #fff;
  transition: border-color .2s, box-shadow .2s;
}
.info-field .form-control:focus,
.info-field .form-select:focus {
  border-color: #4f6ef7;
  box-shadow: 0 0 0 3px rgba(79,110,247,.1);
  outline: none;
}
.info-field .form-control[readonly] {
  background: #f7f8fc;
  color: #6c757d;
}

/* Product input area */
.input-panel {
  background: #f7f8fc;
  border-radius: 11px;
  padding: 20px;
  margin-bottom: 20px;
  border: 1.5px dashed #dde3f0;
}
.input-panel-grid {
  display: grid;
  grid-template-columns: 2.5fr 1fr 1fr 1fr 1fr;
  gap: 12px;
  align-items: end;
}
@media (max-width: 992px) {
  .input-panel-grid { grid-template-columns: 1fr 1fr; }
}
.input-panel-grid .form-label {
  font-size: .75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .05em;
  color: #8a94a6;
  margin-bottom: 5px;
}
.input-panel-grid .form-control {
  border: 1.5px solid #e0e5f0;
  border-radius: 9px;
  font-size: .88rem;
  padding: 9px 13px;
  transition: border-color .2s, box-shadow .2s;
}
.input-panel-grid .form-control:focus {
  border-color: #4f6ef7;
  box-shadow: 0 0 0 3px rgba(79,110,247,.1);
  outline: none;
}
.input-panel-grid .form-control[readonly] {
  background: #edf0f7;
  color: #6c757d;
}
.input-panel-note {
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 12px;
  align-items: end;
  margin-top: 12px;
}
.btn-add-item {
  width: 42px; height: 42px;
  border-radius: 10px;
  background: #4f6ef7;
  border: none;
  color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: 1rem;
  transition: background .2s, transform .15s;
}
.btn-add-item:hover { background: #3a58e0; transform: scale(1.05); }

/* Table */
#temp-opname thead th {
  background: #f7f8fc;
  color: #8a94a6;
  font-size: .73rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .05em;
  border-bottom: 2px solid #ebeef5;
  padding: 10px 14px;
}
#temp-opname tbody td {
  font-size: .85rem;
  padding: 10px 14px;
  color: #1e2a4a;
  vertical-align: middle;
}
#temp-opname tbody tr:hover { background: #f7f8fc; }

/* Summary row */
.summary-panel {
  background: #f7f8fc;
  border-radius: 11px;
  padding: 18px 20px;
}
.total-row {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 16px;
}
.total-row .total-label {
  font-size: .85rem;
  font-weight: 600;
  color: #8a94a6;
}
.total-row .form-control {
  max-width: 200px;
  border: 1.5px solid #e0e5f0;
  border-radius: 9px;
  font-size: .95rem;
  font-weight: 700;
  color: #1e2a4a;
  background: #fff;
  text-align: right;
  padding: 8px 13px;
}

.action-bar {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 16px;
}
.btn-cancel-op {
  padding: 9px 22px;
  border-radius: 9px;
  border: 1.5px solid #e0e5f0;
  background: #fff;
  color: #6c757d;
  font-size: .88rem;
  font-weight: 600;
  transition: all .2s;
}
.btn-cancel-op:hover { background: #f7f8fc; color: #e53935; border-color: #e53935; }
.btn-save-op {
  padding: 9px 26px;
  border-radius: 9px;
  border: none;
  background: #4f6ef7;
  color: #fff;
  font-size: .88rem;
  font-weight: 600;
  transition: background .2s, box-shadow .2s;
}
.btn-save-op:hover { background: #3a58e0; box-shadow: 0 4px 12px rgba(79,110,247,.3); }
</style>

<div class="container">
  <div class="page-inner">

    <!-- ===== Page Header ===== -->
    <div class="opname-page-header">
      <div class="page-icon"><i class="fas fa-clipboard-list"></i></div>
      <div>
        <h3>Tambah Opname</h3>
        <p>Isi informasi opname dan tambahkan item produk di bawah</p>
      </div>
    </div>

    <!-- ===== Info Card ===== -->
    <div class="card opname-card">
      <div class="card-header-custom">
        <div class="ch-icon" style="background:#eef2ff;color:#4f6ef7;"><i class="fas fa-info-circle"></i></div>
        <span class="ch-title">Informasi Opname</span>
      </div>
      <div class="card-body-custom">
        <div class="info-grid">
          <div class="info-field">
            <label><i class="fas fa-hashtag me-1"></i>No Opname</label>
            <input id="opname_invoice" name="opname_invoice" type="text" class="form-control" value="AUTO" readonly>
          </div>
          <div class="info-field">
            <label><i class="far fa-calendar-alt me-1"></i>Tanggal</label>
            <input id="opname_date" name="opname_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
          </div>
          <div class="info-field">
            <label><i class="fas fa-user me-1"></i>User</label>
            <input id="po_user_id" name="po_user_id" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== Input Item Card ===== -->
    <div class="card opname-card">
      <div class="card-header-custom">
        <div class="ch-icon" style="background:#e6f4ea;color:#2e7d32;"><i class="fas fa-plus-circle"></i></div>
        <span class="ch-title">Tambah Item Produk</span>
      </div>
      <div class="card-body-custom">
        <form id="formaddtemp">
          <div class="input-panel">
            <div class="input-panel-grid">
              <div>
                <label class="form-label">Produk</label>
                <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="Ketik nama produk..." value="" required autocomplete="off">
                <input id="product_id" type="hidden" name="product_id">
              </div>
              <div>
                <label class="form-label">Stok Sistem</label>
                <input id="system_stock" name="system_stock" type="text" class="form-control text-end" value="0" readonly>
              </div>
              <div>
                <label class="form-label">Stok Fisik</label>
                <input id="fisik_stock" name="fisik_stock" type="text" class="form-control text-end" value="0" required>
              </div>
              <div>
                <label class="form-label">Selisih Stok</label>
                <input id="stock_diferent" name="stock_diferent" type="text" class="form-control text-end" value="0" readonly>
              </div>
              <div>
                <label class="form-label">Selisih HPP</label>
                <input id="hpp" name="hpp" type="hidden" value="0">
                <input id="hpp_diferent" name="hpp_diferent" type="text" class="form-control text-end" value="0" readonly>
              </div>
            </div>
            <div class="input-panel-note">
              <div>
                <label class="form-label">Catatan Item</label>
                <input id="temp_note" name="temp_note" type="text" class="form-control" placeholder="Catatan tambahan (opsional)">
              </div>
              <div>
                <button id="btnadd_temp" type="button" class="btn-add-item btn-add-temp" title="Tambah Item">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
          </div>
        </form>

        <!-- ===== DataTable ===== -->
        <div class="table-responsive">
          <table id="temp-opname" class="display table table-hover w-100">
            <thead>
              <tr>
                <th>Produk</th>
                <th>Kode produk</th>
                <th>Stok Sistem</th>
                <th>Stok Fisik</th>
                <th>Selisih</th>
                <th>Selisih Rupiah</th>
                <th>Catatan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <!-- ===== Summary & Actions ===== -->
        <div class="row mt-4 g-3">
          <div class="col-lg-6">
            <label class="form-label" style="font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:#8a94a6;">
              <i class="fas fa-comment-alt me-1"></i>Catatan Opname
            </label>
            <textarea id="opname_remark" name="opname_remark" class="form-control" placeholder="Tambahkan catatan opname..." maxlength="500" rows="5"
              style="border:1.5px solid #e0e5f0;border-radius:9px;font-size:.88rem;resize:none;padding:10px 14px;"></textarea>
          </div>
          <div class="col-lg-6 d-flex flex-column justify-content-between">
            <div class="summary-panel">
              <div class="total-row">
                <span class="total-label"><i class="fas fa-calculator me-1"></i>Total Selisih HPP</span>
                <input id="total_opname" name="total_opname" type="text" class="form-control" value="0" readonly>
              </div>
            </div>
            <div class="action-bar">
              <button id="btncancel" type="button" class="btn-cancel-op">
                <i class="fas fa-times me-1"></i>Batal
              </button>
              <button id="btnsave" type="button" class="btn-save-op button-header-custom-save">
                <i class="fas fa-save me-1"></i>Simpan Opname
              </button>
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


  let hpp_diferent = new AutoNumeric('#hpp_diferent', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let hpp = new AutoNumeric('#hpp', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let total_opname = new AutoNumeric('#total_opname', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  $(document).ready(function() {
    check_tempt_data();
    temp_opname();
  });

  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Opname/search_product_opname?id='+$('#warehouse').val(),
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
      let stock = ui.item.stock;
      let hpp_val = ui.item.product_hpp;
      $("#product_id").val(id);
      $('#system_stock').val(stock);
      hpp.set(hpp_val);
    },
  });


  $('#fisik_stock').on('input', function (event) {
    let system_stock_val    = $("#system_stock").val();
    let fisik_stock_val     = $("#fisik_stock").val();
    let hpp_val_cal         = parseInt(hpp.get());
    let stock_diferent_val  = Number(fisik_stock_val) - Number(system_stock_val);
    $("#stock_diferent").val(stock_diferent_val);
    hpp_diferent.set(hpp_val_cal * Number(stock_diferent_val));
  })

  function temp_opname(){
    $('#temp-opname').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Opname/temp_opname',
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
    check_tempt_data();
  }


  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var warehouse               = $("#warehouse").val();
    var product_id              = $("#product_id").val();
    var system_stock            = $("#system_stock").val();
    var fisik_stock             = $("#fisik_stock").val();
    var stock_diferent          = $("#stock_diferent").val();
    var hpp_submit              = parseInt(hpp.get());
    var hpp_diferent_submit     = parseInt(hpp_diferent.get());
    var temp_note               = $("#temp_note").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Opname/add_temp_opname",
      dataType: "json",
      data: {warehouse:warehouse, product_id:product_id, system_stock:system_stock, fisik_stock:fisik_stock, stock_diferent:stock_diferent, hpp_submit:hpp_submit, hpp_diferent_submit:hpp_diferent_submit, temp_note:temp_note},
      success : function(data){
        if (data.code == "200"){
          let title = 'Tambah Data';
          let message = 'Data Berhasil Di Tambah';
          let state = 'info';
          notif_success(title, message, state);
          $('#temp-opname').DataTable().ajax.reload();
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
  });

  function clear_input()
  {
    $("#product_name").val("");
    $("#product_id").val("");
    $("#system_stock").val(0);
    $("#fisik_stock").val(0);
    $("#stock_diferent").val(0);
    hpp.set(0);
    hpp_diferent.set(0);
    $("#temp_note").val("");
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
          url: "<?php echo base_url(); ?>Opname/delete_temp_opname",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              let title = 'Hapus Data';
              let message = 'Data Berhasil Di Hapus';
              let state = 'danger';
              notif_success(title, message, state);
              $('#temp-opname').DataTable().ajax.reload();
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
    })
  }

  function edit_temp(id, sales_id)
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Opname/get_edit_temp_opname",
      dataType: "json",
      data: {id:id, sales_id:sales_id},
      success : function(data){
        if (data.code == "200"){
          let row = data.result[0];
          $("#product_name").val(row.product_name);
          $("#product_id").val(row.temp_opname_product_id);
          $("#system_stock").val(row.temp_opname_system_stock);
          $("#fisik_stock").val(row.temp_opname_fisik_stock);
          $("#stock_diferent").val(row.temp_opname_diferent_stock);
          hpp.set(row.product_hpp);;
          hpp_diferent.set(row.temp_opname_diferent_hpp);
          $("#temp_note").val(row.temp_opname_note);
        }
      }
    });
  }

  function check_tempt_data()
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Opname/check_temp_opname",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
          console.log(data.data);
          if(data.data.length > 0){
            let row = data.data[0];
            $("#warehouse").val(row.temp_opname_warehouse_id);
            $('#warehouse').trigger('change');            
            total_opname.set(row.total_diff);
          }else{
            $("#warehouse").val("");
            $('#warehouse').trigger('change');
            total_opname.set(0);
          }
        }
      }
    });
  }

  $('#btnsave').click(function(e){
    e.preventDefault();
    var warehouse               = $("#warehouse").val();
    var opname_date             = $("#opname_date").val();
    var total_opname_val        = parseInt(total_opname.get());
    var opname_remark           = $("#opname_remark").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Opname/save_opname",
      dataType: "json",
      data: {warehouse:warehouse, opname_date:opname_date, total_opname:total_opname_val, opname_remark:opname_remark},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Opname";
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
