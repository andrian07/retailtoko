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
                <h3 class="fw-bold mb-3">Daftar PO</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="reload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                 <?php if($data['check_auth']['check_access'][0]->add == 'Y'){ ?>
                <a href="<?php echo base_url(); ?>Purchase/addpo"><button class="btn btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button></a>
                <?php }else{ ?>
                <button class="btn btn-primary" disabled><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button>
                <?php } ?>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="fas fa-search" ></i> Filter</button>
                <div class="modal fade editmodal" id="exampleModaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              <?php foreach ($supplier_list as $row) { ?>
                                <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>  
                              <?php } ?>
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

                   <div class="modal fade" id="print" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">PRINT</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                      <label for="inlineinput" class="col-md-8 col-form-label">Jenis Print: </label>
                      <div class="col-md-12 p-0">
                        <select class="form-control input-full" id="print_type" name="print_type">
                          <option value="">-- Pilih Jenis Print --</option>
                          <option value="1">Print 80mm (1Ply)</option> 
                          <option value="2">Print Half Letter (2Ply)</option>
                        </select>

                        <input type="hidden" id="purchase_id" name="purchase_id" value="">
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                      <button type="button" id="btnprint" class="btn btn-primary"><i class="fas fa-search"></i> Print</button>
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
              id="po-list"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th>No PO</th>
                  <th>Tgl. PO</th>
                  <th>Nama Produk</th>
                  <th>Golongan</th>
                  <th>Supplier</th>
                  <th>Harga Satuan</th>
                  <th>Qty</th>
                  <th>Total Harga</th>
                  <th>Status Input Pembelian</th>
                  <th>Status Input Gudang</th>
                  <th>Status Pengiriman</th>
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

  var start_date_val      = $("#start_date").val();
  var end_date_val        = $("#end_date").val();
  var supplier_filter_val = $("#supplier_filter").val();

  function purchaseorder_table(){
    $('#po-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Purchase/po_list',
        type: 'POST',
        data:  {start_date_val:start_date_val, end_date_val:end_date_val, supplier_filter_val:supplier_filter_val},
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
        {data: 10},
        {data: 11}
      ]
    });
  }

  function deletes(id)
  {
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus Data PO ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Purchase/delete_po",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              $('#po-list').DataTable().ajax.reload();
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
    window.location.href = "<?php echo base_url(); ?>Purchase/editpo?id="+id;
  }

  $("#btnsearch").click(function (e) {
    var start_date      = $("#start_date").val();
    var end_date        = $("#end_date").val();
    var supplier_filter = $("#supplier_filter").val();
    window.location.href = "<?php echo base_url(); ?>Purchase/po?start_date="+start_date+"&end_date="+end_date+"&supplier_filter="+supplier_filter;
    Swal.fire('Saved!', '', 'success');
  });

  function note(id)
  {
    window.location.href = "<?php echo base_url(); ?>Purchase/printponote?id="+id;
  }

  $('#btnprint').on('click', function () {
    var print_type = $('#print_type').val();
    if(print_type != '') {
      let print_type       = $('#print_type').val();
      let purchase_id      = $('#purchase_id').val();
      let url = '';
      if(print_type == '1') {
         url = '<?php echo base_url(); ?>Purchase/printnotapo?purchase_id='+purchase_id;
      }else{
         url = '<?php echo base_url(); ?>Purchase/printponote?id='+purchase_id;
      }
      window.open(url, '_blank');
    }else{
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Silakan pilih Jenis Print terlebih dahulu',
      })
    }
  });

  $('#print').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id')
    var modal = $(this)
    modal.find('#purchase_id').val(id)
  })
  
</script>