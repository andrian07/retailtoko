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
                <h3 class="fw-bold mb-3">Daftar Gudang</h3>
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
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Gudang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Kode Gudang</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="warehouse_code" placeholder="Kode Gudang">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Gudang</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="warehouse_name" placeholder="Nama Gudang">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Alamat</label>
                          <div class="col-md-12 p-0">
                            <textarea class="form-control" id="warehouse_address" rows="5"></textarea>
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

                <div class="modal fade" id="exampleModaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Gudang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Kode Gudang</label>
                          <div class="col-md-12 p-0">
                            <input type="hidden" class="form-control input-full" id="warehouse_id_edit">
                            <input type="text" class="form-control input-full" id="warehouse_code_edit" placeholder="Kode Gudang">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Gudang</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="warehouse_name_edit" placeholder="Nama Gudang">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Alamat</label>
                          <div class="col-md-12 p-0">
                            <textarea class="form-control" id="warehouse_address_edit" rows="5"></textarea>
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
                  <th>Kode Gudang</th>
                  <th>Nama Gudang</th>
                  <th>Alamat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data['warehouse_list'] as $row){ ?>
                  <tr>
                    <td><?php echo $row->warehouse_code; ?></td>
                    <td><?php echo $row->warehouse_name; ?></td>
                    <td><?php echo $row->warehouse_address; ?></td>
                    <td>
                      <?php if($data['check_auth'][0]->delete == 'N'){ ?>
                        <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn delete" data-id="<?php echo $row->warehouse_id; ?>" data-name="<?php echo $row->warehouse_name; ?>" disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button>
                      <?php }else{ ?>
                        <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn delete" data-id="<?php echo $row->warehouse_id; ?>" data-name="<?php echo $row->warehouse_name; ?>"><i class="fas fa-trash-alt sizing-fa"></i></button>
                      <?php } ?>
                      <?php if($data['check_auth'][0]->edit == 'N'){ ?>
                        <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->warehouse_id; ?>" data-code="<?php echo $row->warehouse_code; ?>" data-name="<?php echo $row->warehouse_name; ?>" data-address="<?php echo $row->warehouse_address; ?>"data-bs-toggle="modal" data-bs-target="#exampleModaledit" disabled="disabled"><i class="far fa-edit sizing-fa"></i></button>
                      <?php }else{ ?>
                       <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->warehouse_id; ?>" data-code="<?php echo $row->warehouse_code; ?>" data-name="<?php echo $row->warehouse_name; ?>" data-address="<?php echo $row->warehouse_address; ?>"data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="far fa-edit sizing-fa"></i></button>
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
          url: "<?php echo base_url(); ?>Masterdata/delete_warehouse",
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
    var warehouse_code        = $("#warehouse_code").val();
    var warehouse_name        = $("#warehouse_name").val();
    var warehouse_address     = $("#warehouse_address").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/save_warehouse",
      dataType: "json",
      data: {warehouse_code:warehouse_code, warehouse_name:warehouse_name, warehouse_address:warehouse_address},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/warehouse";
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
    var warehouse_id          = $("#warehouse_id_edit").val();
    var warehouse_code        = $("#warehouse_code_edit").val();
    var warehouse_name        = $("#warehouse_name_edit").val();
    var warehouse_address     = $("#warehouse_address_edit").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/edit_warehouse",
      dataType: "json",
      data: {warehouse_id:warehouse_id, warehouse_code:warehouse_code, warehouse_name:warehouse_name, warehouse_address:warehouse_address},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/warehouse";
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
    var button = $(event.relatedTarget) // Button that triggered the modal
    var warehouse_id        = button.data('id')
    var warehouse_code      = button.data('code')
    var warehouse_name      = button.data('name')
    var warehouse_address   = button.data('address')
    var modal = $(this)
    modal.find('.modal-title').text('Edit ' + warehouse_name)
    modal.find('#warehouse_id_edit').val(warehouse_id)
    modal.find('#warehouse_code_edit').val(warehouse_code)
    modal.find('#warehouse_name_edit').val(warehouse_name)
    modal.find('#warehouse_address_edit').val(warehouse_address)
  })

  $('#reload').click(function(e){
    e.preventDefault();
    location.reload();
  });

</script>