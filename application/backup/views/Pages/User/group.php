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
                <h3 class="fw-bold mb-3">Daftar Group Pengguna</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="btnreload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>

                <!-- Tambah Role -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Group</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="role_name" placeholder="Nama Group">
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
                <!-- End Tambah Role -->

                <!-- Edit Role -->
                <div class="modal fade" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModaleditLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Group</label>
                          <div class="col-md-12 p-0">
                            <input type="hidden" class="form-control input-full" id="role_id">
                            <input type="text" class="form-control input-full" id="role_name_edit">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" id="btnedit" class="btn btn-primary"><i class="fas fa-save"></i> Edit</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Edit Role -->

                <!-- Seting Permision -->
                <div class="modal fade bd-example-modal-lg" id="exampleModalsetting" tabindex="-1" role="dialog" aria-labelledby="exampleModalsettingLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Setting Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <table class="table mt-3" style="text-align:cen">
                          <thead>
                            <tr>
                              <th scope="col">Module</th>
                              <th scope="col" colspan="2">Hak Akses</th>
                            </tr>
                          </thead>
                          <tbody id="temp">
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" id="btnedit" class="btn btn-primary"><i class="fas fa-save"></i> Edit</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Seting Permision -->

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
                  <th>Nama Group</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data['group_role'] as $row) { ?>
                  <tr>
                    <td><?php echo $row->role_name; ?></td>
                    <td>
                      <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" data-id="<?php echo $row->role_id; ?>" data-name="<?php echo $row->role_name; ?>"><i class="fas fa-trash-alt sizing-fa"></i></button>
                      <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-id="<?php echo $row->role_id; ?>" data-name="<?php echo $row->role_name; ?>" data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="far fa-edit sizing-fa"></i></button>
                      <button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="<?php echo $row->role_id; ?>" data-name="<?php echo $row->role_name; ?>" data-bs-toggle="modal" data-bs-target="#exampleModalsetting"><i class="fas fa-cog sizing-fa"></i></button>
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
          url: "<?php echo base_url(); ?>User/delete_role",
          dataType: "json",
          data: {id:id, role_name:name},
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
    var role_name   = $("#role_name").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>User/save_role",
      dataType: "json",
      data: {role_name:role_name},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>User/role";
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
    var role_id    = $("#role_id").val();
    var role_name_edit  = $("#role_name_edit").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>User/edit_role",
      dataType: "json",
      data: {role_id:role_id, role_name_edit:role_name_edit},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>User/role";
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
    var role_name_edit   = button.data('name')
    var modal = $(this)
    modal.find('.modal-title').text('Edit ' + role_name_edit)
    modal.find('#role_id').val(id)
    modal.find('#role_name_edit').val(role_name_edit)
  })


  $('#exampleModalsetting').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id')
    var role_name   = 'Ubah Aksess';
    var modal = $(this)
    modal.find('.modal-title').text(role_name)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>User/get_setting_permission",
      dataType: "json",
      data: {id:id},
      success : function(data){
        let text_temp = "";
        for (let i = 0; i < data.length; i++) {
          if(data[i].view == 'Y'){var view = 'Lihat, ';}else{var view = 'No Access';}
          if(data[i].add == 'Y'){var add = 'Tambah, ';}else{var add = '';}
          if(data[i].edit == 'Y'){var edit = 'Edit, ';}else{var edit = '';}
          if(data[i].delete == 'Y'){var deletes = 'Hapus';}else{var deletes = '';}
          text_temp += 
          '<tr><td>'+data[i].module_title+'</td><td class="'+data[i].module_name+'" onclick="tdclick(this)"><a href="#" id="'+data[i].module_name+'title" class"'+data[i].module_name+'-title">'+view+''+add+''+edit+''+deletes+'</a><div id="'+data[i].module_name+'" class="hide-permission">';
          if(data[i].view == 'Y'){
            text_temp += 
            '<input class="form-check-input" type="checkbox" name="flexCheckDefaulta'+data[i].module_name+'" id="flexCheckDefaulta'+data[i].module_name+'" onclick="editcheck(\''+data[i].role_permision+'-'+data[i].module_name+'\')" checked><label class="form-check-label" for="flexCheckDefault">Lihat</label> <br />';
          }else{
            text_temp += 
            '<input class="form-check-input" type="checkbox" name="flexCheckDefaulta'+data[i].module_name+'" id="flexCheckDefaulta'+data[i].module_name+'" onclick="editcheck(\''+data[i].role_permision+'-'+data[i].module_name+'\')"><label class="form-check-label" for="flexCheckDefault">Lihat</label> <br />';
          }

          if(data[i].add == 'Y'){
            text_temp += 
            '<input class="form-check-input" type="checkbox" value="" id="flexCheckDefaultb'+data[i].module_name+'" onclick="editcheck(\''+data[i].role_permision+'-'+data[i].module_name+'\')" checked><label class="form-check-label" for="flexCheckDefault">Tambah</label> <br />';
          }else{
            text_temp += 
            '<input class="form-check-input" type="checkbox" value="" id="flexCheckDefaultb'+data[i].module_name+'" onclick="editcheck(\''+data[i].role_permision+'-'+data[i].module_name+'\')"><label class="form-check-label" for="flexCheckDefault">Tambah</label> <br />';
          }

          if(data[i].edit == 'Y'){
            text_temp += 
            '<input class="form-check-input" type="checkbox" value="" id="flexCheckDefaultc'+data[i].module_name+'" onclick="editcheck(\''+data[i].role_permision+'-'+data[i].module_name+'\')" checked><label class="form-check-label" for="flexCheckDefault">Edit</label> <br />';
          }else{
            text_temp += 
            '<input class="form-check-input" type="checkbox" value="" id="flexCheckDefaultc'+data[i].module_name+'" onclick="editcheck(\''+data[i].role_permision+'-'+data[i].module_name+'\')""><label class="form-check-label" for="flexCheckDefault">Edit</label> <br />';
          }
          if(data[i].delete == 'Y'){
            text_temp += 
            '<input class="form-check-input" type="checkbox" value="" id="flexCheckDefaultd'+data[i].module_name+'" onclick="editcheck(\''+data[i].role_permision+'-'+data[i].module_name+'\')" checked><label class="form-check-label" for="flexCheckDefault">Hapus</label> <br />';
          }else{
            text_temp += 
            '<input class="form-check-input" type="checkbox" value="" id="flexCheckDefaultd'+data[i].module_name+'" onclick="editcheck(\''+data[i].role_permision+'-'+data[i].module_name+'\')"><label class="form-check-label" for="flexCheckDefault">Hapus</label> <br />';
          }
          text_temp += '</div></td>'+
          '<td><a href="#" class="'+data[i].module_name+'" id="'+data[i].module_name+'cancel" onclick="hide(this)" style="display:none;">Tutup</a></td>'+
          '</tr>';
        }
        document.getElementById("temp").innerHTML = text_temp;
      }
    });
  })


function editcheck(stringname)
{
  var data = stringname.split("-");
  var role_permission   = data[0];
  var module_name       = data[1];
  var checkboxView = 'flexCheckDefaulta' + module_name;
  var checkboxAdd = 'flexCheckDefaultb' + module_name;
  var checkboxEdit = 'flexCheckDefaultc' + module_name;
  var checkboxDelete = 'flexCheckDefaultd' + module_name;
  var checkedView = document.getElementById(checkboxView);
  var checkedAdd = document.getElementById(checkboxAdd);
  var checkedEdit = document.getElementById(checkboxEdit);
  var checkedDelete = document.getElementById(checkboxDelete);
  var value_permission_view = checkedView.checked;
  var value_permission_add = checkedAdd.checked;
  var value_permission_edit = checkedEdit.checked;
  var value_permission_delete = checkedDelete.checked;

  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>User/updatepermision",
    dataType: "json",
    data: {role_permission:role_permission, value_permission_view:value_permission_view, value_permission_add:value_permission_add, value_permission_edit:value_permission_edit, value_permission_delete:value_permission_delete},
    success : function(data){
      console.log("sucess");
    }
  });
}



function tdclick(id){
  var name = id.className;
  var title = name+'title';
  var cancel = name+'cancel';
  document.getElementById(name).style.display = "block";
  document.getElementById(title).style.display = "none";
  document.getElementById(cancel).style.display = "block";
};

function hide(id){
  var name = id.className;
  var title = name+'title';
  var cancel = name+'cancel';
  document.getElementById(title).style.display = "block";
  document.getElementById(name).style.display = "none";
  document.getElementById(cancel).style.display = "none";
};

</script>