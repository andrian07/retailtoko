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
                <h3 class="fw-bold mb-3">Pelunasan Hutang</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="btnreload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <ul class="nav nav-tabs nav-line nav-color-secondary" id="line-tab" role="tablist">
              <li class="nav-item submenu" role="presentation">
                <a class="nav-link active" id="line-home-tab" data-bs-toggle="pill" href="#line-hutang" role="tab" aria-controls="pills-home" aria-selected="true">Daftar Hutang</a>
              </li>
              <li class="nav-item submenu" role="presentation">
                <a class="nav-link" id="line-profile-tab" data-bs-toggle="pill" href="#line-history" role="tab" aria-controls="pills-profile" aria-selected="false" tabindex="-1">History Pelunasan Hutang</a>
              </li>
            </ul>
            <div class="tab-content mt-3 mb-3" id="line-tabContent">
              <div class="tab-pane fade active show" id="line-hutang" role="tabpanel" aria-labelledby="line-home-tab">
                <div class="table-responsive">
                  <table id="debt-list" class="display table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
                        <th>No Telp</th>
                        <th>Jlh. Nota</th>
                        <th>Total Hutang</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="line-history" role="tabpanel" aria-labelledby="line-profile-tab">
               <div class="table-responsive">
                <table id="history-debt-list" class="display table table-striped table-hover" style="width:100%;">
                  <thead>
                    <tr>
                      <th>No Transaksi</th>
                      <th>Nama Supplier</th>
                      <th>Tgl Pembayaran</th>
                      <th>Metode Pembayaran</th>
                      <th>Jlh. Nota</th>
                      <th>Total Bayar</th>
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
</div>
</div>
</div>


<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script>

  $(document).ready(function() {
    //new bootstrap.Modal(document.getElementById('exampleModaledit'), {backdrop: 'static', keyboard: false}) ;
    debtlist();
    historydebtlist();
  });


  function debtlist(){
    $('#debt-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Payment/debt_list',
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
  }

  function historydebtlist(){
    $('#history-debt-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Payment/history_debt_list',
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
      ]
    });
  }



  $(".delete").click(function (e) {
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus '"+name+"' ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Masterdata/delete_brand",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              location.reload();
              Swal.fire('Saved!', '', 'success'); 
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
  });

  $('#btnsave').click(function(e){
    e.preventDefault();
    var brand_name  = $("#brand_name").val();
    var brand_desc  = $("#brand_desc").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/save_brand",
      dataType: "json",
      data: {brand_name:brand_name, brand_desc:brand_desc},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/brand";
          Swal.fire('Saved!', '', 'success');
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

  function payment(id) {
    window.location.href = "<?php echo base_url(); ?>Payment/copy_debt_to_temp?id="+id;
  }



  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });



  
</script>