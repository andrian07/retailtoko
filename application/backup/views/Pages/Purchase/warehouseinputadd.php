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
      <h3 class="fw-bold mb-3">Input Stock </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>
              <div class="col-sm-3">
                <input id="hd_input_stock_invoice" name="hd_input_stock_invoice" type="text" class="form-control" value="AUTO" readonly="">
              </div>
              <div class="col-sm-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>
              <div class="col-sm-3">
                <input id="warehouseinput_date" name="warehouseinput_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly="">
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">No PO:</label>
              <div class="col-sm-3">
                <input id="po_inv" name="po_inv" type="text" class="form-control ui-autocomplete-input" placeholder="Pilih PO">
                <input id="po_inv_id" name="po_inv_id" type="hidden">
              </div>
              <div class="col-sm-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Gudang :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="warehouse" name="warehouse">
                  <option value="">-- Pilih Gudang --</option>
                  <?php foreach ($data['warehouse_list'] as $row) { ?>
                    <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Supplier :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="supplier" name="supplier">
                  <option value="">-- Pilih Supplier --</option>
                  <?php foreach ($data['supplier_list'] as $row) { ?>
                    <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
              <div class="col-sm-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">User :</label>
              <div class="col-sm-3">
                <input id="po_user_id" name="po_user_id" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Ekspedisi :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="ekspedisi" name="ekspedisi">
                  <option value="">-- Pilih Ekspedisi --</option>
                  <?php foreach ($data['ekspedisi_list'] as $row) { ?>
                    <option value="<?php echo $row->ekspedisi_id; ?>"><?php echo $row->ekspedisi_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
              <div class="col-sm-4"></div>
            </div>



          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form id="formaddtemp">
              <div class="row well well-sm input-temp">
                <input id="item_id" name="item_id" type="hidden" value="">

                <div class="col-sm-3">
                  <div class="form-group">
                    <label>SKU</label>
                    <input id="product_code" name="product_code" type="text" class="form-control" required="" readonly>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Produk</label>
                    <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan nama produk" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk"required="" readonly>
                    <input id="product_id" type="hidden" name="product_id">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Qty Beli</label>
                    <input id="temp_qty_po" name="temp_qty_po" type="text" class="form-control text-right" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Qty Terima</label>
                    <input id="temp_qty_recive" name="temp_qty_recive" type="text" class="form-control text-right" value="0" required="">
                  </div>
                </div>

                <div class="col-sm-5">
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Catatan</label>
                    <input id="input_stock_detail_remark" name="input_stock_detail_remark" type="text" class="form-control">
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
              <table id="temp-input-stock-table" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>SKU</th>
                    <th>produk</th>
                    <th>Satuan</th>
                    <th>Qty Beli</th>
                    <th>Qty Terima</th>
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
                    <textarea id="input_stock_remark" name="input_stock_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="8"></textarea>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 text-right">
                <div class="form-group row">
                  <label for="footer_sub_total" class="col-sm-7 col-form-label text-right:">Total Qty Terima:</label>
                  <div class="col-sm-5">
                    <input id="total_qty_item" name="total_qty_item" type="text" class="form-control text-right" value="0" readonly="">
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



  $(document).ready(function() {
    temp_input_stock_table();
    $('#supplier').prop('disabled', true);
    $('#warehouse').prop('disabled', true);
    $('#ekspedisi').prop('disabled', true);
  });

  function temp_input_stock_table(){
    $('#temp-input-stock-table').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Purchase/temp_input_stock_list',
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
        url: '<?php echo base_url(); ?>/Purchase/search_po',
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
      var po_id = ui.item.id;
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/copy_po_to_temp",
        dataType: "json",
        data: {po_id:po_id},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Berhasil Pilih PO';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-input-stock-table').DataTable().ajax.reload();
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
					url: "<?php echo base_url(); ?>Purchase/clear_temp_input_stock",
					dataType: "json",
					data: {},
					success : function(data){
						if (data.code == "200"){
							window.location.href = "<?php echo base_url(); ?>/Purchase/warehouseinput";
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

  function check_tempt_data()
  {
    
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/check_temp_input_stock",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
          console.log(data);
          if(data.po_id == 0){
            $("#po_inv").val("");
            $("#po_inv_id").val("0");
            $("#supplier").select2("val", "");
            $("#warehouse").select2("val", "");
            $("#ekspedisi").select2("val", "");
            $("#total_qty_item").val("0");
            $('#po_inv').prop('disabled', false);
          }else{
            $("#po_inv").val(data.po_code);
            $("#po_inv_id").val(data.po_id);
            $("#supplier").val(data.supplier);
            $('#supplier').trigger('change');
            $('#warehouse').val(data.warehouse);
            $('#warehouse').trigger('change');
            $('#ekspedisi').val(data.ekspedisi);
            $('#ekspedisi').trigger('change');
            $("#total_qty_item").val(data.total_item);
            $('#po_inv').prop('disabled', true);
          }
        }
      }
    });
  }

  function edit_temp(id)
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/get_edit_temp_input_stock",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          var row = data.result[0];
          $("#product_code").val(row.product_code);
          $("#product_name").val(row.product_name);
          $("#product_id").val(row.temp_is_product_id);
          $("#temp_qty_po").val(row.temp_is_qty_order);
          $("#temp_qty_recive").val(row.temp_is_qty);
          $("#input_stock_detail_remark").val(row.temp_is_note);
        }
      }
    });  
  }



  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var product_id                = $("#product_id").val();
    var temp_qty_recive           = $("#temp_qty_recive").val();
    var temp_qty_po               = $("#temp_qty_po").val();
    var input_stock_detail_remark = $("#input_stock_detail_remark").val();
    if(temp_qty_recive > temp_qty_po){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Qty Terima Tidak Bisa Melebih Qty Pesan',
      })
    }else{
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/add_temp_input_stock",
        dataType: "json",
        data: {product_id:product_id, temp_qty_recive:temp_qty_recive, input_stock_detail_remark:input_stock_detail_remark},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Data Berhasil Di Edit';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-input-stock-table').DataTable().ajax.reload();
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
    }

  });

  $('#btnsave').click(function(e){
    e.preventDefault();
    var po_inv_id             = $("#po_inv_id").val();
    var warehouseinput_date   = $("#warehouseinput_date").val();
    var desc                  = $("#input_stock_remark").val();
    var warehouse             = $("#warehouse").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/save_input_stock",
      dataType: "json",
      data: {po_inv_id:po_inv_id, warehouseinput_date:warehouseinput_date, desc:desc, warehouse:warehouse},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Purchase/warehouseinput";
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
          url: "<?php echo base_url(); ?>Purchase/delete_temp_input_stock",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              let title = 'Hapus Data';
              let message = 'Data Berhasil Di Hapus';
              let state = 'danger';
              notif_success(title, message, state);
              $('#temp-input-stock-table').DataTable().ajax.reload();
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
      }
    })
  }



  
</script>