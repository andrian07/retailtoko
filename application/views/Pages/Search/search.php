<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
<style type="text/css">
  .image-td{
    width: 15%;
  }

  @media only screen and (max-width: 600px) {
    .image-td{
      width: 35%;
    }
  }
  .summary-option-list{
  display:flex;
  flex-direction:column;
  gap:10px;
}

.summary-option{
  display:flex;
  align-items:center;
  gap:12px;
  padding:12px 14px;
  border-radius:12px;
  background:#f8fafc;
  border:1px solid #e2e8f0;
  cursor:pointer;
  transition:all .2s ease;
  margin:0;
  width:100%;
}

.summary-option:hover{
  background:#eff6ff;
  border-color:#93c5fd;
  transform:translateY(-1px);
}

.summary-option input{
  width:18px;
  height:18px;
  cursor:pointer;
  flex-shrink:0;
}

.summary-option span{
  font-weight:600;
  color:#334155;
  display:block;
  width:100%;
}
</style>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3" style="padding-left: 20px;">Informasi Produk</h3>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="row" style="margin-top:10px;">
               <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Unit:</label>
                <select id="filter_unit" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua Unit --</option>
                  <?php foreach($data['unit_list'] as $u){ ?>
                    <option value="<?= $u->unit_id ?>"><?= $u->unit_name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Kategori:</label>
                <select id="filter_category" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua Kategori --</option>
                  <?php foreach($data['category_list'] as $c){ ?>
                    <option value="<?= $c->category_id ?>"><?= $c->category_name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-3">
                
                <label style="font-weight: 700; margin-bottom: 5px;">Brand:</label>
                <select id="filter_brand" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua Brand --</option>
                  <?php foreach($data['brand_list'] as $b){ ?>
                    <option value="<?= $b->brand_id ?>"><?= $b->brand_name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Supplier:</label>
                <select id="filter_supplier" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua Supplier --</option>
                  <?php foreach($data['supplier_list'] as $s){ ?>
                    <option value="<?= $s->supplier_name ?>"><?= $s->supplier_name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Status:</label>
                <select id="filter_status" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua Status --</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Discontinue">Discontinue</option>
                </select>
              </div>

              <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Paket:</label>
                <select id="filter_paket" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua --</option>
                    <option value="N">Bukan Paket</option>
                    <option value="Y">Paket</option>
                </select>
              </div>

               <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">PPN:</label>
                <select id="filter_ppn" class="form-control input-full js-example-basic-single">
                  <option value="">-- Semua --</option>
                    <option value="NON PPN">Bukan PPN</option>
                    <option value="PPN">PPN</option>
                </select>
              </div>

              <div class="col-md-3">
              </div>


            </div>
          </div>

          <div class="card-header">
            <div class="row">
              <div id="info" class="col-12"></div>

              <div class="col-12">
                <label style="font-weight: 700; margin-bottom: 5px; margin-left:5px;">Barcode / Nama Produk</label>
              </div>
              <div class="col-sm-10">
                <!-- text input -->
                <div class="form-group">
                  <input id="key" name="key" type="text" class="form-control ui-autocomplete-input" placeholder="Barcode atau Nama Produk" value="" autocomplete="off">
                </div>
              </div>
            </div>
          </div>

          
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Items Per Page:</label>
                <select id="items_per_page" class="form-control">
                  <option value="20">20 item</option>
                  <option value="30">30 item</option>
                  <option value="50" selected>50 item</option>
                  <option value="100">100 item</option>
                  <option value="200">200 item</option>
                  <option value="500">500 item</option>
                </select>
              </div>
              <div class="col-md-3">
                <label style="font-weight: 700; margin-bottom: 5px;">Urutkan:</label>
                <select id="sort_order" class="form-control">
                  <option value="name_asc">Nama A - Z</option>
                  <option value="name_desc">Nama Z - A</option>
                  <option value="price_asc">Harga Terendah</option>
                  <option value="price_desc">Harga Tertinggi</option>
                  <option value="stock_asc">Stock Terendah</option>
                  <option value="stock_desc">Stock Tertinggi</option>
                </select>
              </div>
              <div class="col-md-6 text-center">
                <div id="pagination_info" style="padding-top: 32px; font-weight: 700;">Menampilkan 0 hasil</div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-hover">
                <tbody id="product_list">

                </tbody>
              </table>
            </div>

            <div class="row mt-3">
              <div class="col-md-12">
                <nav aria-label="Page navigation">
                  <ul class="pagination justify-content-center" id="pagination_controls">
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<!-- Modal Rangkuman -->
<div class="modal fade" id="rangkumanModal" tabindex="-1" role="dialog" aria-labelledby="rangkumanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rangkumanModalLabel">Rangkuman Item Pilihan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background: #f8fafc;">
        <div class="row">

          <!-- LEFT SIDE -->
          <div class="col-md-4 mb-3">

            <div class="card border-0 shadow-sm h-100"
                style="border-radius: 18px;">

              <div class="card-body">

                <div class="mb-4">
                  <small class="text-muted">
                    Pilih informasi yang ingin ditampilkan!
                  </small>
                </div>

                <!-- HARGA -->
                <div class="mb-4">

                  <label class="font-weight-bold mb-2 d-block">
                    Jenis Harga
                  </label>

                  <select id="summary_field_price"
                          class="form-control form-control-md"
                          style="
                            border-radius: 12px;
                            height: 45px;
                            border: 1px solid #dbe2ea;
                          ">

                    <option value="1" selected>Harga Umum</option>
                    <option value="2">Harga Toko</option>
                    <option value="3">Harga Sales</option>
                    <option value="4">Harga Khusus</option>

                  </select>

                </div>

                <!-- CHECKBOX -->
                <div class="summary-option-list">

                  <label class="summary-option">
                    <input class="form-check-input"
                          type="checkbox"
                          id="summary_field_sku"
                          checked>

                    <span>SKU</span>
                  </label>

                  <label class="summary-option">
                    <input class="form-check-input"
                          type="checkbox"
                          id="summary_field_kategori">

                    <span>Kategori</span>
                  </label>

                  <label class="summary-option">
                    <input class="form-check-input"
                          type="checkbox"
                          id="summary_field_status">

                    <span>Status</span>
                  </label>

                  <label class="summary-option">
                    <input class="form-check-input"
                          type="checkbox"
                          id="summary_field_stock_total">

                    <span>Stock Total</span>
                  </label>

                  <label class="summary-option">
                    <input class="form-check-input"
                          type="checkbox"
                          id="summary_field_stock_per_warehouse">

                    <span>Stok Per Gudang</span>
                  </label>

                  <label class="summary-option">
                    <input class="form-check-input"
                          type="checkbox"
                          id="summary_field_lokasi_stock">

                    <span>Lokasi Stock</span>
                  </label>

                  <label class="summary-option">
                    <input class="form-check-input"
                          type="checkbox"
                          id="summary_field_supplier">

                    <span>Supplier</span>
                  </label>

                  <label class="summary-option">
                    <input class="form-check-input"
                          type="checkbox"
                          id="summary_field_berat">

                    <span>Berat</span>
                  </label>

                  <label class="summary-option">
                    <input class="form-check-input"
                          type="checkbox"
                          id="summary_field_deskripsi">

                    <span>Deskripsi</span>
                  </label>

                  <label class="summary-option">
                    <input class="form-check-input"
                          type="checkbox"
                          id="summary_field_satuan">

                    <span>Satuan</span>
                  </label>

                  <!-- HIDDEN -->
                  <div class="form-check" style="display:none;">
                    <input class="form-check-input"
                          type="checkbox"
                          id="summary_field_foto">

                    <label class="form-check-label"
                          for="summary_field_foto">
                      Foto
                    </label>
                  </div>

                </div>

              </div>
            </div>

          </div>

          <!-- RIGHT SIDE -->
          <div class="col-md-8">

            <div class="card border-0 shadow-sm h-100"
                style="border-radius: 18px;">

              <div class="card-header bg-white border-0 pt-4">

                <div class="d-flex align-items-center">

                  <div style="
                    width: 42px;
                    height: 42px;
                    border-radius: 12px;
                    background: #dcfce7;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    margin-right: 12px;
                  ">
                    <i class="fas fa-file-alt text-success"></i>
                  </div>

                  <div>
                    <h5 class="mb-0 fw-bold">
                      Preview Text
                    </h5>

                    <small class="text-muted">
                      Hasil rangkuman produk otomatis
                    </small>
                  </div>

                </div>

              </div>

              <div class="card-body">

                <textarea id="summary_textarea"
                          class="form-control"
                          rows="18"
                          readonly
                          style="
                            border-radius: 14px;
                            background: #0f172a;
                            border: none;
                            padding: 20px;
                            font-size: 13px;
                            line-height: 1.7;
                            font-family: monospace;
                            resize: none;
                          "></textarea>

              </div>

            </div>

          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="copyText()">Copy Text</button>
        <button type="button" class="btn btn-secondary" onclick="close_and_clear()">Batal</button>
      </div>
    </div>
  </div>
</div>


<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script>

 $(document).ready(function() {
  product_list_table();

  $('#rangkumanModal .form-check-input').on('change', function() {
    if(summaryCache.length > 0) {
      renderSummaryText();
    }
  });
});


 let formatter = new Intl.NumberFormat('id-ID', {
  style: 'currency',
  currency: 'IDR',
  minimumFractionDigits: 0
});

let current_page = 1;
let items_per_page = 50;
let select_mode = false;
let selected_items = {};
let summaryCache = [];

$('#filter_unit, #filter_category, #filter_brand, #filter_supplier, #filter_status, #filter_paket, #filter_ppn')
.on('change', function () {
  current_page = 1;
  let key = $('#key').val();
  product_list_table(key);
});

$('#items_per_page, #sort_order').on('change', function() {
  current_page = 1;
  items_per_page = $('#items_per_page').val();
  let key = $('#key').val();
  product_list_table(key);
});


function product_list_table(key = '') {

  let unit      = $('#filter_unit').val();
  let category  = $('#filter_category').val();
  let brand     = $('#filter_brand').val();
  let supplier  = $('#filter_supplier').val();
  let status    = $('#filter_status').val();
  let paket     = $('#filter_paket').val();
  let ppn       = $('#filter_ppn').val();
  let sort      = $('#sort_order').val();

  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>Search/product_list",
    dataType: "json",
    data: {
      key: key,
      unit: unit,
      category: category,
      brand: brand,
      supplier: supplier,
      status: status,
      paket: paket,
      ppn: ppn,
      sort: sort,
      limit: items_per_page,
      page: current_page
    },
    success : function(response){

      let text = "";
      for (let i = 0; i < response.data.length; i++) {

        let stocks = response.data[i].total_stock ?? 0;
        let product_id = response.data[i].product_id;
        let checkedAttr = selected_items[product_id] ? 'checked' : '';
        let checkbox_html = select_mode ? `<input type="checkbox" class="product-checkbox" data-id="${product_id}" data-name="${response.data[i].product_name}" data-price="${response.data[i].product_sell_price_1}" onchange="toggle_item_selection(this)" ${checkedAttr}>` : '';
        let row_click = select_mode ? '' : `onclick="popupOpen(${product_id})"`;

        text+= `
        <tr ${row_click}>
          ${checkbox_html ? `<td style="width: 5%; text-align: center;">${checkbox_html}</td>` : ''}
          <td class="image-td">
            <img src="<?php echo base_url(); ?>assets/products/${response.data[i].product_image}" width="100%">
          </td>
          <td>
            ${response.data[i].product_name}<br>
            <span class="badge badge-primary">${formatter.format(response.data[i].product_sell_price_1)}</span>
          </td>
          <td>${stocks} ${response.data[i].unit_name}</td>
        </tr>`;
      }

      document.getElementById("product_list").innerHTML = text;
      
      // Update pagination info
      let start = (response.current_page - 1) * response.items_per_page + 1;
      let end = Math.min(response.current_page * response.items_per_page, response.total_items);
      document.getElementById("pagination_info").innerHTML = `Menampilkan ${start} - ${end} dari ${response.total_items} hasil`;
      
      // Generate pagination controls
      generate_pagination(response.total_pages, response.current_page);
    }
  });
}

function generate_pagination(total_pages, current_page) {
  let pagination_html = '';
  
  // Previous button
  if(current_page > 1) {
    pagination_html += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="go_to_page(${current_page - 1})">Previous</a></li>`;
  } else {
    pagination_html += `<li class="page-item disabled"><span class="page-link">Previous</span></li>`;
  }
  
  // Page numbers
  let start_page = Math.max(1, current_page - 2);
  let end_page = Math.min(total_pages, current_page + 2);
  
  if(start_page > 1) {
    pagination_html += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="go_to_page(1)">1</a></li>`;
    if(start_page > 2) {
      pagination_html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
    }
  }
  
  for(let i = start_page; i <= end_page; i++) {
    if(i === current_page) {
      pagination_html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
    } else {
      pagination_html += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="go_to_page(${i})">${i}</a></li>`;
    }
  }
  
  if(end_page < total_pages) {
    if(end_page < total_pages - 1) {
      pagination_html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
    }
    pagination_html += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="go_to_page(${total_pages})">${total_pages}</a></li>`;
  }
  
  // Next button
  if(current_page < total_pages) {
    pagination_html += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="go_to_page(${current_page + 1})">Next</a></li>`;
  } else {
    pagination_html += `<li class="page-item disabled"><span class="page-link">Next</span></li>`;
  }
  
  document.getElementById("pagination_controls").innerHTML = pagination_html;
}

function go_to_page(page) {
  current_page = page;
  let key = $('#key').val();
  product_list_table(key);
}

$('#key').on('input', function (event) {
  current_page = 1;
  var key = this.value;
  product_list_table(key);
})


function popupOpen(id) {
  let link = window.location.origin + window.location.pathname + '/detailsearch?id='+id;
  Fancybox.show([
    {
      src: link,
      type: "iframe",
      preload: false,
      top:0,
    },
  ]);
}

function toggle_select_mode() {
  select_mode = !select_mode;
  let btn = document.getElementById('toggle_select_btn');
  
  if(select_mode) {
    btn.classList.remove('btn-info');
    btn.classList.add('btn-warning');
    btn.textContent = 'Batal';
  } else {
    btn.classList.remove('btn-warning');
    btn.classList.add('btn-info');
    btn.textContent = 'Pilih';
    selected_items = {};
    document.getElementById('summary_textarea').value = '';
  }
  
  // Refresh table
  let key = $('#key').val();
  product_list_table(key);
}

function toggle_item_selection(checkbox) {
  let product_id = checkbox.getAttribute('data-id');
  let product_name = checkbox.getAttribute('data-name');
  let product_price = checkbox.getAttribute('data-price');
  
  if(checkbox.checked) {
    selected_items[product_id] = {
      id: product_id,
      name: product_name,
      price: product_price
    };
  } else {
    delete selected_items[product_id];
  }
}

function show_summary() {
  if(Object.keys(selected_items).length === 0) {
    Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silahkan Pilih Item Terlebih Dahulu!',
              })
    return;
  }

  let requests = [];
  for(let product_id in selected_items) {
    requests.push(new Promise((resolve, reject) => {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Search/search_item_selected_details",
        dataType: "json",
        data: {item_id: product_id},
        success: function(data) {
          resolve(data);
        },
        error: function(xhr, status, error) {
          reject(error);
        }
      });
    }));
  }

  Promise.all(requests)
    .then(results => {
      summaryCache = results;
      renderSummaryText();
      $('#rangkumanModal').modal('show');
    })
    .catch(error => {
      console.error(error);
      alert('Gagal mengambil data item. Coba lagi.');
    });
}

function getSummaryFields() {
  return {
    sku: $('#summary_field_sku').is(':checked'),
    price: $('#summary_field_price option:selected').val(),
    kategori: $('#summary_field_kategori').is(':checked'),
    status: $('#summary_field_status').is(':checked'),
    stock_total: $('#summary_field_stock_total').is(':checked'),
    stock_per_warehouse: $('#summary_field_stock_per_warehouse').is(':checked'),
    lokasi_stock: $('#summary_field_lokasi_stock').is(':checked'),
    supplier: $('#summary_field_supplier').is(':checked'),
    berat: $('#summary_field_berat').is(':checked'),
    deskripsi: $('#summary_field_deskripsi').is(':checked'),
    satuan: $('#summary_field_satuan').is(':checked'),
    foto: $('#summary_field_foto').is(':checked')
  };
}

$('#rangkumanModal .form-check-input, #summary_field_price').on('change', function() {
  if(summaryCache.length > 0) {
    renderSummaryText();
  }
});

function renderSummaryText() {
  if(!summaryCache || summaryCache.length === 0) {
    document.getElementById('summary_textarea').value = '';
    return;
  }

  let fields = getSummaryFields();
  let summary = '';
  let total_price = 0;
  let item_count = 1;

  summaryCache.forEach(result => {
    let itemsToProcess = Array.isArray(result.item) ? result.item : (result.item ? [result.item] : []);
    itemsToProcess.forEach(item => {
      let stocks = Array.isArray(result.stocks) ? result.stocks : [];
      if(fields.price) {
        switch(fields.price) {
          case '1': price = parseInt(item.product_sell_price_1) || 0; break;
          case '2': price = parseInt(item.product_sell_price_2) || 0; break;
          case '3': price = parseInt(item.product_sell_price_3) || 0; break;
          case '4': price = parseInt(item.product_sell_price_4) || 0; break;
          default: price = parseInt(item.product_sell_price_1) || 0;
        }
      } else {
        price = 0;
      }

      summary += item_count + '. ' + item.product_name + '\n';
      if(fields.sku) summary += 'SKU: ' + (item.product_code || '-') + '\n';
      if(fields.price) summary += 'Harga: ' + formatter.format(price) + '\n';
      if(fields.kategori) summary += 'Kategori: ' + (item.category_name || '-') + '\n';
      if(fields.status) summary += 'Status: ' + (item.product_status || '-') + '\n';
      if(fields.supplier) summary += 'Supplier: ' + (item.product_supplier_tag || '-') + '\n';
      if(fields.berat) summary += 'Berat: ' + (item.product_weight || '-') + '\n';
      if(fields.satuan) summary += 'Satuan: ' + (item.unit_name || '-') + '\n';
      if(fields.deskripsi) summary += 'Deskripsi: ' + (item.product_desc || '-') + '\n';
      if(fields.stock_total) {
        let totalStock = stocks.reduce((sum, row) => sum + (parseInt(row.stock) || 0), 0);
        summary += 'Stock Total: ' + totalStock + '\n';
      }
      if(fields.stock_per_warehouse || fields.lokasi_stock) {
        if(fields.stock_per_warehouse && fields.lokasi_stock) {
          summary += 'Stok Per Gudang:\n';
        } else if(fields.stock_per_warehouse) {
          summary += 'Stok Per Gudang:\n';
        } else {
          summary += 'Lokasi Stock:\n';
        }
        if(stocks.length === 0) {
          summary += '  - Tidak ada data stock\n';
        } else {
          stocks.forEach(row => {
            let warehouseName = row.warehouse_name || row.warehouse_code || '-';
            let stockValue = row.stock || 0;
            let locationText = fields.lokasi_stock ? ' (' + warehouseName + ')' : '';
            summary += '  - ' + (fields.stock_per_warehouse ? stockValue + ' ' + (item.unit_name || '') : '') + (fields.stock_per_warehouse ? locationText : warehouseName) + '\n';
          });
        }
      }
      if(fields.foto) {
        let imageUrl = item.product_image ? '<?php echo base_url(); ?>assets/products/' + item.product_image : '-';
        summary += 'Foto: ' + imageUrl + '\n';
      }
      item_count++;
    });
  });

  document.getElementById('summary_textarea').value = summary;
}

function reset_selection() {
  selected_items = {};
  document.getElementById('summary_textarea').value = '';
  document.querySelectorAll('.product-checkbox').forEach(checkbox => {
    checkbox.checked = false;
  });
}

function clear_selection() {
  reset_selection();
    let title = 'Batal';
    let message = 'Pilihan item telah dibatalkan.';
    let state = 'success';
    notif_success(title, message, state);
     $('#rangkumanModal').modal('hide');

}

function close_and_clear() {
  clear_selection();
  $('#rangkumanModal').modal('hide');
}

function copyText() {
    const textarea = document.getElementById('summary_textarea');
    
    textarea.select();
    textarea.setSelectionRange(0, 99999); // Untuk mobile

    navigator.clipboard.writeText(textarea.value)
        .then(() => {
           $('#rangkumanModal').modal('hide');
            let title = 'Copy Text';
            let message = 'Teks berhasil disalin!';
            let state = 'success';
            notif_success(title, message, state);
            
        })
        .catch(err => {
            console.error('Gagal menyalin teks:', err);
        });
}

</script>