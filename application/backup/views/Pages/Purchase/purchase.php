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
                <h3 class="fw-bold mb-3">Daftar Pembelian</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="reload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <a href="<?php echo base_url(); ?>Purchase/addpurchase"><button class="btn btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button></a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
              id="purchase-list"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th>No Pembelian</th>
                  <th>Supplier</th>
                  <th>Tanggal</th>
                  <th>Barang</th>
                  <th>Satuan</th>
                  <th>Qty</th>
                  <th>Harga</th>
                  <th>Total</th>
                  <th>Golongan</th>
                  <th>Payment Status</th>
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

  var start_date_val      = $("#start_date").val();
  var end_date_val        = $("#end_date").val();
  var supplier_filter_val = $("#supplier_filter").val();


  function purchaseorder_table(){
    $('#purchase-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Purchase/purchase_list',
        type: 'POST',
        data:  {start_date_val:start_date_val, end_date_val:end_date_val, supplier_filter_val:supplier_filter_val, purchase_type:"PURCHASE"},
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
        {data: 10}
      ]
    });
  }

  function deletese(id)
  {
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus Data Pembelian ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Purchase/delete_purchase",
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

  $("#btnsearch").click(function (e) {
    var start_date      = $("#start_date").val();
    var end_date        = $("#end_date").val();
    var supplier_filter = $("#supplier_filter").val();
    window.location.href = "<?php echo base_url(); ?>Purchase/po?start_date="+start_date+"&end_date="+end_date+"&supplier_filter="+supplier_filter;
    Swal.fire('Saved!', '', 'success');
  });

  
</script>