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
                <h3 class="fw-bold mb-3">Daftar Produk</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModalsearch" type="button">
                  <span class="btn-label"><i class="fas fa-search"></i></span> Filter
                </button>
                <div class="modal fade filter" id="myModalsearch" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Filter Pencarian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Supplier</label>
                          <div class="col-md-12 p-0">
                            <select class="form-control input-full js-example-basic-single" id="filter_supplier" name="filter_supplier">
                              <option value="">ALL</option>
                              <?php foreach ($data['supplier_list'] as $row) { ?>
                                <option value="<?php echo $row->supplier_name; ?>"><?php echo $row->supplier_name; ?></option>  
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Kategori</label>
                          <div class="col-md-12 p-0">
                            <select class="form-control input-full js-example-basic-single" id="filter_category" name="filter_category">
                              <option value="">ALL</option>
                              <?php foreach ($data['category_list'] as $row) { ?>
                                <option value="<?php echo $row->category_id; ?>"><?php echo $row->category_name; ?></option>  
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Brand</label>
                          <div class="col-md-12 p-0">
                            <select class="form-control input-full js-example-basic-single" id="filter_brand" name="filter_brand">
                              <option value="">ALL</option>
                              <?php foreach ($data['brand_list'] as $row) { ?>
                                <option value="<?php echo $row->brand_id; ?>"><?php echo $row->brand_name; ?></option>  
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Product Status</label>
                          <div class="col-md-12 p-0">
                            <select class="form-control input-full js-example-basic-single" id="filter_product_status" name="filter_product_status">
                              <option value="">ALL</option>
                              <option value="Aktif">Aktif</option>
                              <option value="Tidak Aktif">Tidak Aktif</option>
                              <option value="Discontinue">Discontinue</option>
                              
                            </select>
                          </div>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" id="filter" class="btn btn-warning" ><i class="fas fa-search"></i> Cari</button>
                      </div>
                    </div>
                  </div>
                </div>
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
                <?php if($data['check_auth']['check_access'][0]->add == 'N'){ ?>
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl" disabled="disabled"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <?php }else{ ?>
                 <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
               <?php } ?>
               <div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form name="save_product_form" id="save_product_form" enctype="multipart/form-data" action="<?php echo base_url(); ?>Masterdata/save_product" method="post">
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4 border-right">
                            <div class="form-group form-inline">
                              <div class="proof">
                                <div class="imgArea" data-title="">
                                  <input type="file" name="screenshoot" id="screenshoot" hidden accept="image/*" />
                                  <i class="fa-solid fa-cloud-arrow-up"></i>
                                  <h4>upload screenshoot</h4>
                                  <p>image size must be less than <span>2MB</span></p>
                                </div>
                                <button class="selectImage" type="button">Select Image</button>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kode Produk</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" name="product_code" id="product_code" value="Auto" readonly>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Nama Produk</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" name="product_name" id="product_name" placeholder="Nama Produk">
                              </div>
                            </div>


                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kategori</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="product_category" name="product_category">
                                  <option>-- Pilih Kategori --</option>
                                  <?php foreach ($data['category_list'] as $row) { ?>
                                    <option value="<?php echo $row->category_id; ?>"><?php echo $row->category_name; ?></option>  
                                  <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Brand</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="product_brand" name="product_brand">
                                  <option>-- Pilih Brand --</option>
                                  <?php foreach ($data['brand_list'] as $row) { ?>
                                    <option value="<?php echo $row->brand_id; ?>"><?php echo $row->brand_name; ?></option>  
                                  <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Supplier</label>
                              <div class="col-md-12 p-0">
                                <select class=" form-control input-full js-example-basic-multiple js-states" name="product_supplier[]" id="product_supplier" multiple="multiple">
                                  <option value="">-- Pilih Supplier --</option>
                                  <?php foreach ($data['supplier_list'] as $row) { ?>
                                    <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>  
                                  <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Golongan Produk</label>
                              <div class="col-md-12 p-0">
                                <select class="form-select form-control" name="product_tax" id="product_tax">
                                  <option value="PPN">Barang Kena Pajak</option>
                                  <option value="NON PPN">Barang Tidak Kena Pajak</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Jenis Produk</label>
                              <div class="col-md-12 p-0">
                                <select class="form-select form-control" id="product_type" name="product_type">
                                  <option value="N">Produk</option>
                                  <option value="Y">Paket</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Satuan Dasar</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="product_unit" name="product_unit">
                                  <option value="">-- Pilih Satuan Dasar --</option>
                                  <?php foreach ($data['unit_list'] as $row) { ?>
                                    <option value="<?php echo $row->unit_id; ?>"><?php echo $row->unit_name; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Min Stok</label>
                              <div class="col-md-12 p-0">
                               <input type="number" class="form-control input-full" id="product_min_stock" name="product_min_stock" placeholder="Min Stok">
                             </div>
                           </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Deskripsi</label>
                            <div class="col-md-12 p-0">
                              <textarea class="form-control" id="product_description" name="product_description" rows="4"></textarea>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                      <button type="submit" class="btn btn-primary" ><i class="fas fa-save"></i> Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="modal fade bd-example-modal-xl editmodal" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModaledit">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form name="edit_product_form" id="edit_product_form" enctype="multipart/form-data" action="<?php echo base_url(); ?>Masterdata/edit_product" method="post">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-4 border-right">
                          <div class="form-group form-inline">
                            <div class="proof">
                              <div class="imgArea_edit" data-title="">
                                
                                <input type="text" name="reset_image" id="reset_image" value="">
                                <input type="file" name="screenshoot_edit" id="screenshoot_edit" hidden accept="image/*" />
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <h4>upload screenshoot</h4>
                                <p>image size must be less than <span>2MB</span></p>
                                <div id="active-image"></div>
                              </div>
                              <button class="selectImage_edit" type="button">Select Image</button>
                              
                              <button class="removeImage_edit" type="button" style="margin-top: 10px;padding: 10px 15px;border-radius: 10px;width: 100%;">Hapus Image</button>
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-12 p-0">
                              <select class="form-control input-full js-example-basic-single" id="product_status_edit" name="product_status_edit">
                                <option>-- Pilih Status --</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                                <option value="Discontinue">Discontinue</option>
                              </select>
                            </div>
                          </div>

                        </div>
                        <div class="col-md-4">
                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Kode Produk</label>
                            <div class="col-md-12 p-0">
                              <input type="hidden" class="form-control input-full" name="product_id_edit" id="product_id_edit" value="Auto" readonly>
                              <input type="text" class="form-control input-full" name="product_code_edit" id="product_code_edit" value="Auto" readonly>
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Nama Produk</label>
                            <div class="col-md-12 p-0">
                              <input type="text" class="form-control input-full" name="product_name_edit" id="product_name_edit" placeholder="Nama Produk">
                            </div>
                          </div>


                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Kategori</label>
                            <div class="col-md-12 p-0">
                              <select class="form-control input-full js-example-basic-single" id="product_category_edit" name="product_category_edit">
                                <option>-- Pilih Kategori --</option>
                                <?php foreach ($data['category_list'] as $row) { ?>
                                  <option value="<?php echo $row->category_id; ?>"><?php echo $row->category_name; ?></option>  
                                <?php } ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Brand</label>
                            <div class="col-md-12 p-0">
                              <select class="form-control input-full js-example-basic-single" id="product_brand_edit" name="product_brand_edit">
                                <option>-- Pilih Brand --</option>
                                <?php foreach ($data['brand_list'] as $row) { ?>
                                  <option value="<?php echo $row->brand_id; ?>"><?php echo $row->brand_name; ?></option>  
                                <?php } ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Supplier</label>
                            <div class="col-md-12 p-0">
                              <select class=" form-control input-full js-example-basic-multiple js-states" name="product_supplier_edit[]" id="product_supplier_edit" multiple="multiple">
                                <option value="">-- Pilih Supplier --</option>
                                <?php foreach ($data['supplier_list'] as $row) { ?>
                                  <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>  
                                <?php } ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Golongan Produk</label>
                            <div class="col-md-12 p-0">
                              <select class="form-select form-control" name="product_tax_edit" id="product_tax_edit">
                                <option value="PPN">Barang Kena Pajak</option>
                                <option value="NON PPN">Barang Tidak Kena Pajak</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Jenis Produk</label>
                            <div class="col-md-12 p-0">
                              <select class="form-select form-control" id="product_type_edit" name="product_type_edit">
                                <option value="N">Produk</option>
                                <option value="Y">Paket</option>
                              </select>
                            </div>
                          </div>

                        </div>
                        <div class="col-md-4">
                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Satuan Dasar</label>
                            <div class="col-md-12 p-0">
                              <select class="form-control input-full js-example-basic-single" id="product_unit_edit" name="product_unit_edit">
                                <option value="">-- Pilih Satuan Dasar --</option>
                                <?php foreach ($data['unit_list'] as $row) { ?>
                                  <option value="<?php echo $row->unit_id; ?>"><?php echo $row->unit_name; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Min Stok</label>
                            <div class="col-md-12 p-0">
                              <input type="number" class="form-control input-full" id="product_min_stock_edit" name="product_min_stock_edit" placeholder="Min Stock">
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Deskripsi</label>
                            <div class="col-md-12 p-0">
                              <textarea class="form-control" id="product_description_edit" name="product_description_edit" rows="4"></textarea>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                      <button type="submit" class="btn btn-primary" ><i class="fas fa-save"></i> Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="product-list" class="display table table-striped table-hover">
          <thead>
            <tr>
              <th width="30%">Nama Produk</th>
              <th>Satuan</th>
              <th>Brand</th>
              <th>Kategori</th>
              <th>Harga Jual</th>
              <th>Supplier</th>
              <th>Status</th>
              <th>Paket</th>
              <th>PPN</th>
              <th width="20%;">Gambar</th>
              <th width="10%;">Aksi</th>
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
    table_product_list();
    if (window.performance) {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Masterdata/delete_filter_product",
        dataType: "json",
        data: {},
        success : function(data){
          if (data.code == "200"){
            console.log('clear');
          }
        }
      });
    }
  });

  $('#exampleModaledit').on('hidden.bs.modal', function () {
      location.reload();
  });

  function table_product_list(){
    $('#product-list').DataTable({
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      ajax: {
        url: '<?php echo base_url(); ?>Masterdata/product_list',
        type: 'POST',
        data: function (d) {
          d.filter_supplier = $('#filter_supplier').val();
          d.filter_category = $('#filter_category').val();
          d.filter_brand = $('#filter_brand').val();
          d.filter_product_status = $('#filter_product_status').val();
        }
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
        {data: 8},
        {data: 9},
        {data: 10}
      ]
    });
  }

  function setprice(id){
    var url = "<?php echo base_url(); ?>Masterdata/settingproduct?id="+id;
    window.open(url, '_blank').focus();
    //window.location.href = "<?php echo base_url(); ?>Masterdata/settingproduct?id="+id;
  }

  $('#save_product_form').on('submit',(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var product_name = $("#product_name").val();
    var product_category = $("#product_category").val();
    var product_brand = $("#product_brand").val();
    var product_supplier = $("#product_supplier").val();
    var product_unit = $("#product_unit").val();
    var product_supplier_text    = $('#product_supplier option:selected').toArray().map(item => item.text).join();
    formData.append('product_supplier_text', product_supplier_text);


    if(product_name == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Nama Produk Harus Di Isi',
      })
    }else if(product_category == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Kategori Harus Di Isi',
      })
    }else if(product_brand == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Brand Harus Di Isi',
      })
    }else if(product_supplier == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Supplier Harus Di Isi',
      })
    }else if(product_unit == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Satuan Harus Di Isi',
      })
    }else{
      $.ajax({
        type:'POST',
        url: $(this).attr('action'),
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){          
          window.location.href = "<?php echo base_url(); ?>Masterdata/product";
          Swal.fire('Saved!', '', 'success');
        }
      });
    }
  }));

  $('#filter').click(function(e){
    e.preventDefault();
    var filter_supplier           = $("#filter_supplier option:selected").text();
    var filter_category           = $("#filter_category").val();
    var filter_brand              = $("#filter_brand").val();
    var filter_product_status     = $("#filter_product_status").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/insert_filter_product",
      dataType: "json",
      data: {filter_supplier:filter_supplier, filter_category:filter_category, filter_brand:filter_brand, filter_product_status:filter_product_status},
      success : function(data){
        if (data.code == "200"){
          $('#product-list').DataTable().ajax.reload();
          $('#myModalsearch').modal('hide');
        }
      }
    });
  });

  $('#edit_product_form').on('submit',(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var product_name = $("#product_name_edit").val();
    var product_category = $("#product_category_edit").val();
    var product_brand = $("#product_brand_edit").val();
    var product_supplier = $("#product_supplier_edit").val();
    var product_unit = $("#product_unit_edit").val();
    var product_supplier_text    = $('#product_supplier_edit option:selected').toArray().map(item => item.text).join();
    formData.append('product_supplier_text_edit', product_supplier_text);


    if(product_name == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Nama Produk Harus Di Isi',
      })
    }else if(product_category == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Kategori Harus Di Isi',
      })
    }else if(product_brand == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Brand Harus Di Isi',
      })
    }else if(product_supplier == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Supplier Harus Di Isi',
      })
    }else if(product_unit == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Satuan Harus Di Isi',
      })
    }else{
      $.ajax({
        type:'POST',
        url: $(this).attr('action'),
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){          
          window.location.href = "<?php echo base_url(); ?>Masterdata/product";
          Swal.fire('Saved!', '', 'success');
        }
      });
    }
  }));

  /* image uplaod */
  const fileTypes = [
    "image/apng",
    "image/bmp",
    "image/gif",
    "image/jpeg",
    "image/pjpeg",
    "image/png",
    "image/svg+xml",
    "image/tiff",
    "image/webp",
    "image/x-icon",
    "image/avif",
  ];
  function validFileType(file) {
    return fileTypes.includes(file.type);
  }

  let inputHidden = document.querySelector("#screenshoot");
  let triggerInput = document.querySelector(".selectImage");
  let imgArea = document.querySelector(".imgArea");

  triggerInput.addEventListener("click",function(){
    inputHidden.click();
  })

  inputHidden.addEventListener("change",function(e){
    let image = e.target.files[0];
    if(!validFileType(image)){
      alert("invalid file type");
      return;
    }
    if(image.size > 2097152){
      alert("image size must be less than 2MB");
      return;
    }else{
      const reader = new FileReader();
      reader.addEventListener("load",function(){
        const allImgs = document.querySelectorAll(".imgArea img");
        allImgs.forEach((img) => {
          img.remove();
        })
        const imgUrl = reader.result;
        const img = document.createElement("img");
        img.src = imgUrl;
        imgArea.appendChild(img);
        imgArea.classList.add("active");
        imgArea.dataset.title = image.name;
      })
      reader.readAsDataURL(image);
    }
  })
  /* END IMAGE UPLOAD */


// Edit Image //

  let inputHidden_edit = document.querySelector("#screenshoot_edit");
  let triggerInput_edit = document.querySelector(".selectImage_edit");
  let imgArea_edit = document.querySelector(".imgArea_edit");

  triggerInput_edit.addEventListener("click",function(){
    inputHidden_edit.click();
  })

  inputHidden_edit.addEventListener("change",function(e){
    let image = e.target.files[0];
    if(!validFileType(image)){
      alert("invalid file type");
      return;
    }
    if(image.size > 2097152){
      alert("image size must be less than 2MB");
      return;
    }else{
      const reader = new FileReader();
      reader.addEventListener("load",function(){
        const allImgs = document.querySelectorAll(".imgArea_edit img");
        allImgs.forEach((img) => {
          img.remove();
        })
        const imgUrl = reader.result;
        const img = document.createElement("img");
        img.src = imgUrl;
        imgArea_edit.appendChild(img);
        imgArea_edit.classList.add("active");
        imgArea_edit.dataset.title = image.name;
      })
      reader.readAsDataURL(image);
    }
  })

  const removeImageButton_edit = document.querySelector('.removeImage_edit');
  if (removeImageButton_edit) {
    removeImageButton_edit.addEventListener('click', function () {
      const allImgs = document.querySelectorAll('.imgArea_edit img');
      allImgs.forEach((img) => img.remove());
      const defaultImg = document.createElement("img");
      defaultImg.src = '<?php echo base_url(); ?>assets/products/default.png';
      imgArea_edit.appendChild(defaultImg);
      imgArea_edit.classList.add('active');
      imgArea_edit.dataset.title = 'default.png';
              $("#reset_image").val(1);
    });
  }

// End Edit Image //


  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id')
    var name = button.data('name')
    var modal = $(this)
    modal.find('.modal-title').text('Edit product ' + name)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/get_edit_product",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          document.getElementById("active-image").innerHTML = "";
          let row = data.result[0];
          modal.find('#product_id_edit').val(id)
          modal.find('#product_code_edit').val(row.product_code)
          modal.find('#product_name_edit').val(row.product_name)
          modal.find('#product_category_edit').val(row.category_id)
          modal.find('#product_brand_edit').val(row.brand_id)
          modal.find('#product_unit_edit').val(row.unit_id)
          const product_supplier_id_tag = row.product_supplier_id_tag.split(",")
          modal.find('#product_supplier_edit').val(product_supplier_id_tag)
          modal.find('#product_tax_edit').val(row.is_ppn)
          modal.find('#product_type_edit').val(row.is_package)
          modal.find('#product_min_stock_edit').val(row.product_min_stock)
          modal.find('#product_description_edit').val(row.product_desc)
          modal.find('#product_status_edit').val(row.product_status)


          var elem = document.createElement("img");
          document.getElementById("active-image").appendChild(elem);
          elem.src = '<?php echo base_url(); ?>assets/products/'+row.product_image;
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

  function deletes(id)
  {
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus Data Produk ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Masterdata/delete_product",
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
  }

  function deleteProductNote(noteId){
    if(!noteId) return;
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus Catatan Produk ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Masterdata/delete_product_note",
          dataType: "json",
          data: {note_id:noteId},
          success : function(data){
            if (data.code == "200"){
              var el = document.getElementById('product-note-'+noteId);
              if(el) el.remove();
              Swal.fire('Deleted!', '', 'success'); 
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.msg || data.result,
              })
            }
          }
        });
      }
    })
  }

  $(".delete").click(function (e) {
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");

  });


  $('#reload').click(function(e){
    e.preventDefault();
    location.reload();
  });
  

</script>