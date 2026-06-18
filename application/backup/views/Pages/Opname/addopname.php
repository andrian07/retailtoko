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
      <h3 class="fw-bold mb-3">Tambah Opname </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Opname :</label>
              <div class="col-sm-3">
                <input id="opname_invoice" name="opname_invoice" type="text" class="form-control" value="AUTO" readonly="">
              </div>
              <div class="col-md-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>
              <div class="col-sm-3">
                <input id="opname_date" name="opname_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Gudang:</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="warehouse" name="warehouse">
                  <option value="">-- Pilih Gudang --</option>
                  <?php foreach ($warehouse_list as $row) { ?>
                    <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
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

                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Produk</label>
                    <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan Nama Produk" value="" required="" autocomplete="off">
                    <input id="product_id" type="hidden" name="product_id">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Stok System</label>
                    <input id="system_stock" name="system_stock" type="text" class="form-control text-right" value="0" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Stok Fisik</label>
                    <input id="fisik_stock" name="fisik_stock" type="text" class="form-control text-right" value="0" required="">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Selisih Stok</label>
                    <input id="stock_diferent" name="stock_diferent" type="text" class="form-control text-right" value="0" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Selisih HPP</label>
                    <input id="hpp" name="hpp" type="hidden" class="form-control text-right" value="0" readonly>
                    <input id="hpp_diferent" name="hpp_diferent" type="text" class="form-control text-right" value="0" readonly>
                  </div>
                </div>

                <div class="col-sm-3"></div>

                <div class="col-sm-8">
                  <div class="form-group">
                    <label>Catatan</label>
                    <input id="temp_note" name="temp_note" type="text" class="form-control text-right">
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
              <table id="temp-opname" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>Produk</th>
                    <th>SKU</th>
                    <th>Stok Sistem</th>
                    <th>Stok Fisik</th>
                    <th>Selisih</th>
                    <th>Selisih Rupiah</th>
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
                    <textarea id="opname_remark" name="opname_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="8"></textarea>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 text-right">
                <div class="form-group row">
                  <label for="total_opname" class="col-sm-7 col-form-label text-right:">Total :</label>
                  <div class="col-sm-5">
                    <input id="total_opname" name="total_opname" type="text" class="form-control text-right" value="0" readonly="">
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