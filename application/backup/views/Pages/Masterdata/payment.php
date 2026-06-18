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
                <h3 class="fw-bold mb-3">Daftar Pembayaran</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="reload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <?php if($data['check_auth'][0]->add == 'N'){ ?>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" disabled="disabled"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <?php }else{ ?>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <?php } ?>
                
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Pembayaran</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="payment_name" placeholder="Nama Pembayaran">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">No Rekening</label>
                          <div class="col-md-12 p-0">
                            <textarea class="form-control" id="payment_rek" rows="5" placeholder="No Rekening"></textarea>
                          </div>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" id="btnsave"  class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal fade" id="exampleModaledit" tabindex="-1" aria-labelledby="exampleModaleditLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Pambayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Pembayaran</label>
                          <div class="col-md-12 p-0">
                            <input type="hidden" class="form-control input-full" id="payment_id_edit" placeholder="Nama Pembayaran">
                            <input type="text" class="form-control input-full" id="payment_name_edit" placeholder="Nama Pembayaran">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">No Rekening</label>
                          <div class="col-md-12 p-0">
                            <textarea class="form-control" id="payment_rek_edit" rows="5" placeholder="No Rekening"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" id="btnedit"  class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
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
              id="basic-datatables"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th>Nama Pembayaran</th>
                  <th>No Rekening</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data['payment_list'] as $row){ ?>
                  <tr>
                    <td><?php echo $row->payment_name; ?></td>
                    <td><?php echo $row->payment_no_rek; ?></td>
                    <td>
                      <?php if($data['check_auth'][0]->edit == 'N'){ ?>
                        <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->payment_id; ?>" data-name="<?php echo $row->payment_name; ?>" data-rek="<?php echo $row->payment_no_rek; ?>" data-bs-toggle="modal" data-bs-target="#exampleModaledit" disabled="disabled"><i class="far fa-edit sizing-fa"></i></button>
                      <?php }else{ ?>
                       <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->payment_id; ?>" data-name="<?php echo $row->payment_name; ?>" data-rek="<?php echo $row->payment_no_rek; ?>" data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="far fa-edit sizing-fa"></i></button>
                     <?php } ?>
                   </td>
                 </tr>
               <?php } ?>
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


  new bootstrap.Modal(document.getElementById('exampleModal'), {backdrop: 'static', keyboard: false})  
  new bootstrap.Modal(document.getElementById('exampleModaledit'), {backdrop: 'static', keyboard: false})  
  
  $('#btnsave').click(function(e){
    e.preventDefault();
    var payment_name     = $("#payment_name").val();
    var payment_rek      = $("#payment_rek").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/save_payment",
      dataType: "json",
      data: {payment_name:payment_name, payment_rek:payment_rek},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/payment";
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

  $('#btnedit').click(function(e){
    e.preventDefault();
    var payment_id         = $("#payment_id_edit").val();
    var payment_name       = $("#payment_name_edit").val();
    var payment_rek        = $("#payment_rek_edit").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/edit_payment",
      dataType: "json",
      data: {payment_id:payment_id, payment_name:payment_name, payment_rek:payment_rek},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/payment";
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

  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button    = $(event.relatedTarget) // Button that triggered the modal
    var id        = button.data('id')
    var name      = button.data('name')
    var rek       = button.data('rek')
    var modal = $(this)
    modal.find('.modal-title').text('Edit ' + name)
    modal.find('#payment_id_edit').val(id)
    modal.find('#payment_name_edit').val(name)
    modal.find('#payment_rek_edit').val(rek)
  })

  $('#reload').click(function(e){
    e.preventDefault();
    location.reload();
  });
</script>