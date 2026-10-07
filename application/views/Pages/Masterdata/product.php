<?php
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<style>
  /* ===== Komponen gambar produk (modal tambah & edit) ===== */
  .pimg { width: 100%; }
  .pimg-label { display: block; font-size: .9rem; font-weight: 700; color: #1f2937; margin-bottom: 6px; }
  .pimg-preview {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    border: 2px dashed #cfd8e3;
    border-radius: 14px;
    background: #f8fafc;
    overflow: hidden;
    cursor: pointer;
    transition: border-color .15s, background .15s;
  }
  .pimg-preview:hover { border-color: #0f8a5f; background: #f3faf6; }
  .pimg-preview img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; background: #fff; display: none; }
  .pimg-preview.has-image { border-style: solid; border-color: #e5e7eb; }
  .pimg-preview.has-image img { display: block; }
  .pimg-preview.has-image .pimg-empty { display: none; }
  .pimg-preview.has-image::after {
    content: "\f030  Ganti gambar";
    font-family: 'Font Awesome 5 Solid', 'Public Sans', sans-serif;
    font-weight: 900;
    position: absolute; left: 0; right: 0; bottom: 0;
    padding: 8px; text-align: center; font-size: .8rem;
    color: #fff; background: rgba(15, 23, 42, .55);
    opacity: 0; transition: opacity .15s;
  }
  .pimg-preview.has-image:hover::after { opacity: 1; }
  .pimg-empty { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 16px; color: #6b7280; }
  .pimg-empty-icon { width: 64px; height: 64px; border-radius: 16px; background: #e3f5ee; color: #0f8a5f; display: flex; align-items: center; justify-content: center; font-size: 1.7rem; margin-bottom: 12px; }
  .pimg-empty b { color: #374151; font-size: .95rem; }
  .pimg-empty span { font-size: .8rem; margin-top: 2px; }
  .pimg-name { font-size: .78rem; color: #6b7280; margin-top: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; min-height: 1em; }
  .pimg-actions { display: flex; gap: 8px; margin-top: 6px; }
  .pimg-btn { height: 40px; border-radius: 10px; font-weight: 700; font-size: .88rem; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: 1px solid #e5e7eb; background: #fff; color: #1f2937; transition: background .15s; }
  .pimg-select { flex: 1; color: #0f8a5f; border-color: #b7e4cf; background: #f3faf6; }
  .pimg-select:hover { background: #e3f5ee; }
  .pimg-remove { width: 44px; color: #dc2626; border-color: #fbd5d5; background: #fff5f5; }
  .pimg-remove:hover { background: #fee2e2; }
  .pimg-remove:disabled { opacity: .4; cursor: not-allowed; }
  .pimg-hint { display: block; font-size: .75rem; color: #9ca3af; margin-top: 6px; }
</style>

<div class="container">
  <div class="page-inner">
    <div class="page-header">

    </div>
    <div class="row">
      <div class="col-md-12">
        <?php $this->load->view('Pages/Layout/list_header', array(
          'list_icon'     => 'fas fa-box',
          'list_title'    => 'Daftar Produk',
          'list_subtitle' => 'Kelola data produk, harga, dan stok.',
        )); ?>
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
                      <a class="dropdown-item" href="<?php echo base_url(); ?>Masterdata/export_sample_import_product">Download Template</a>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalImportExcell">Import Excell</a>
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
                              <div class="pimg" id="pimg_add">
                                <label class="pimg-label">Gambar Produk</label>
                                <input type="file" name="screenshoot" id="screenshoot" hidden accept="image/*" />
                                <div class="pimg-preview" title="Klik untuk memilih gambar">
                                  <img alt="">
                                  <div class="pimg-empty">
                                    <div class="pimg-empty-icon"><i class="fas fa-image"></i></div>
                                    <b>Belum ada gambar</b>
                                    <span>Klik untuk memilih gambar</span>
                                  </div>
                                </div>
                                <div class="pimg-name"></div>
                                <div class="pimg-actions">
                                  <button type="button" class="pimg-btn pimg-select"><i class="fas fa-upload"></i> Pilih Gambar</button>
                                  <button type="button" class="pimg-btn pimg-remove" title="Hapus gambar"><i class="fas fa-trash-alt"></i></button>
                                </div>
                                <small class="pimg-hint">JPG, PNG, WEBP &middot; maksimal 2MB</small>
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
                            <label for="inlineinput" class="col-md-3 col-form-label">HPP Discount</label>
                            <div class="col-md-12 p-0">
                              <input type="number" step="any" min="0" class="form-control input-full" id="product_hpp_discount" name="product_hpp_discount" placeholder="Kosong = pakai HPP">
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">HPP</label>
                            <div class="col-md-12 p-0">
                              <input type="number" min="0" class="form-control input-full" id="product_hpp" name="product_hpp" placeholder="HPP" value="0">
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
                            <div class="pimg" id="pimg_edit">
                              <label class="pimg-label">Gambar Produk</label>
                              <input type="hidden" name="reset_image" id="reset_image" value="">
                              <input type="file" name="screenshoot_edit" id="screenshoot_edit" hidden accept="image/*" />
                              <div class="pimg-preview" title="Klik untuk mengganti gambar">
                                <img alt="">
                                <div class="pimg-empty">
                                  <div class="pimg-empty-icon"><i class="fas fa-image"></i></div>
                                  <b>Belum ada gambar</b>
                                  <span>Klik untuk memilih gambar</span>
                                </div>
                              </div>
                              <div class="pimg-name"></div>
                              <div class="pimg-actions">
                                <button type="button" class="pimg-btn pimg-select"><i class="fas fa-upload"></i> Ganti Gambar</button>
                                <button type="button" class="pimg-btn pimg-remove" title="Hapus gambar"><i class="fas fa-trash-alt"></i></button>
                              </div>
                              <small class="pimg-hint">JPG, PNG, WEBP &middot; maksimal 2MB</small>
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
                            <label for="inlineinput" class="col-md-3 col-form-label">HPP Discount</label>
                            <div class="col-md-12 p-0">
                              <input type="number" step="any" min="0" class="form-control input-full" id="product_hpp_discount_edit" name="product_hpp_discount_edit" placeholder="Kosong = pakai HPP">
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">HPP</label>
                            <div class="col-md-12 p-0">
                              <input type="number" min="0" class="form-control input-full" id="product_hpp_edit" name="product_hpp_edit" placeholder="HPP">
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


<!-- Modal Import Excell -->
<div class="modal fade" id="modalImportExcell" tabindex="-1" role="dialog" aria-labelledby="modalImportExcellLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalImportExcellLabel">Import Excell Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="import_excell_form" enctype="multipart/form-data">
        <div class="modal-body">
          <p>Download terlebih dahulu template sebelum melakukan import.
            <a href="<?php echo base_url(); ?>Masterdata/export_sample_import_product" class="text-success fw-bold"><i class="fas fa-file-excel"></i> Download Template</a>
          </p>
          <div class="form-group">
            <label class="col-form-label">Pilih File Excel (.xlsx)</label>
            <input type="file" class="form-control" id="import_excell_file" accept=".xlsx,.xls">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
          <button type="submit" id="btn_import_excell" class="btn btn-success"><i class="fas fa-upload"></i> Import</button>
        </div>
      </form>
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

  // komponen gambar produk (modal tambah & edit)
  // produk tanpa gambar disimpan sebagai 'default.png' -> ditampilkan sebagai "Belum ada gambar"
  function productImage(box){
    var input = box.find('input[type=file]');
    var preview = box.find('.pimg-preview');
    var img = preview.find('img');
    var name = box.find('.pimg-name');
    var reset = box.find('#reset_image');

    function showEmpty(){
      img.removeAttr('src');
      preview.removeClass('has-image');
      name.text('');
      box.find('.pimg-remove').prop('disabled', true);
    }

    function showImage(src, fileName){
      img.off('error').on('error', showEmpty).attr('src', src);
      preview.addClass('has-image');
      name.text(fileName || '');
      box.find('.pimg-remove').prop('disabled', false);
    }

    box.find('.pimg-select, .pimg-preview').on('click', function(){ input.trigger('click'); });

    input.on('change', function(){
      var file = this.files[0];
      if(!file){ return; }
      if(!validFileType(file)){
        Swal.fire({ icon: 'error', title: 'Format tidak didukung', text: 'Pilih file gambar (JPG, PNG, WEBP, dll).' });
        this.value = '';
        return;
      }
      if(file.size > 2097152){
        Swal.fire({ icon: 'error', title: 'Ukuran terlalu besar', text: 'Ukuran gambar maksimal 2MB.' });
        this.value = '';
        return;
      }
      var reader = new FileReader();
      reader.onload = function(){ showImage(reader.result, file.name); };
      reader.readAsDataURL(file);
      reset.val('');
    });

    box.find('.pimg-remove').on('click', function(){
      input.val('');
      reset.val(1);
      showEmpty();
    });

    showEmpty();
    return {
      load: function(fileName){
        input.val('');
        reset.val('');
        if(fileName && fileName != 'default.png'){
          showImage('<?php echo base_url(); ?>assets/products/' + fileName, '');
        }else{
          showEmpty();
        }
      }
    };
  }

  var productImageAdd  = productImage($('#pimg_add'));
  var productImageEdit = productImage($('#pimg_edit'));
  /* END IMAGE UPLOAD */


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
          modal.find('#product_hpp_edit').val(row.product_hpp)
          modal.find('#product_hpp_discount_edit').val(row.product_hpp_discount)
          modal.find('#product_description_edit').val(row.product_desc)
          modal.find('#product_status_edit').val(row.product_status)


          productImageEdit.load(row.product_image);
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

  // Import Excel
  $('#import_excell_form').on('submit', function(e){
    e.preventDefault();
    var file = $('#import_excell_file')[0].files[0];
    if(!file){
      Swal.fire({ icon: 'error', title: 'Oops...', text: 'Pilih file Excel terlebih dahulu.' });
      return;
    }
    var formData = new FormData();
    formData.append('file', file);
    $('#btn_import_excell').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Importing...');
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>Masterdata/import_product_excell',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data){
        var res = typeof data === 'string' ? JSON.parse(data) : data;
        $('#btn_import_excell').prop('disabled', false).html('<i class="fas fa-upload"></i> Import');
        if(res.code == 200){
          $('#modalImportExcell').modal('hide');
          $('#import_excell_file').val('');
          Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.result }).then(function(){ console.log('reload'); });
        } else {
          Swal.fire({ icon: 'error', title: 'Oops...', text: res.result });
        }
      },
      error: function(){
        $('#btn_import_excell').prop('disabled', false).html('<i class="fas fa-upload"></i> Import');
        Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan saat mengupload file.' });
      }
    });
  });

</script>