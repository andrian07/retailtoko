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
                <h3 class="fw-bold mb-3">Daftar Akun Pengguna</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="reload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <?php if($data['check_auth'][0]->add == 'N'){ ?>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-md" disabled="disabled"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <?php }else{ ?>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-md"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <?php } ?>
                <!-- pop up add member -->
                <div class="modal fade bd-example-modal-md" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Akun Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Nama User</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" name="user_name" id="user_name" placeholder="Nama User">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Role</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="user_role" name="user_role">
                                  <option value="">-- Pilih Role --</option>
                                  <?php foreach($data['role_list'] as $row){ ?>
                                    <option value="<?php echo $row['role_id']; ?>"><?php echo $row['role_name']; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" id="save" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end popup add member -->

                <!-- pop up edit member -->
                <div class="modal fade bd-example-modal-md editmodal" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModaleditLabel" >
                  <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Nama User</label>
                              <div class="col-md-12 p-0">
                                <input type="hidden" class="form-control input-full" name="user_id_edit" id="user_id_edit">
                                <input type="text" class="form-control input-full" name="user_name_edit" id="user_name_edit" placeholder="Nama User">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Role</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="user_role_edit" name="user_role_edit">
                                  <option value="">-- Pilih Role --</option>
                                  <?php foreach($data['role_list'] as $row){ ?>
                                    <option value="<?php echo $row['role_id']; ?>"><?php echo $row['role_name']; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" id="edit_payment" class="btn btn-primary"><i class="fas fa-save"></i> Edit</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end popup edit member -->
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="user-list" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Nama Akun</th>
                    <th>Grup/Role</th>
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


  new bootstrap.Modal(document.getElementById('myModal'), {backdrop: 'static', keyboard: false})  
  new bootstrap.Modal(document.getElementById('exampleModaledit'), {backdrop: 'static', keyboard: false})  


  $(document ).ready(function() {
    table_class_list();
  });

  function table_class_list(){
    $('#user-list').DataTable({
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      ajax: {
        url: '<?php echo base_url(); ?>User/user_list',
        type: 'POST',
        data:  {},
      },
      columns: 
      [
        {data: 0},
        {data: 1},
        {data: 2}
      ]
    });
  }


  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id     = button.data('id')
    var name   = button.data('name')
    var role   = button.data('role')
    var modal  = $(this)
    modal.find('.modal-title').text('Edit User ' + name)
    modal.find('#user_id_edit').val(id)
    modal.find('#user_name_edit').val(name)
    modal.find('#user_role_edit').val(role)
  }) 

  $('#save').click(function(e){
    e.preventDefault();
    var user_name       = $("#user_name").val();
    var user_role       = $("#user_role").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>User/save_user",
      dataType: "json",
      data: {user_name:user_name, user_role:user_role},
      success : function(data){
        if (data.code == "200"){
          let title = 'Tambah Data';
          let message = 'Data Berhasil Di Tambah';
          let state = 'info';
          notif_success(title, message, state);
          $("#myModal").modal('hide');
          $('#user_name').val('');
          $('#user_role').val('');
          $('#user_role').trigger('change');
          $('#user-list').DataTable().ajax.reload();
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

  function delete_account(id)
  {
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus Data Pengguna ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>User/delete_account",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              let title = 'Hapus Data Pengguna';
              let message = 'Berhasil Hapus Data Pengguna';
              let state = 'danger';
              notif_success(title, message, state);
              $('#user-list').DataTable().ajax.reload();
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

  $('#edit_payment').click(function(e){
    e.preventDefault();
    var user_id_edit             = $("#user_id_edit").val();
    var user_name_edit           = $("#user_name_edit").val();
    var user_role_edit           = $("#user_role_edit").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>User/save_user",
      dataType: "json",
      data: {user_name:user_name_edit, user_role:user_role_edit, user_id_inp:user_id_edit},
      success : function(data){
        if (data.code == "200"){
          let title = 'Tambah Data';
          let message = 'Data Berhasil Di Edit';
          let state = 'info';
          notif_success(title, message, state);
          $("#exampleModaledit").modal('hide');
          $('#user-list').DataTable().ajax.reload();
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

  $('#reload').click(function(e){
    e.preventDefault();
    location.reload();
  });
</script>