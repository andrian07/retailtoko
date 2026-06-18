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
                <h3 class="fw-bold mb-3">Daftar Retur Pembelian</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="reload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <a href="<?php echo base_url(); ?>Purchase/addreturpurchase"><button class="btn btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button></a>
              </div>
            </div>
          </div>

          <div class="modal fade bd-example-modal-md editmodal" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModaleditLabel" >
            <div class="modal-dialog modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Pembayaran Retur Pembelian</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12 border-right">
                      <div class="form-group form-inline">
                        <label for="inlineinput" class="col-md-3 col-form-label">Nomor Invoice</label>
                        <div class="col-md-12 p-0">
                          <input type="hidden" class="form-control input-full" id="retur_purchase_id" readonly>
                          <input type="text" class="form-control input-full" id="retur_purchase_invoice" readonly>
                        </div>
                      </div>

                      <div class="form-group form-inline">
                        <label for="inlineinput" class="col-md-3 col-form-label">Total Bayar</label>
                        <div class="col-md-12 p-0">
                          <input type="text" class="form-control input-full" id="retur_purchase_total" readonly>
                        </div>
                      </div>

                      <div class="form-group form-inline">
                        <label for="inlineinput" class="col-md-3 col-form-label">Jenis Bayar</label>
                        <div class="col-md-12 p-0">
                          <select class="form-select form-control" id="payment_type">
                            <option value="PN">Potong Nota</option>
                            <option value="Cash">Cash</option>
                            <option value="Garansi">Garansi</option>
                          </select>
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

          <div class="card-body">
            <div class="table-responsive">
              <table
              id="retur-purchase-list"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th>No Invoice</th>
                  <th>Tanggal</th>
                  <th>Barang</th>
                  <th>Qty Retur</th>
                  <th>Supplier</th>
                  <th>Total Transaksi</th>
                  <th>Status</th>
                  <th>Jenis Retur</th>
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

  new bootstrap.Modal(document.getElementById('exampleModaledit'), {backdrop: 'static', keyboard: false})  

  $(document).ready(function() {
    returpurchase_table();
  });

  let retur_purchase_total = new AutoNumeric('#retur_purchase_total', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  function returpurchase_table(){
    $('#retur-purchase-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Purchase/retur_purchase_list',
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
      {data: 8}
      ]
    });
  }

  function deletes(id)
  {
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus Data Retur Pembelian ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Purchase/delete_retur_purchase",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              $('#retur-purchase-list').DataTable().ajax.reload();
              let title = 'Hapus Data';
              let message = 'Data Berhasil Di Batalkan';
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

  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id')
    var inv   = button.data('inv')
    var total_retur = button.data('total')
    var modal = $(this)
    modal.find('#retur_purchase_id').val(id)
    modal.find('#retur_purchase_invoice').val(inv)
    retur_purchase_total.set(total_retur);
  })


  $('#btnedit').click(function(e){
    e.preventDefault();
    var retur_purchase_id         = $("#retur_purchase_id").val();
    var payment_type              = $("#payment_type").val();
    var retur_purchase_invoice    = $("#retur_purchase_invoice").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/edit_retur_purchase",
      dataType: "json",
      data: {retur_purchase_id:retur_purchase_id, payment_type:payment_type, retur_purchase_invoice:retur_purchase_invoice},
      success : function(data){
        if (data.code == "200"){
          let title = 'Perbarui Data';
          let message = 'Data Berhasil Di Perbarui';
          let state = 'success';
          notif_success(title, message, state);
          $('#retur-purchase-list').DataTable().ajax.reload();
          $('#exampleModaledit').modal('hide');
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