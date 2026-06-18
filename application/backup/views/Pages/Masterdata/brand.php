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
                <h3 class="fw-bold mb-3">Daftar Brand</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="btnreload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <?php if($data['check_auth'][0]->add == 'N'){ ?>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" disabled="disabled" data-backdrop="static" data-keyboard="false"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <?php }else{ ?>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-backdrop="static" data-keyboard="false"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <?php } ?>

                <!-- Tambah Brand -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Brand</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="brand_name" placeholder="Nama Brand">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Deskripsi</label>
                          <div class="col-md-12 p-0">
                            <textarea class="form-control" id="brand_desc" rows="5"></textarea>
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
                <!-- End Tambah Brand -->

                <!-- Edit Brand -->
                <div class="modal fade" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModaleditLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModaledit">Edit Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Brand</label>
                          <div class="col-md-12 p-0">
                            <input type="hidden" class="form-control input-full" id="brand_id">
                            <input type="text" class="form-control input-full" id="brand_name_edit">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Deskripsi</label>
                          <div class="col-md-12 p-0">
                            <textarea class="form-control" id="brand_desc_edit" rows="5"></textarea>
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
                <!-- End Edit Brand -->

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
                  <th>Nama Brand</th>
                  <th>Deskripsi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data['brand_list'] as $row) { ?>
                  <tr>
                    <td><?php echo $row->brand_name; ?></td>
                    <td><?php echo $row->brand_desc; ?></td>
                    <td>
                      <?php if($data['check_auth'][0]->delete == 'N'){ ?>
                        <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn delete" data-id="<?php echo $row->brand_id; ?>" data-name="<?php echo $row->brand_name; ?>" disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button>
                      <?php }else{ ?>
                        <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn delete" data-id="<?php echo $row->brand_id; ?>" data-name="<?php echo $row->brand_name; ?>"><i class="fas fa-trash-alt sizing-fa"></i></button>
                      <?php } ?>
                      <?php if($data['check_auth'][0]->edit == 'N'){ ?>
                        <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->brand_id; ?>" data-name="<?php echo $row->brand_name; ?>" data-desc="<?php echo $row->brand_desc; ?>" data-bs-toggle="modal" data-bs-target="#exampleModaledit" disabled="disabled"><i class="far fa-edit sizing-fa"></i></button>
                      <?php }else{ ?>
                       <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->brand_id; ?>" data-name="<?php echo $row->brand_name; ?>" data-desc="<?php echo $row->brand_desc; ?>" data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="far fa-edit sizing-fa"></i></button>
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

  $('#btnedit').click(function(e){
    e.preventDefault();
    var brand_id    = $("#brand_id").val();
    var brand_name_edit  = $("#brand_name_edit").val();
    var brand_desc_edit  = $("#brand_desc_edit").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/edit_brand",
      dataType: "json",
      data: {brand_id:brand_id, brand_name_edit:brand_name_edit, brand_desc_edit:brand_desc_edit},
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

  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });

 


  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id')
    var brand_name_edit   = button.data('name')
    var brand_desc_edit   = button.data('desc')
    var modal = $(this)
    modal.find('.modal-title').text('Edit ' + brand_name_edit)
    modal.find('#brand_id').val(id)
    modal.find('#brand_name_edit').val(brand_name_edit)
    modal.find('#brand_desc_edit').val(brand_desc_edit)
  })

  
</script>