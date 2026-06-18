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
                <h3 class="fw-bold mb-3">Daftar Salesman</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="reload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>


                <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Salesman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Salesman</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="salesman_name" placeholder="Nama Salesman">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Telp</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="salesman_phone" placeholder="Telp Salesman">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Alamat</label>
                          <div class="col-md-12 p-0">
                            <textarea class="form-control" id="salesman_address" rows="5"></textarea>
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Cabang</label>
                          <div class="col-md-12 p-0">
                            <select class="form-select form-control" id="salesman_branch">
                              <?php foreach($data['warehouse_list'] as $row){ ?>
                                <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>
                              <?php } ?>
                            </select>
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

                <div class="modal fade bd-example-modal-lg" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModaledit">Edit Salesman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Salesman</label>
                          <div class="col-md-12 p-0">
                            <input type="hidden" class="form-control input-full" id="salesman_id_edit">
                            <input type="text" class="form-control input-full" id="salesman_name_edit" placeholder="Nama Salesman">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Telp</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="salesman_phone_edit" placeholder="Telp Salesman">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Alamat</label>
                          <div class="col-md-12 p-0">
                            <textarea class="form-control" id="salesman_address_edit" rows="5"></textarea>
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Cabang</label>
                          <div class="col-md-12 p-0">
                            <select class="form-select form-control" id="salesman_branch_edit">
                              <?php foreach($data['warehouse_list'] as $row){ ?>
                                <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>
                              <?php } ?>
                            </select>
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
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Telp</th>
                  <th>Cabang</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data['salesman_list'] as $row){ ?>
                  <tr>
                    <td><?php echo $row->salesman_name; ?></td>
                    <td><?php echo $row->salesman_address; ?></td>
                    <td><?php echo $row->salesman_phone; ?></td>
                    <td><?php echo $row->warehouse_name; ?></td>
                    <td>
                      <?php if($data['check_auth'][0]->view == 'N'){ ?>
                        <a href="<?php echo base_url();?>Masterdata/detailsalesman?id=<?php echo $row->salesman_id; ?>" data-fancybox data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn"><i class="fas fa-eye sizing-fa" disabled="disabled"></i></button></a>
                      <?php }else{ ?>
                        <a href="<?php echo base_url();?>Masterdata/detailsalesman?id=<?php echo $row->salesman_id; ?>" data-fancybox data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn"><i class="fas fa-eye sizing-fa"></i></button></a>
                      <?php } ?>
                      <?php if($data['check_auth'][0]->delete == 'N'){ ?>
                        <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" data-id="<?php echo $row->salesman_id; ?>" data-name="<?php echo $row->salesman_name; ?>"><i class="fas fa-trash-alt sizing-fa" disabled="disabled"></i></button>
                      <?php }else{ ?> 
                        <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" data-id="<?php echo $row->salesman_id; ?>" data-name="<?php echo $row->salesman_name; ?>"><i class="fas fa-trash-alt sizing-fa"></i></button>
                      <?php } ?>
                      <?php if($data['check_auth'][0]->edit == 'N'){ ?>
                        <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->salesman_id; ?>" data-name="<?php echo $row->salesman_name; ?>" data-address="<?php echo $row->salesman_address; ?>" data-phone="<?php echo $row->salesman_phone; ?>" data-branch="<?php echo $row->salesman_branch; ?>" data-bs-toggle="modal" data-bs-target="#exampleModaledit" disabled="disabled"><i class="far fa-edit sizing-fa"></i></button>
                      <?php }else{ ?> 
                        <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->salesman_id; ?>" data-name="<?php echo $row->salesman_name; ?>" data-address="<?php echo $row->salesman_address; ?>" data-phone="<?php echo $row->salesman_phone; ?>" data-branch="<?php echo $row->salesman_branch; ?>" data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="far fa-edit sizing-fa"></i></button>
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


  new bootstrap.Modal(document.getElementById('myModal'), {backdrop: 'static', keyboard: false})  
  new bootstrap.Modal(document.getElementById('exampleModaledit'), {backdrop: 'static', keyboard: false})  
  
  $('#btnsave').click(function(e){
    e.preventDefault();
    var salesman_name     = $("#salesman_name").val();
    var salesman_phone    = $("#salesman_phone").val();
    var salesman_address  = $("#salesman_address").val();
    var salesman_branch   = $("#salesman_branch").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/save_salesman",
      dataType: "json",
      data: {salesman_name:salesman_name, salesman_phone:salesman_phone, salesman_address:salesman_address, salesman_branch:salesman_branch},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/salesman";
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
    var salesman_id       = $("#salesman_id_edit").val();
    var salesman_name     = $("#salesman_name_edit").val();
    var salesman_phone    = $("#salesman_phone_edit").val();
    var salesman_address  = $("#salesman_address_edit").val();
    var salesman_branch   = $("#salesman_branch_edit").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/edit_salesman",
      dataType: "json",
      data: {salesman_id:salesman_id, salesman_name:salesman_name, salesman_phone:salesman_phone, salesman_address:salesman_address, salesman_branch:salesman_branch},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/salesman";
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
    var id                    = button.data('id')
    var salesman_name_edit    = button.data('name')
    var salesman_phone_edit   = button.data('phone')
    var salesman_address_edit = button.data('address')
    var salesman_branch_edit  = button.data('branch')
    var modal = $(this)
    modal.find('.modal-title').text('Edit ' + salesman_name_edit)
    modal.find('#salesman_id_edit').val(id)
    modal.find('#salesman_name_edit').val(salesman_name_edit)
    modal.find('#salesman_phone_edit').val(salesman_phone_edit)
    modal.find('#salesman_address_edit').val(salesman_address_edit)
    modal.find('#salesman_branch_edit').val(salesman_branch_edit)
  })


  $('#reload').click(function(e){
    e.preventDefault();
    location.reload();
  }); 


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
          url: "<?php echo base_url(); ?>Masterdata/delete_salesman",
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
</script>