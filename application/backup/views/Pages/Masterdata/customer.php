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
                <h3 class="fw-bold mb-3">Daftar Customer</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <div class="btn-group dropdown">
                  <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"><span class="btn-label"><i class="fas fa-file-excel"></i></span> Excell</button>
                  <ul class="dropdown-menu" role="menu">
                    <li>
                      <a class="dropdown-item" href="#">Download Template</a>
                      <a class="dropdown-item" href="#">Import Excell</a>
                    </li>
                  </ul>
                </div>
                <button class="btn btn-info" id="reload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <?php if($data['check_auth'][0]->add == 'N'){ ?>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg" disabled="disabled"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <?php }else{ ?>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <?php } ?>
                <!-- pop up add customer -->
                <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6 border-right">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kode Customer</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_code" value="Auto" readonly>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Nama Customer</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_name" placeholder="Nama Customer">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Tgl. Lahir</label>
                              <div class="col-md-12 p-0">
                                <input type="date" class="form-control input-full" id="customer_dob" >
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Jenis Kelamin</label>
                              <div class="col-md-12 p-0">
                                <select class="form-select form-control" id="customer_gender">
                                  <option value="L">Laki - Laki</option>
                                  <option value="P">Perempuan</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Alamat</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="customer_address" rows="4"></textarea>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Blok & No Rumah</label>
                              <div class="row" style="padding-left: 15px;">
                                <div class="col-md-5 p-0" style="margin-right:15px;">
                                  <input type="text" class="form-control input-full" id="customer_address_blok" placeholder="Blok">
                                </div>
                                <div class="col-md-5 p-0">
                                  <input type="text" class="form-control input-full" id="customer_address_no" placeholder="No">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">RT/RW</label>
                              <div class="row" style="padding-left: 15px;">
                                <div class="col-md-5 p-0" style="margin-right:15px;">
                                  <input type="text" class="form-control input-full" id="customer_address_rt" placeholder="RT">
                                </div>
                                <div class="col-md-5 p-0">
                                  <input type="text" class="form-control input-full" id="customer_address_rw" placeholder="RW">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">No Telp</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_address_phone" placeholder="No Telp">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Email</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_address_email" placeholder="Email">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Alamat Pengiriman</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="customer_send_address" rows="4"></textarea>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Expedisi</label>
                              <div class="col-md-12 p-0">
                                <select class=" form-control input-full js-example-basic-multiple js-states" name="customer_expedisi" id="customer_expedisi" multiple="multiple">
                                  <?php foreach($data['ekspedisi_list'] as $row){ ?>
                                    <option value="<?php echo $row->ekspedisi_id; ?>"><?php echo $row->ekspedisi_name; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">NPWP</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_npwp" placeholder="NPWP">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">NIK</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_nik" placeholder="NIK">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Rate Customer</label>
                              <div class="col-md-12 p-0">
                                <select class="form-select form-control" id="customer_rate">
                                  <option value="Normal">Normal</option>
                                  <option value="Toko">Toko</option>
                                  <option value="Sales">Sales</option>
                                  <option value="Khusus">Khusus</option>
                                </select>
                              </div>
                            </div>

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
                <!-- end popup add customer -->

                <!-- pop up edit customer -->
                <div class="modal fade bd-example-modal-lg editmodal" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModaleditLabel" >
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6 border-right">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kode Customer</label>
                              <div class="col-md-12 p-0">
                                <input type="hidden" class="form-control input-full" id="customer_id_edit" readonly>
                                <input type="text" class="form-control input-full" id="customer_code_edit" value="Auto" readonly>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Nama Customer</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_name_edit" placeholder="Nama Customer">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Tgl. Lahir</label>
                              <div class="col-md-12 p-0">
                                <input type="date" class="form-control input-full" id="customer_dob_edit" >
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Jenis Kelamin</label>
                              <div class="col-md-12 p-0">
                                <select class="form-select form-control" id="customer_gender_edit">
                                  <option value="L">Laki - Laki</option>
                                  <option value="P">Perempuan</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Alamat</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="customer_address_edit" rows="4"></textarea>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Blok & No Rumah</label>
                              <div class="row" style="padding-left: 15px;">
                                <div class="col-md-5 p-0" style="margin-right:15px;">
                                  <input type="text" class="form-control input-full" id="customer_address_blok_edit" placeholder="Blok">
                                </div>
                                <div class="col-md-5 p-0">
                                  <input type="text" class="form-control input-full" id="customer_address_no_edit" placeholder="No">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">RT/RW</label>
                              <div class="row" style="padding-left: 15px;">
                                <div class="col-md-5 p-0" style="margin-right:15px;">
                                  <input type="text" class="form-control input-full" id="customer_address_rt_edit" placeholder="RT">
                                </div>
                                <div class="col-md-5 p-0">
                                  <input type="text" class="form-control input-full" id="customer_address_rw_edit" placeholder="RW">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">No Telp</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_address_phone_edit" placeholder="No Telp">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Email</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_address_email_edit" placeholder="Email">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Alamat Pengiriman</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="customer_send_address_edit" rows="4"></textarea>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Expedisi</label>
                              <div class="col-md-12 p-0">
                                <select class=" form-control input-full js-example-basic-multiple js-states" name="customer_expedisi_edit" id="customer_expedisi_edit" multiple="multiple">
                                  <?php foreach($data['ekspedisi_list'] as $row){ ?>
                                    <option value="<?php echo $row->ekspedisi_id; ?>"><?php echo $row->ekspedisi_name; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">NPWP</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_npwp_edit" placeholder="NPWP">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">NIK</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_nik_edit" placeholder="NIK">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Rate Customer</label>
                              <div class="col-md-12 p-0">
                                <select class="form-select form-control" id="customer_rate_edit">
                                  <option value="Normal">Normal</option>
                                  <option value="Toko">Toko</option>
                                  <option value="Sales">Sales</option>
                                  <option value="Khusus">Khusus</option>
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
                <!-- end popup edit customer -->
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
                  <th>Kode</th>
                  <th>Rate</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Telp</th>
                  <th>Expedisi</th>
                  <th>Poin</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach($data['customer_list'] as $row){ ?>
                  <tr>
                    <td><?php echo $row->customer_code; ?></td>
                    <td>
                      <?php if($row->customer_rate == 'Normal'){ ?>
                        <span class="badge badge-primary">
                        <?php }else if($row->customer_rate == 'Toko'){ ?>
                          <span class="badge badge-warning">
                          <?php }else if($row->customer_rate == 'Sales'){ ?>
                            <span class="badge badge-info">
                            <?php }else{ ?>
                              <span class="badge badge-success">
                              <?php } ?>
                              <?php echo $row->customer_rate; ?></span></td>
                              <td><?php echo $row->customer_name; ?></td>
                              <td><?php echo $row->customer_address; ?></td>
                              <td><?php echo $row->customer_phone; ?></td>
                              <td><?php foreach(explode(",",$row->customer_expedisi_tag) as $rows){ echo '<span class="badge badge-primary" style="margin-right:1px;">'.$rows.'</span>';} ?></td>
                              <td><?php echo $row->customer_poin; ?></td>
                              <td>
                                <?php if($data['check_auth'][0]->view == 'N'){ ?>
                                  <a href="<?php echo base_url();?>Masterdata/detailcustomer?id=<?php echo $row->customer_id; ?>" data-fancybox data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn"><i class="fas fa-eye sizing-fa" disabled="disabled"></i></button></a>
                                <?php }else{ ?> 
                                  <a href="<?php echo base_url();?>Masterdata/detailcustomer?id=<?php echo $row->customer_id; ?>" data-fancybox data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn"><i class="fas fa-eye sizing-fa"></i></button></a>
                                <?php } ?>
                                <?php if($data['check_auth'][0]->delete == 'N'){ ?>
                                  <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" data-id="<?php echo $row->customer_id; ?>" data-name="<?php echo $row->customer_name; ?>"><i class="fas fa-trash-alt sizing-fa" disabled="disabled"></i></button>
                                <?php }else{ ?> 
                                  <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" data-id="<?php echo $row->customer_id; ?>" data-name="<?php echo $row->customer_name; ?>"><i class="fas fa-trash-alt sizing-fa"></i></button>
                                <?php } ?>
                                <?php if($data['check_auth'][0]->edit == 'N'){ ?>
                                  <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->customer_id; ?>" data-name="<?php echo $row->customer_name; ?>" data-bs-toggle="modal" data-bs-target="#exampleModaledit" disabled="disabled"><i class="far fa-edit sizing-fa"></i></button>
                                <?php }else{ ?> 
                                  <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="<?php echo $row->customer_id; ?>" data-name="<?php echo $row->customer_name; ?>" data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="far fa-edit sizing-fa"></i></button>
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
                  url: "<?php echo base_url(); ?>Masterdata/delete_customer",
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
            var customer_name             = $("#customer_name").val();
            var customer_dob              = $("#customer_dob").val();
            var customer_gender           = $("#customer_gender").val();
            var customer_address          = $("#customer_address").val();
            var customer_address_blok     = $("#customer_address_blok").val();
            var customer_address_no       = $("#customer_address_no").val();
            var customer_address_rt       = $("#customer_address_rt").val();
            var customer_address_rw       = $("#customer_address_rw").val();
            var customer_address_phone    = $("#customer_address_phone").val();
            var customer_address_email    = $("#customer_address_email").val();
            var customer_send_address     = $("#customer_send_address").val();
            var customer_expedisi         = $("#customer_expedisi").val();
            var customer_expedisi_text    = $('#customer_expedisi option:selected').toArray().map(item => item.text).join();
            var customer_npwp             = $("#customer_npwp").val();
            var customer_nik              = $("#customer_nik").val();
            var customer_rate             = $("#customer_rate").val();

            $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>Masterdata/save_customer",
              dataType: "json",
              data: {customer_name:customer_name, customer_dob:customer_dob, customer_gender:customer_gender, customer_address:customer_address, customer_address_blok:customer_address_blok, customer_address_no:customer_address_no, customer_address_rt:customer_address_rt, customer_address_rw:customer_address_rw, customer_address_phone:customer_address_phone, customer_address_email:customer_address_email, customer_send_address:customer_send_address, customer_dob:customer_dob, customer_gender:customer_gender, customer_expedisi:customer_expedisi, customer_npwp:customer_npwp, customer_nik:customer_nik, customer_rate:customer_rate, customer_expedisi_text:customer_expedisi_text},
              success : function(data){
                if (data.code == "200"){
                  window.location.href = "<?php echo base_url(); ?>Masterdata/customer";
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
            var customer_id               = $("#customer_id_edit").val();
            var customer_code             = $("#customer_code_edit").val();
            var customer_name             = $("#customer_name_edit").val();
            var customer_dob              = $("#customer_dob_edit").val();
            var customer_gender           = $("#customer_gender_edit").val();
            var customer_address          = $("#customer_address_edit").val();
            var customer_address_blok     = $("#customer_address_blok").val();
            var customer_address_no       = $("#customer_address_no_edit").val();
            var customer_address_rt       = $("#customer_address_rt_edit").val();
            var customer_address_rw       = $("#customer_address_rw_edit").val();
            var customer_address_phone    = $("#customer_address_phone_edit").val();
            var customer_address_email    = $("#customer_address_email_edit").val();
            var customer_send_address     = $("#customer_send_address_edit").val();
            var customer_expedisi         = $("#customer_expedisi_edit").val();
            var customer_expedisi_text    = $('#customer_expedisi_edit option:selected').toArray().map(item => item.text).join();
            var customer_npwp             = $("#customer_npwp_edit").val();
            var customer_nik              = $("#customer_nik_edit").val();
            var customer_rate             = $("#customer_rate_edit").val();

            $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>Masterdata/edit_customer",
              dataType: "json",
              data: {customer_id:customer_id, customer_code:customer_code, customer_name:customer_name, customer_dob:customer_dob, customer_gender:customer_gender, customer_address:customer_address, customer_address_blok:customer_address_blok, customer_address_no:customer_address_no, customer_address_rt:customer_address_rt, customer_address_rw:customer_address_rw, customer_address_phone:customer_address_phone, customer_address_email:customer_address_email, customer_send_address:customer_send_address, customer_dob:customer_dob, customer_gender:customer_gender, customer_expedisi:customer_expedisi, customer_npwp:customer_npwp, customer_nik:customer_nik, customer_rate:customer_rate, customer_expedisi_text:customer_expedisi_text},
              success : function(data){
                if (data.code == "200"){
                  window.location.href = "<?php echo base_url(); ?>Masterdata/customer";
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
    var id   = button.data('id')
    var name = button.data('name')
    var modal = $(this)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/get_customer_id",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          let customer_data = data.result.get_customer_by_id;
          for (let i = 0; i < customer_data.length; i++) {
            modal.find('.modal-title').text('Edit ' + customer_data[i].customer_name)
            modal.find('#customer_id_edit').val(customer_data[i].customer_id)
            modal.find('#customer_code_edit').val(customer_data[i].customer_code)
            modal.find('#customer_name_edit').val(customer_data[i].customer_name)
            modal.find('#customer_dob_edit').val(customer_data[i].customer_dob)
            modal.find('#customer_gender_edit').val(customer_data[i].customer_gender)
            modal.find('#customer_address_edit').val(customer_data[i].customer_address)
            modal.find('#customer_address_blok_edit').val(customer_data[i].customer_address_blok)
            modal.find('#customer_address_no_edit').val(customer_data[i].customer_address_no)
            modal.find('#customer_address_rt_edit').val(customer_data[i].customer_rt)
            modal.find('#customer_address_rw_edit').val(customer_data[i].customer_rw)
            modal.find('#customer_address_phone_edit').val(customer_data[i].customer_phone)
            modal.find('#customer_address_email_edit').val(customer_data[i].customer_email)
            modal.find('#customer_send_address_edit').val(customer_data[i].customer_send_address)
            modal.find('#customer_npwp_edit').val(customer_data[i].customer_npwp)
            modal.find('#customer_nik_edit').val(customer_data[i].customer_nik)
            modal.find('#customer_rate_edit').val(customer_data[i].customer_rate)
            const customer_expedisi_tag_array = customer_data[i].customer_expedisi_tag_id.split(",")
            modal.find('#customer_expedisi_edit').val(customer_expedisi_tag_array)
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.result,
          })
        }
      }
    });
  })

          $('#reload').click(function(e){
            e.preventDefault();
            location.reload();
          });
        </script>