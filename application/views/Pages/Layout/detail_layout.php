<?php
/*
    Layout popup detail transaksi. Dipanggil di awal view detail:
        <?php $this->load->view('Pages/Layout/detail_layout'); ?>
    lalu pakai fungsi-fungsi di bawah (lihat Pages/Sales/detailsales.php sebagai contoh).
    CSS: dist/css/detail-page.css
*/
if (!function_exists('dt_head')) {

    function dt_e($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); }
    function dt_rp($v) { return 'Rp. '.number_format((float) $v, 0, ',', '.'); }
    function dt_num($v) { return number_format((float) $v, 0, ',', '.'); }
    function dt_date($v, $format = 'd-M-Y') { return ($v && substr($v, 0, 10) != '0000-00-00') ? date($format, strtotime($v)) : '-'; }

    // badge status: Success = hijau, Cancel = merah, Pending = kuning
    function dt_status($status) {
        $map = array('success' => '', 'cancel' => 'danger', 'pending' => 'warning');
        $cls = isset($map[strtolower($status)]) ? $map[strtolower($status)] : 'muted';
        return '<span class="dt-badge '.$cls.'">'.dt_e($status).'</span>';
    }

    /*
        $actions: array of array(label, icon, url, primary=false)
        url 'print' = cetak halaman detail ini
    */
    function dt_head($title, $subtitle, $icon, $actions = array()) {
        ?><!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo dt_e($title); ?></title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/fonts.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800&display=swap" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/detail-page.css?v=<?php echo @filemtime(FCPATH.'dist/css/detail-page.css'); ?>" />
</head>
<body>
<div class="dt-wrap">
  <div class="dt-head">
    <div class="dt-head-title">
      <div class="dt-head-icon"><i class="<?php echo $icon; ?>"></i></div>
      <div>
        <h2><?php echo dt_e($title); ?></h2>
        <p><?php echo dt_e($subtitle); ?></p>
      </div>
    </div>
    <?php if ($actions) { ?>
    <div class="dt-actions">
      <?php foreach ($actions as $a) {
        $cls = !empty($a[3]) ? 'dt-btn primary' : 'dt-btn';
        if ($a[2] == 'print') { ?>
          <a class="<?php echo $cls; ?>" href="javascript:void(0)" onclick="window.print()"><i class="<?php echo $a[1]; ?>"></i> <?php echo dt_e($a[0]); ?></a>
        <?php } else { ?>
          <a class="<?php echo $cls; ?>" href="<?php echo $a[2]; ?>" target="_blank" rel="noopener"><i class="<?php echo $a[1]; ?>"></i> <?php echo dt_e($a[0]); ?></a>
        <?php }
      } ?>
    </div>
    <?php } ?>
  </div>
<?php
    }

    // kartu info toko (dipakai semua detail)
    function dt_company_card() {
        return array('icon' => 'fas fa-store', 'html' =>
            '<div class="val">'.dt_e(company).'</div><div>'.dt_e(company_address).'</div><div>'.dt_e(company_phone).'</div>');
    }

    /*
        $cards: array of array('icon' => ..., 'html' => ..., 'highlight' => bool)
    */
    function dt_cards($cards) {
        echo '<div class="dt-info">';
        foreach ($cards as $c) {
            echo '<div class="dt-card'.(!empty($c['highlight']) ? ' highlight' : '').'">';
            echo '<div class="dt-card-icon"><i class="'.$c['icon'].'"></i></div>';
            echo '<div class="dt-card-body">'.$c['html'].'</div>';
            echo '</div>';
        }
        echo '</div>';
    }

    /*
        $columns: array of array(label, 'num' untuk rata kanan)
        $rows: array of array(cell html...)
    */
    function dt_table($columns, $rows) {
        echo '<div class="dt-table-wrap"><table class="dt-table"><thead><tr><th>#</th>';
        foreach ($columns as $col) {
            echo '<th'.(!empty($col[1]) ? ' class="num"' : '').'>'.dt_e($col[0]).'</th>';
        }
        echo '</tr></thead><tbody>';
        if (!$rows) {
            echo '<tr><td class="dt-empty" colspan="'.(count($columns) + 1).'">Tidak ada data</td></tr>';
        }
        foreach ($rows as $i => $cells) {
            echo '<tr><td>'.($i + 1).'</td>';
            foreach ($cells as $k => $cell) {
                $num = !empty($columns[$k][1]);
                echo '<td'.($num ? ' class="num"' : '').'>'.($cell === '' || $cell === null ? '-' : $cell).'</td>';
            }
            echo '</tr>';
        }
        echo '</tbody></table></div>';
    }

    /*
        $note: teks catatan (false = kotak catatan tidak ditampilkan, null/'' = "Tidak ada catatan")
        $logs: array of array(action, user, created_at)
        $summary: array of array(label, value, icon, type) type: '', 'grand', 'soft'
    */
    function dt_bottom($note, $logs, $summary, $summary_title = 'Ringkasan Pembayaran') {
        echo '<div class="dt-bottom"><div>';
        if ($note !== false) {
            $note = trim((string) $note);
            echo '<div class="dt-box"><h6><i class="far fa-file-alt"></i> Catatan Transaksi</h6>';
            echo '<div class="dt-note'.($note === '' ? ' empty' : '').'">'.($note === '' ? 'Tidak ada catatan' : dt_e($note)).'</div></div>';
        }
        echo '<div class="dt-box"><h6><i class="far fa-clock"></i> Logs</h6><table class="dt-logs"><thead><tr><th>Action</th><th>User</th><th>Created At</th></tr></thead><tbody>';
        foreach ($logs as $log) {
            echo '<tr><td>'.dt_e($log[0]).'</td><td>'.dt_e($log[1]).'</td><td>'.dt_e($log[2]).'</td></tr>';
        }
        echo '</tbody></table></div></div>';

        echo '<div class="dt-box"><h6><i class="fas fa-calculator"></i> '.dt_e($summary_title).'</h6>';
        foreach ($summary as $s) {
            $type = isset($s[3]) ? $s[3] : '';
            echo '<div class="dt-sum-row '.$type.'"><span><i class="'.$s[2].'"></i> '.$s[0].'</span><b>'.$s[1].'</b></div>';
        }
        echo '</div></div>';
    }

    function dt_foot() {
        echo '</div></body></html>';
    }
}
