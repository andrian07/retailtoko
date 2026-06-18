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
      <h3 class="fw-bold mb-3">Tambah Transfer Stok</h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Kode Transfer :</label>
              <div class="col-sm-3">
                <input id="transfer_stock_code" name="transfer_stock_code" type="text" class="form-control" value="AUTO" readonly="">
              </div>
              <div class="col-md-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>
              <div class="col-sm-3">
                <input id="transfer_stock_date" name="transfer_stock_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Inisial :</label>
              <div class="col-sm-3">
                <input id="transfer_stock_inisial" name="transfer_stock_inisial" type="text" class="form-control">
              </div>
              <div class="col-md-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">User :</label>
              <div class="col-sm-3">
                <input id="transfer_stock_user" name="transfer_stock_user" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly>
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

                <div class="col-sm-5">
                  <div class="form-group">
                    <label>Produk</label>
                    <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan Nama Produk" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                    <input id="product_id" type="hidden" name="product_id">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Dari</label>
                    <select class="form-control input-full js-example-basic-single" id="transfer_from" name="transfer_from">
                      <option value="">-- Pilih Gudang --</option>
                      <?php foreach ($data['warehouse_list'] as $row) { ?>
                        <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Tujuan</label>
                    <select class="form-control input-full js-example-basic-single" id="transfer_to" name="transfer_to">
                      <option value="">-- Pilih Gudang --</option>
                      <?php foreach ($data['warehouse_list'] as $row) { ?>
                        <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Qty</label>
                    <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="">
                  </div>
                </div>

                <div class="col-sm-5"></div>

                <div class="col-sm-6">
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
              <table id="temp-transfer-stock-list" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>SKU</th>
                    <th>produk</th>
                    <th>Satuan</th>
                    <th>Qty</th>
                    <th>Dari</th>
                    <th>Ke</th>
                    <th>Stok Akhir dari</th>
                    <th>Stok Akhir ke</th>
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
                    <textarea id="transfer_stock_remark" name="transfer_stock_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="8"></textarea>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 text-right">
                <div class="form-group row">
                  <label for="footer_total" class="col-sm-7 col-form-label text-right:">Total Item:</label>
                  <div class="col-sm-5">
                    <input id="footer_total" name="footer_total" type="text" class="form-control text-right" value="0" readonly="">
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



  $(document).ready(function() {
    temp_retur_purchase_table();
  });

  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Transferstock/search_product',
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
      $("#product_id").val(id);
    },
  });

  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var product_id           = $("#product_id").val();
    var transfer_from        = $("#transfer_from").val();
    var transfer_to          = $("#transfer_to").val();
    var qty                  = $("#temp_qty").val();
    var temp_note            = $("#temp_note").val();

    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Transferstock/add_temp_transferstock",
        dataType: "json",
        data: {product_id:product_id, transfer_from:transfer_from, transfer_to:transfer_to, qty:qty, temp_note:temp_note},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Data Berhasil Di Tambah';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-transfer-stock-list').DataTable().ajax.reload();
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
      url: "<?php echo base_url(); ?>Transferstock/check_temp_transfer_stock",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
          let row = data.data[0];
          $('#footer_total').val(row.total);
        }
      }
    });
  }

  function clear_input()
  {
    $("#product_name").val("");
    $("#product_id").val("");
    $("#transfer_from").val("");
    $('#transfer_from').trigger('change');
    $("#transfer_to").val("");
    $('#transfer_to').trigger('change');
    $("#temp_note").val("");
    $('#temp_qty').val("0");
  }

  function edit_temp(product_id, user_id)
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Transferstock/get_edit_temp_transfer_stock",
      dataType: "json",
      data: {product_id:product_id, user_id:user_id},
      success : function(data){
        if (data.code == "200"){
          let row = data.result[0];
          $("#product_name").val(row.product_name);
          $("#product_id").val(row.temp_transfer_stock_product_id);
          $('#transfer_from').val(row.temp_transfer_stock_warehouse_from);
          $('#transfer_from').trigger('change');
          $('#transfer_to').val(row.temp_transfer_stock_warehouse_to);
          $('#transfer_to').trigger('change');
          $('#temp_qty').val(row.temp_transfer_stock_qty);
          $('#temp_note').val(row.temp_transfer_stock_note);
        }
      }
    });
  }

  function temp_retur_purchase_table(){
    $('#temp-transfer-stock-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Transferstock/temp_transfer_stock_list',
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
        {data: 9}
      ]
    });
    check_tempt_data();
  }

  function deletes(product_id, user_id)
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
          url: "<?php echo base_url(); ?>Transferstock/delete_temp_transfer_stock",
          dataType: "json",
          data: {product_id:product_id},
          success : function(data){
            if (data.code == "200"){
              let title = 'Hapus Data';
              let message = 'Data Berhasil Di Hapus';
              let state = 'danger';
              notif_success(title, message, state);
              check_tempt_data();
              $('#temp-transfer-stock-list').DataTable().ajax.reload();
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
    var footer_total                  = $("#footer_total").val();
    var transfer_stock_date           = $("#transfer_stock_date").val();
    var transfer_stock_remark         = $("#transfer_stock_remark").val();
    var transfer_stock_inisial        = $("#transfer_stock_inisial").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Transferstock/save_transfer_stock",
      dataType: "json",
      data: {footer_total:footer_total, transfer_stock_remark:transfer_stock_remark, transfer_stock_date:transfer_stock_date, transfer_stock_inisial:transfer_stock_inisial},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Transferstock";
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