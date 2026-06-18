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
                <h3 class="fw-bold mb-3">Daftar Supplier</h3>
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
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Supplier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Kode Supplier</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="supplier_code" value="AUTO" readonly>
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Supplier</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="supplier_name" placeholder="Nama Supplier">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Telp</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="supplier_telp" placeholder="Telp Supplier">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Alamat</label>
                          <div class="col-md-12 p-0">
                            <textarea class="form-control" id="supplier_address" rows="5"></textarea>
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

                <div class="modal fade" id="exampleModaledit" tabindex="-1" aria-labelledby="exampleModaleditLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModaledit">Edit Supplier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Kode Supplier</label>
                          <div class="col-md-12 p-0">
                            <input type="hidden" class="form-control input-full" id="supplier_id_edit" readonly>
                            <input type="text" class="form-control input-full" id="supplier_code_edit" readonly>
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Supplier</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="supplier_name_edit" placeholder="Nama Supplier">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Telp</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="supplier_telp_edit" placeholder="Telp Supplier">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Alamat</label>
                          <div class="col-md-12 p-0">
                            <textarea class="form-control" id="supplier_address_edit" rows="5"></textarea>
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
                  <th>Kode Supplier</th>
                  <th>Nama Supplier</th>
                  <th>Alamat</th>
                  <th>Telp</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($data['supplier_list'] as $row){ ?>
                  <tr>
                    <td><?php echo $row->supplier_code; ?></td>
                    <td><?php echo $row->supplier_name; ?></td>
                    <td><?php echo $row->supplier_address; ?></td>
                    <td><?php echo $row->supplier_phone; ?></td>
                    <td>
                      <?php if($data['check_auth'][0]->delete == 'N'){ ?>
                        <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn delete" data-id="<?php echo $row->supplier_id; ?>" data-name="<?php echo $row->supplier_name; ?>" disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button>
                      <?php }else{ ?>
                        <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn delete" data-id="<?php echo $row->supplier_id; ?>" data-name="<?php echo $row->supplier_name; ?>"><i class="fas fa-trash-alt sizing-fa"></i></button>
                      <?php } ?>
                      <?php if($data['check_auth'][0]->edit == 'N'){ ?>
                        <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->supplier_id; ?>"  data-code="<?php echo $row->supplier_code; ?>" data-name="<?php echo $row->supplier_name; ?>" data-address="<?php echo $row->supplier_address; ?>" data-phone="<?php echo $row->supplier_phone; ?>" data-bs-toggle="modal" data-bs-target="#exampleModaledit" disabled="disabled"><i class="far fa-edit sizing-fa"></i></button>
                      <?php }else{ ?>
                        <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->supplier_id; ?>"  data-code="<?php echo $row->supplier_code; ?>" data-name="<?php echo $row->supplier_name; ?>" data-address="<?php echo $row->supplier_address; ?>" data-phone="<?php echo $row->supplier_phone; ?>"  data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="far fa-edit sizing-fa"></i></button>
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
    var supplier_name     = $("#supplier_name").val();
    var supplier_telp     = $("#supplier_telp").val();
    var supplier_address  = $("#supplier_address").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/save_supplier",
      dataType: "json",
      data: {supplier_name:supplier_name, supplier_telp:supplier_telp, supplier_address:supplier_address},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/supplier";
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
    var supplier_id       = $("#supplier_id_edit").val();
    var supplier_name     = $("#supplier_name_edit").val();
    var supplier_telp     = $("#supplier_telp_edit").val();
    var supplier_address  = $("#supplier_address_edit").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/edit_supplier",
      dataType: "json",
      data: {supplier_id:supplier_id, supplier_name:supplier_name, supplier_telp:supplier_telp, supplier_address:supplier_address},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/supplier";
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
          url: "<?php echo base_url(); ?>Masterdata/delete_supplier",
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

  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id                    = button.data('id')
    var supplier_code_edit    = button.data('code')
    var supplier_name_edit    = button.data('name')
    var supplier_telp_edit    = button.data('phone')
    var supplier_address_edit = button.data('address')
    var modal = $(this)
    modal.find('.modal-title').text('Edit ' + supplier_name_edit)
    modal.find('#supplier_id_edit').val(id)
    modal.find('#supplier_code_edit').val(supplier_code_edit)
    modal.find('#supplier_name_edit').val(supplier_name_edit)
    modal.find('#supplier_telp_edit').val(supplier_telp_edit)
    modal.find('#supplier_address_edit').val(supplier_address_edit)
  })


</script>