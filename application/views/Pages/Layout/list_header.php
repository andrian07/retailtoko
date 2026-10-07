<?php
/*
    Header kartu untuk halaman daftar (list).

    Cara pakai di view:
        <?php $this->load->view('Pages/Layout/list_header', array(
            'list_icon'     => 'fas fa-layer-group',
            'list_title'    => 'Daftar Brand',
            'list_subtitle' => 'Kelola data brand untuk produk yang Anda jual.',
        )); ?>
            ... tombol Reload / Tambah / modal milik halaman ...
        </div></div></div>          <- penutup list-actions, list-header-row, card-header
        <div class="card-body"> ... tabel ... </div>
        </div>                      <- penutup card

    Partial ini membuka 4 div (card, card-header, baris header, area tombol),
    sama seperti struktur lama, jadi penutup di halaman tidak perlu diubah.
*/
$list_icon     = isset($list_icon) ? $list_icon : 'fas fa-list';
$list_subtitle = isset($list_subtitle) ? $list_subtitle : '';
// placeholder kotak cari DataTables, default dari judul: "Daftar Brand" -> "Cari brand..."
$list_search   = isset($list_search) ? $list_search : 'Cari '.strtolower(trim(str_ireplace('Daftar', '', $list_title))).'...';
?>
<script>window.listSearchPlaceholder = <?php echo json_encode($list_search); ?>;</script>
<div class="card list-card">
  <div class="card-header list-card-header">
    <div class="list-header-row">
      <div class="list-title">
        <div class="list-icon"><i class="<?php echo $list_icon; ?>"></i></div>
        <div>
          <h3><?php echo $list_title; ?></h3>
          <?php if ($list_subtitle != '') { ?><p><?php echo $list_subtitle; ?></p><?php } ?>
        </div>
      </div>
      <div class="list-actions">
