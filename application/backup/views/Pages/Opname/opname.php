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
                <h3 class="fw-bold mb-3">Opname Stok</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="btnreload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <?php if($check_auth[0]->add == 'N'){ ?>
                  <a href="<?php echo base_url(); ?>Opname/addopname"><button class="btn btn-primary" disabled><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button></a>
                <?php }else{ ?>
                  <a href="<?php echo base_url(); ?>Opname/addopname"><button class="btn btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button></a>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content mt-3 mb-3" id="line-tabContent">
              <div class="tab-pane fade active show" id="line-hutang" role="tabpanel" aria-labelledby="line-home-tab">
                <div class="table-responsive">
                  <table id="debt-list" class="display table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Kode Opname</th>
                        <th>Gudang</th>
                        <th>Tanggal</th>
                        <th>Total</th>
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
        url: '<?php echo base_url(); ?>Opname/opname_list',
        type: 'POST',
        data:  {},
      },
      columns: 
      [
        {data: 0},
        {data: 1},
        {data: 2},
        {data: 3},
        {data: 4}
      ]
    });
  }


  function payment(id) {
    window.location.href = "<?php echo base_url(); ?>Payment/copy_debt_to_temp?id="+id;
  }



  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });



  
</script>