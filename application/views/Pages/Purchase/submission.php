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
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-left">
              
              <div>
                <h3 class="fw-bold mb-3">Daftar Pengajuan</h3>
              </div>
              

              <div class="ms-md-auto py-2 py-md-0">

                <button class="btn btn-info" id="reload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg" data-backdrop="static" data-keyboard="false"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>

                <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6 border-right border-primary">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">No Invoice</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="submission_invoice" value="Auto">
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Tanggal</label>
                              <div class="col-md-12 p-0">
                                <input type="date" class="form-control input-full" id="submission_date" value="<?php echo date("Y-m-d"); ?>" readonly>
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Gudang</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="submission_warehouse" name="submission_warehouse">
                                  <option>-- Pilih Gudang --</option>
                                  <?php foreach ($data['warehouse_list'] as $row) { ?>
                                    <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Sales</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="submission_salesman" name="submission_salesman">
                                  <option>-- Pilih Sales --</option>
                                  <?php foreach ($data['salesman_list'] as $row) { ?>
                                    <option value="<?php echo $row->salesman_id; ?>"><?php echo $row->salesman_name; ?></option>  
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Keterangan</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="submission_text" rows="5"></textarea>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Status</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="submission_desc" name="submission_desc">
                                  <option>-- Pilih Status --</option>
                                  <option value="Urgent">Urgent</option>
                                  <option value="New">New</option> 
                                  <option value="Restock">Restock</option> 
                                </select>
                              </div>
                            </div>



                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kode Produk</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="submission_product_code" readonly>
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Produk</label>
                              <div class="col-md-12 p-0">
                                <input type="hidden" id="submission_product_id" name="submission_product_id" class="form-control text-right" required="">
                                <input type="hidden" id="submission_last_supplier" name="submission_last_supplier" class="form-control text-right">
                                <input id="submission_product_name" name="submission_product_name" type="text" class="form-control input-full ui-autocomplete-input" placeholder="ketikkan nama produk">
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Qty</label>
                              <div class="col-md-12 p-0">
                                <input type="number" class="form-control input-full" id="submission_qty">
                              </div>
                            </div>
                          </div>
                        </div>   
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" id="btnsave" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal fade bd-example-modal-lg editmodal" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModaleditLabel" >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title-edit" id="exampleModalLabel">Edit Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6 border-right border-primary">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">No Invoice</label>
                              <div class="col-md-12 p-0">
                                <input type="hidden" class="form-control input-full" id="submission_id_edit" readonly>
                                <input type="text" class="form-control input-full" id="submission_invoice_edit" readonly>
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Tanggal</label>
                              <div class="col-md-12 p-0">
                                <input type="date" class="form-control input-full" id="submission_date_edit" value="<?php echo date("Y-m-d"); ?>" readonly>
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Gudang</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="submission_warehouse_edit" name="submission_warehouse_edit">
                                  <option>-- Pilih Gudang --</option>
                                  <?php foreach ($data['warehouse_list'] as $row) { ?>
                                    <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Sales</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="submission_salesman_edit" name="submission_salesman_edit">
                                  <option>-- Pilih Sales --</option>
                                  <?php foreach ($data['salesman_list'] as $row) { ?>
                                    <option value="<?php echo $row->salesman_id; ?>"><?php echo $row->salesman_name; ?></option>  
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Keterangan</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="submission_text_edit" rows="5"></textarea>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Status</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="submission_desc_edit" name="submission_desc_edit">
                                  <option>-- Pilih Status --</option>
                                  <option value="Urgent">Urgent</option>
                                  <option value="New">New</option> 
                                  <option value="Restock">Restock</option> 
                                  <option value="Stock On Hand">Stock On Hand</option>
                                  <option value="Current Stock">Current Stock</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kode Produk</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="submission_product_code_edit" readonly>
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Produk</label>
                              <div class="col-md-12 p-0">
                                <input type="hidden" id="submission_product_id_edit" name="submission_product_id_edit" class="form-control text-right" required="">
                                <input type="hidden" id="submission_last_supplier_edit" name="submission_last_supplier_edit" class="form-control text-right">
                                <input id="submission_product_name_edit" name="submission_product_name_edit" type="text" class="form-control input-full ui-autocomplete-input" placeholder="ketikkan nama produk">
                              </div>
                            </div>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Qty</label>
                              <div class="col-md-12 p-0">
                                <input type="number" class="form-control input-full" id="submission_qty_edit">
                              </div>
                            </div>
                          </div>
                        </div>   
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" id="btnedit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>

                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModalsearch" type="button">
                  <span class="btn-label"><i class="fas fa-search"></i></span> Filter
                </button>
                <div class="modal fade filter" id="myModalsearch" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Filter PO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Dari: </label>
                          <div class="col-md-12 p-0">
                            <?php $start_date = $_GET["start_date"] ?? ''; ?>
                            <input id="start_date" name="start_date" type="date" class="form-control" value="<?php echo $start_date; ?>">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Sampai: </label>
                          <div class="col-md-12 p-0">
                            <?php $end_date = $_GET["end_date"] ?? ''; ?>
                            <input id="end_date" name="end_date" type="date" class="form-control" value="<?php echo $end_date; ?>">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Supplier: </label>
                          <div class="col-md-12 p-0">
                            <select class="form-control input-full js-example-basic-single" id="supplier_filter" name="supplier_filter">
                              <option value="">-- Pilih Supplier --</option>
                              <?php foreach ($data['supplier_list'] as $row) { ?>
                                <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>  
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Keterangan: </label>
                          <div class="col-md-12 p-0">
                            <select class="form-control input-full" id="keterangan_filter" name="keterangan_filter">
                              <option value="">-- Pilih Keterangan --</option>
                              <option value="New">New</option>
                              <option value="Urgent">Urgent</option>
                              <option value="Restock">Restock</option>
                            </select>
                          </div>
                        </div>

                         <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Status: </label>
                          <div class="col-md-12 p-0">
                            <select class="form-control input-full" id="status_filter" name="status_filter">
                              <option value="">-- Pilih Status --</option>
                              <option value="Pending">Pending</option>
                              <option value="Success">Success</option>
                              <option value="Cancel">Cancel</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" id="btnsearch" class="btn btn-warning"><i class="fas fa-search"></i> Cari</button>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
              id="submission-list"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th>No Pengajuan</th>
                  <th>Tgl. Pengajuan</th>
                  <th>Diajukan</th>
                  <th>Nama Produk</th>
                  <th>Qty</th>
                  <th>Supplier Terakhir</th>
                  <th>Stock On Hand</th>
                  <th>Keterangan</th>
                  <th>Status</th>
                  <th>Catatan Admin</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
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

  new bootstrap.Modal(document.getElementById('myModal'), {backdrop: 'static', keyboard: false})  
  new bootstrap.Modal(document.getElementById('exampleModaledit'), {backdrop: 'static', keyboard: false})  
  $(document ).ready(function() {
    submission_table();
  });

  $('#btnsearch').click(function(){
    $('#submission-list').DataTable().ajax.reload();
      var modal = bootstrap.Modal.getInstance(document.getElementById('myModalsearch'));
      modal.hide();
  });

  function submission_table(){
    $('#submission-list').DataTable({
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Purchase/submission_list',
        type: 'POST',
        data: function(d){
          d.start_date        = $('#start_date').val();
          d.end_date          = $('#end_date').val();
          d.supplier_filter   = $('#supplier_filter').val();
          d.keterangan_filter = $('#keterangan_filter').val();
          d.status_filter     = $('#status_filter').val();
        }
      },
      columns: [
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
        {data: 10}
      ]
    });
  }

  function deletes(id)
  {
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus Data Pengajuan ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Purchase/delete_submission",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              //$('#myModal').modal('hide')
              $('#submission-list').DataTable().ajax.reload();
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

  function edit(id)
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/get_edit_temp_po",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          $('#myModal').modal('hide')
          $('#submission-list').DataTable().ajax.reload();
          let title = 'Tambah Data';
          let message = 'Data Berhasil Di Tambah';
          let state = 'info';
          notif_success(title, message, state);
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


  $('#submission_product_name').autocomplete({
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Purchase/search_product_submission',

        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
          }else{
            $('#submission_product_name').val('');
          }
        },
      });
    },
    select: function(event, ui) {
      let product_id = ui.item.id;
      $('#submission_product_id').val(product_id);
      $('#submission_product_code').val(ui.item.product_code);
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/get_last_supplier_po",
        dataType: "json",
        data: {product_id:product_id},
        success: function(data) {
          if (data.code == 200) {
            if(data.result.length >= 1){
              $('#submission_last_supplier').val(data.result[0].hd_po_supplier);
            }else{
              $('#submission_last_supplier').val('');
            }
          }else{
            $('#submission_product_name_edit').val('');
          }
        },
      });
    },
  });

  $('#submission_product_name_edit').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Purchase/search_product_submission',
        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
          }else{
            $('#submission_product_name_edit').val('');
          }
        },
      });
    },
    select: function(event, ui) {
      $('#submission_product_id_edit').val(ui.item.id);
      $('#submission_product_code_edit').val(ui.item.product_code);
      if(ui.item.last_supplier != null){
        $('#submission_last_supplier_edit').val(ui.item.last_supplier);
      }else{
        $('#submission_last_supplier_edit').val('');
      }
    },
  });

  


    
$('#btnsave').click(function(e){
    e.preventDefault();

    var submission_date           = $("#submission_date").val();
    var submission_warehouse      = $("#submission_warehouse").val();
    var submission_warehouse_name = $("#submission_warehouse option:selected").text();
    var submission_salesman       = $("#submission_salesman").val();
    var submission_desc           = $("#submission_desc").val();
    var submission_text           = $("#submission_text").val();
    var submission_product_id     = $("#submission_product_id").val();
    var submission_product_code   = $("#submission_product_code").val();
    var submission_qty            = $("#submission_qty").val();
    var submission_last_supplier  = $("#submission_last_supplier").val();

    // Validasi sederhana
    if(submission_product_id == ''){
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Produk harus dipilih'
        });
        return;
    }

    if(submission_qty == '' || submission_qty <= 0){
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Qty harus diisi dengan benar'
        });
        return;
    }

    function saveSubmission() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Purchase/save_submission",
            dataType: "json",
            data: {
                submission_date: submission_date,
                submission_warehouse: submission_warehouse,
                submission_warehouse_name: submission_warehouse_name,
                submission_salesman: submission_salesman,
                submission_desc: submission_desc,
                submission_text: submission_text,
                submission_product_id: submission_product_id,
                submission_product_code: submission_product_code,
                submission_qty: submission_qty,
                submission_last_supplier: submission_last_supplier
            },
            success: function(data){
                if (data.code == "200"){
                    $('#myModal').modal('hide');
                    $('#submission-list').DataTable().ajax.reload();

                    notif_success(
                        'Tambah Data',
                        'Data Berhasil Ditambah',
                        'info'
                    );

                    clear_input();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.result
                    });
                }
            },
            error: function(xhr, status, error){
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: error
                });
            }
        });
    }

    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/check_submission",
        dataType: "json",
        data: {
            submission_product_id: submission_product_id,
            submission_warehouse: submission_warehouse
        },
        success: function(data){

            if(data.code == "200"){

                if(data.result == "1"){

                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Terdapat Pengajuan Dengan Produk Yang Sama Di Gudang Yang Sama. Apakah Anda Ingin Melanjutkan?',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Lanjutkan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if(result.isConfirmed){
                            saveSubmission();
                        }else{
                            Swal.fire({
                                icon: 'info',
                                title: 'Dibatalkan',
                                text: 'Pengajuan Batal Disimpan'
                            });
                            clear_input();
                            $('#myModal').modal('hide');
                        }

                    });

                } else {
                    saveSubmission();
                }

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.result
                });

            }

        },
        error: function(xhr, status, error){
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: error
            });
        }
    });

});

  $('#btnedit').click(function(e){
    e.preventDefault();
    var submission_id             = $("#submission_id_edit").val();
    var submission_inv            = $("#submission_invoice_edit").val();
    var submission_date           = $("#submission_date_edit").val();
    var submission_warehouse      = $("#submission_warehouse_edit").val();
    var submission_warehouse_name = $("#submission_warehouse_edit option:selected").text();
    var submission_salesman       = $("#submission_salesman_edit").val();
    var submission_desc           = $("#submission_desc_edit").val();
    var submission_text           = $("#submission_text_edit").val();
    var submission_product_id     = $("#submission_product_id_edit").val();
    var submission_product_code   = $("#submission_product_code_edit").val();
    var submission_qty            = $("#submission_qty_edit").val();
    var submission_last_supplier  = $("#submission_last_supplier_edit").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/edit_submission",
      dataType: "json",
      data: {submission_id:submission_id, submission_inv:submission_inv, submission_date:submission_date, submission_warehouse:submission_warehouse, submission_warehouse_name:submission_warehouse_name, submission_salesman:submission_salesman, submission_desc:submission_desc, submission_text:submission_text, submission_product_id:submission_product_id, submission_product_code:submission_product_code, submission_qty:submission_qty, submission_last_supplier:submission_last_supplier},
      success : function(data){
        if (data.code == "200"){
         $('#exampleModaledit').modal('hide')
         $('#submission-list').DataTable().ajax.reload();
         let title = 'Ubah Data';
         let message = 'Data Berhasil Di Ubah';
         let state = 'info';
         notif_success(title, message, state);
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

  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id     = button.data('id');
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/submission_by_id",
      dataType: "json",
      data: {id:id},
      success : function(data){
        var row = data.result[0];
        var modal = $(this)
        if (data.code == "200"){
          modal.find('.modal-title-edit').text('Edit ' + row.submission_invoice)
          $('#submission_id_edit').val(row.submission_id);
          $('#submission_invoice_edit').val(row.submission_invoice);
          $('#submission_date_edit').val(row.submission_date);
          $('#submission_warehouse_edit').val(row.submission_warehouse);
          $('#submission_salesman_edit').val(row.submission_salesman);
          $('#submission_text_edit').val(row.submission_text);
          $('#submission_desc_edit').val(row.submission_desc);
          $('#submission_product_code_edit').val(row.submission_product_code);
          $('#submission_product_id_edit').val(row.product_id);
          $('#submission_product_name_edit').val(row.product_name);
          $('#submission_qty_edit').val(row.submission_qty);
          $('#submission_last_supplier_edit').val(row.submission_last_supplier);
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.result,
          })
        }
      }
    })
  })

  function clear_input()
  {
    $('#submission_warehouse').val('');
    $('#submission_salesman').val('');
    $('#submission_text').val('');
    $('#submission_desc').val('');
    $('#submission_product_code').val('');
    $('#submission_product_id').val('');
    $('#submission_product_name').val('');
    $('#submission_qty').val('');
  }

</script>