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
                <h3 class="fw-bold mb-3">Daftar Revisi Penjualan</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="reload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <a href="<?php echo base_url(); ?>Sales/addrevisisales"><button class="btn btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button></a>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="fas fa-search" ></i> Filter</button>
                <div class="modal fade editmodal" id="exampleModaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Filter Sales</h5>
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


                        <label for="inlineinput" class="col-md-3 col-form-label">Customer: </label>
                        <div class="col-md-12 p-0">
                          <select class="form-control input-full js-example-basic-single" id="customer_filter" name="customer_filter">
                            <option value="">-- Pilih Customer --</option>
                            <?php foreach ($data['customer_list'] as $row) { ?>
                              <option value="<?php echo $row->customer_id; ?>"><?php echo $row->customer_name; ?></option>  
                            <?php } ?>
                          </select>
                        </div>

                        <label for="inlineinput" class="col-md-8 col-form-label">Status Pembayaran: </label>
                        <div class="col-md-12 p-0">
                          <select class="form-control input-full js-example-basic-single" id="payment_status_filter" name="payment_status_filter">
                            <option value="">-- Pilih Status Pembayaran --</option>
                            <option value="Lunas">Lunas</option> 
                            <option value="Belum Lunas">Belum Lunas</option>   
                          </select>
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
              id="sales-list"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th>No Invoice</th>
                  <th>Tanggal</th>
                  <th>Customer</th>
                  <th>Produk</th>
                  <th>Qty</th>
                  <th>Rate</th>
                  <th>Total Harga</th>
                  <th>Status Pembayaran</th>
                  <th>Sisa Pembayaran</th>
                  <th>Ekspedisi</th>
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
    purchaseorder_table();
  });


  function purchaseorder_table(){
    $('#sales-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Sales/sales_list',
        type: 'POST',
        data: function(d){
          d.start_date             = $('#start_date').val();
          d.end_date               = $('#end_date').val();
          d.customer_filter        = $('#customer_filter').val();
          d.status_payment_filter  = $('#payment_status_filter').val();
          d.cat                    = 'REVISI';
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
      text: "Apakah Anda Yakin Menghapus Data Penjualan ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Sales/delete_sales",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              $('#sales-list').DataTable().ajax.reload();
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

  $("#btnsearch").click(function (e) {
    var start_date      = $("#start_date").val();
    var end_date        = $("#end_date").val();
    var supplier_filter = $("#supplier_filter").val();
    window.location.href = "<?php echo base_url(); ?>Purchase/po?start_date="+start_date+"&end_date="+end_date+"&supplier_filter="+supplier_filter;
    Swal.fire('Saved!', '', 'success');
  });

  
</script>