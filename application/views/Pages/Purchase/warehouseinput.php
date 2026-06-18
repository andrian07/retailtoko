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
                <h3 class="fw-bold mb-3">Daftar Input Stock</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="reload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <?php if($data['check_auth']['check_access'][0]->add == 'Y'){ ?>
                  <a href="<?php echo base_url(); ?>Purchase/addwarehouseinput"><button class="btn btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button></a>
                <?php }else{ ?>
                  <button class="btn btn-primary" disabled><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button>
                <?php } ?>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="fas fa-search" ></i> Filter</button>
                <div class="modal fade editmodal" id="exampleModaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Filter Input Gudang</h5>
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
                          <label for="inlineinput" class="col-md-3 col-form-label">Gudang: </label>
                          <div class="col-md-12 p-0">
                            <select class="form-control input-full js-example-basic-single" id="warehouse_filter" name="warehouse_filter">
                              <option value="">-- Pilih Gudang --</option>
                              <?php foreach ($data['warehouse_list'] as $row) { ?>
                                <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                              <?php } ?>
                            </select>
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

                      </div>
                      <div class="modal-footer">
                        <button id="btnreset" class="btn btn-danger"><i class="fas fa-times-circle"></i> Reset</button>
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
              id="warehouse-input-list"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th>No Input Stok</th>
                  <th>Tanggal</th>
                  <th>Nama Barang</th>
                  <th>Nama Supplier</th>
                  <th>Qty Pesan</th>
                  <th>Qty Terima</th>
                  <th>Catatan</th>
                  <th>Status</th>
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

  $(document).ready(function() {
    new bootstrap.Modal(document.getElementById('exampleModaledit'), {backdrop: 'static', keyboard: false}) ;
    purchaseorder_table();
  });


  function purchaseorder_table(){
    $('#warehouse-input-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Purchase/warehouseinput_list',
        type: 'POST',
         data: function(d){
          d.start_date        = $('#start_date').val();
          d.end_date          = $('#end_date').val();
          d.warehouse_filter   = $('#warehouse_filter').val();
          d.supplier_filter    = $('#supplier_filter').val();
        }
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
  }

  function deletes(id)
  {
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus Data Input ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Purchase/delete_warehouse_input",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              $('#warehouse-input-list').DataTable().ajax.reload();
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

  $('#btnreset').click(function(){
    $('#start_date').val('');
    $('#end_date').val('');
    $('#warehouse_filter').val('');
    $('#warehouse-input-list').DataTable().ajax.reload();
    $('#exampleModaledit').modal('hide');
  });

  $('#btnsearch').click(function(){
    $('#warehouse-input-list').DataTable().ajax.reload();
      var modal = bootstrap.Modal.getInstance(document.getElementById('myModalsearch'));
      $('#exampleModaledit').modal('hide');
  });
    
</script>