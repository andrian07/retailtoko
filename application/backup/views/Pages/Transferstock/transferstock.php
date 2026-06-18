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
                <h3 class="fw-bold mb-3">Daftar Transfer Stock</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="btnreload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <?php if($check_auth[0]->add == 'N'){ ?>
                  <a href="<?php echo base_url(); ?>Transferstock/addtransferstock"><button class="btn btn-primary" disabled><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button></a>
                <?php }else{ ?>
                  <a href="<?php echo base_url(); ?>Transferstock/addtransferstock"><button class="btn btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button></a>
                <?php } ?>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="transferstock-list" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>No Transfer</th>
                    <th>Inisial</th>
                    <th>Nama Produk</th>
                    <th>Tanggal</th>
                    <th>Satuan</th>
                    <th>Qty</th>
                    <th>Dari</th>
                    <th>Ke</th>
                    <th>Stok Akhir Dari</th>
                    <th>Stok Akhir Ke</th>
                    <th>Catatan</th>
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
    transferlist_table();
  });

  function transferlist_table(){
    $('#transferstock-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Transferstock/transfer_stock_list',
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
        {data: 9},
        {data: 10}
      ]
    });
  }

  function dispatch(id)
  {
    let url = '<?php echo base_url(); ?>Transferstock/printdispatch?';
    url += 'transfer_id=' + id;
     window.open(url, '_blank');
  }

  function deletes(id)
  {
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus Data Transfer Stock ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Transferstock/delete_transfer_stock",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              $('#transferstock-list').DataTable().ajax.reload();
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
  
</script>