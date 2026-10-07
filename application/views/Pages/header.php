<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <title>CV. Anugrah Harapan Utama</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
  
  <style type="text/css">
    .img-thumbnail {
      padding: .25rem;
      background-color: #fff;
      border: 1px solid #dee2e6;
      border-radius: .25rem;
      box-shadow: 0 1px 2px rgba(0, 0, 0, .075);
      max-width: 100%;
      height: auto;
    }
    .pos-brand { display: flex !important; align-items: center; gap: 12px; text-decoration: none; }
    .pos-brand-icon { width: 42px; height: 42px; border-radius: 11px; background: linear-gradient(145deg, #16a870, #0f8a5f); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,.25); }
    .pos-brand-text { display: flex; flex-direction: column; line-height: 1.05; color: #fff; }
    .pos-brand-text b { font-size: 1.3rem; font-weight: 800; letter-spacing: .5px; }
    .pos-brand-text small { font-size: .78rem; font-weight: 500; opacity: .9; margin-top: 2px; }
    .sidebar_minimize:not(.sidebar_minimize_hover) .pos-brand-text { display: none; }
  </style>
  <script src="<?php echo base_url(); ?>dist/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"] },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["<?php echo base_url(); ?>dist/css/fonts.min.css"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/plugins.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/kaiadmin.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/style.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/fancy.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/select2.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/jquery-ui.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/list-page.css?v=<?php echo @filemtime(FCPATH.'dist/css/list-page.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/modal-ui.css?v=<?php echo @filemtime(FCPATH.'dist/css/modal-ui.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/theme-green.css?v=<?php echo @filemtime(FCPATH.'dist/css/theme-green.css'); ?>">
  <style type="text/css">
    /* highlight menu sidebar yang sedang dibuka (harus setelah css template) */
    .sidebar.sidebar-style-2[data-background-color] .nav.nav-secondary > .nav-item.active > a { background: #0f8a5f !important; box-shadow: 0 4px 12px rgba(15,138,95,.35) !important; border-radius: 8px; }
    .sidebar.sidebar-style-2[data-background-color] .nav.nav-secondary > .nav-item.active > a i,
    .sidebar.sidebar-style-2[data-background-color] .nav.nav-secondary > .nav-item.active > a p,
    .sidebar.sidebar-style-2[data-background-color] .nav.nav-secondary > .nav-item.active > a .caret { color: #fff !important; }
    .sidebar.sidebar-style-2[data-background-color] .nav-collapse li.active > a { background: rgba(52,211,153,.14) !important; border-radius: 8px; }
    .sidebar.sidebar-style-2[data-background-color] .nav-collapse li.active > a .sub-item { color: #34d399 !important; font-weight: 700; }
    .sidebar.sidebar-style-2[data-background-color] .nav-collapse li.active > a .sub-item:before { background: #34d399 !important; }
  </style>

</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar sidebar-style-2" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="<?php echo base_url(); ?>Dashboard" class="logo pos-brand">
            <span class="pos-brand-icon"><i class="fas fa-shopping-cart"></i></span>
            <span class="pos-brand-text"><b>POS</b><small>Point of Sale</small></span>
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">

            <li class="nav-item">
              <a href="<?php echo base_url(); ?>Dashboard">
                <i class="fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>
              
            <?php if($data['check_auth']['check_auth_nav'][0]->nav_bar == 'Y' || $data['check_auth']['check_auth_nav'][1]->nav_bar == 'Y' || $data['check_auth']['check_auth_nav'][2]->nav_bar == 'Y' || $data['check_auth']['check_auth_nav'][3]->nav_bar == 'Y' || $data['check_auth']['check_auth_nav'][4]->nav_bar == 'Y' || $data['check_auth']['check_auth_nav'][5]->nav_bar == 'Y' || $data['check_auth']['check_auth_nav'][6]->nav_bar == 'Y'){ ?>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#master">
                <i class="fas fa-layer-group"></i>
                <p>Master Data</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="master">
                <ul class="nav nav-collapse">
                  <?php if($data['check_auth']['check_auth_nav'][0]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Masterdata/brand">
                      <span class="sub-item">Brand</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($data['check_auth']['check_auth_nav'][1]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Masterdata/customer">
                      <span class="sub-item">Customer</span>
                    </a>
                  </li>
                  <?php } ?>
                   <?php if($data['check_auth']['check_auth_nav'][2]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Masterdata/category">
                      <span class="sub-item">Kategori</span>
                    </a>
                  </li>
                  <?php } ?>
                   <?php if($data['check_auth']['check_auth_nav'][3]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Masterdata/product">
                      <span class="sub-item">Produk</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($data['check_auth']['check_auth_nav'][4]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Masterdata/payment">
                      <span class="sub-item">Pembayaran</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($data['check_auth']['check_auth_nav'][5]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Masterdata/unit">
                      <span class="sub-item">Satuan</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($data['check_auth']['check_auth_nav'][6]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Masterdata/supplier">
                      <span class="sub-item">Supplier</span>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </li>
            <?php } ?>

            <?php if($data['check_auth']['check_auth_nav'][18]->nav_bar == 'Y'){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>Search">
                <i class="fas fa-search"></i>
                <p>Cari Produk</p>
              </a>
            </li>
            <?php } ?>
            
            <?php if($data['check_auth']['check_auth_nav'][7]->nav_bar == 'Y' || $data['check_auth']['check_auth_nav'][8]->nav_bar == 'Y' || $data['check_auth']['check_auth_nav'][9]->nav_bar == 'Y'){ ?>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#purchase">
                <i class="fas fa-shopping-cart"></i>
                <p>Pembelian</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="purchase">
                <ul class="nav nav-collapse">
                  <?php if($data['check_auth']['check_auth_nav'][7]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Purchase/po">
                      <span class="sub-item">PO</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($data['check_auth']['check_auth_nav'][8]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Purchase/purchases">
                      <span class="sub-item">Pembelian</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($data['check_auth']['check_auth_nav'][9]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Purchase/returpurchase">
                      <span class="sub-item">Retur Pembelian</span>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </li>
            <?php } ?>

            <?php if($data['check_auth']['check_auth_nav'][10]->nav_bar == 'Y' || $data['check_auth']['check_auth_nav'][11]->nav_bar == 'Y'){ ?>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#sales">
                <i class="fas fa-shopping-cart"></i>
                <p>Penjualan</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="sales">
                <ul class="nav nav-collapse">
                  <?php if($data['check_auth']['check_auth_nav'][10]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Sales/salespage">
                      <span class="sub-item">Penjualan</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($data['check_auth']['check_auth_nav'][11]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Sales/retursales">
                      <span class="sub-item">Retur Penjualan</span>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </li>
            <?php } ?>

            <?php if($data['check_auth']['check_auth_nav'][12]->nav_bar == 'Y' || $data['check_auth']['check_auth_nav'][13]->nav_bar == 'Y'){ ?>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#payment">
                <i class="fas fa-money-bill"></i>
                <p>Pelunasan</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="payment">
                <ul class="nav nav-collapse">
                  <?php if($data['check_auth']['check_auth_nav'][12]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Payment/debt">
                      <span class="sub-item">Pelunasan Hutang</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($data['check_auth']['check_auth_nav'][13]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>Payment/receivable">
                      <span class="sub-item">Pelunasan Piutang</span>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </li>
            <?php } ?>

            <?php if($data['check_auth']['check_auth_nav'][14]->nav_bar == 'Y'){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>Opname">
                <i class="fas fa-box"></i>
                <p>Stock Opname</p>
              </a>
            </li>
            <?php } ?>

            <?php if($data['check_auth']['check_auth_nav'][15]->nav_bar == 'Y'){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>Report">
                <i class="fas fa-file-pdf"></i>
                <p>Laporan</p>
              </a>
            </li>
            <?php } ?>

            <?php if($data['check_auth']['check_auth_nav'][16]->nav_bar == 'Y' || $data['check_auth']['check_auth_nav'][17]->nav_bar == 'Y'){ ?>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#user">
                <i class="fas fa-user"></i>
                <p>Admin</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="user">
                <ul class="nav nav-collapse">
                  <?php if($data['check_auth']['check_auth_nav'][16]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>User/role">
                      <span class="sub-item">Grup Pengguna</span>
                    </a>
                  </li>
                  <?php } ?>
                  <?php if($data['check_auth']['check_auth_nav'][17]->nav_bar == 'Y'){ ?>
                  <li>
                    <a href="<?php echo base_url(); ?>User/account">
                      <span class="sub-item">Akun Pengguna</span>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <?php
      // tentukan menu sidebar yang aktif dari controller/method yang sedang dibuka
      $nav_class  = strtolower($this->router->fetch_class());
      $nav_method = strtolower($this->router->fetch_method());
      $nav_active = $nav_class.'/'.$nav_method;
      $nav_alias  = array(
        'dashboard/index'             => 'dashboard',
        'dashboard/admin'             => 'dashboard',
        'masterdata/settingproduct'   => 'masterdata/product',
        'search/index'                => 'search',
        'purchase/addpo'              => 'purchase/po',
        'purchase/editpo'             => 'purchase/po',
        'purchase/addpurchase'        => 'purchase/purchases',
        'purchase/addreturpurchase'   => 'purchase/returpurchase',
        'sales/addsales'              => 'sales/salespage',
        'sales/addretursales'         => 'sales/retursales',
        'payment/debtpayview'         => 'payment/debt',
        'payment/receivablepayview'   => 'payment/receivable',
        'opname/index'                => 'opname',
        'opname/addopname'            => 'opname',
      );
      if(isset($nav_alias[$nav_active])){
        $nav_active = $nav_alias[$nav_active];
      }else if(strpos($nav_class, 'report') === 0){
        $nav_active = 'report';
      }
    ?>
    <script>
      (function(){
        var base   = '<?php echo base_url(); ?>'.toLowerCase();
        var active = '<?php echo $nav_active; ?>';
        var links  = document.querySelectorAll('.sidebar .nav a[href]');
        for(var i = 0; i < links.length; i++){
          var href = links[i].getAttribute('href').toLowerCase().replace(base, '').replace(/^\/+|\/+$/g, '');
          if(href != active){ continue; }

          var li = links[i].closest('li');
          li.classList.add('active');

          var collapse = li.closest('.collapse');
          if(collapse){
            collapse.classList.add('show');
            var parent = collapse.closest('li.nav-item');
            parent.classList.add('active', 'submenu');
            var toggle = parent.querySelector('a[data-bs-toggle="collapse"]');
            if(toggle){ toggle.classList.remove('collapsed'); toggle.setAttribute('aria-expanded', 'true'); }
          }
          break;
        }
      })();
    </script>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img
              src="<?php echo base_url(); ?>dist//img/kaiadmin/logo_light.svg"
              alt="navbar brand"
              class="navbar-brand"
              height="20"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <nav
        class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
        >
        <div class="container-fluid">
          <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <?php if($data['check_auth']['check_auth_nav'][10]->nav_bar == 'Y'){ ?>
            <li class="nav-item me-2">
              <a href="<?php echo base_url(); ?>Sales/pos" class="btn btn-success btn-sm fw-bold">
                <i class="fas fa-cart-plus me-1"></i> POS
              </a>
            </li>
            <?php } ?>
            <li
            class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
            >
            <a
            class="nav-link dropdown-toggle"
            data-bs-toggle="dropdown"
            href="#"
            role="button"
            aria-expanded="false"
            aria-haspopup="true"
            >
            <i class="fa fa-search"></i>
          </a>
          <ul class="dropdown-menu dropdown-search animated fadeIn">
            <form class="navbar-left navbar-form nav-search">
              <div class="input-group">
                <input
                type="text"
                placeholder="Search ..."
                class="form-control"
                />
              </div>
            </form>
          </ul>
        </li>

        <li class="nav-item topbar-icon dropdown hidden-caret">
          <a
          class="nav-link dropdown-toggle"
          href="#"
          id="notifDropdown"
          role="button"
          data-bs-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
          >
          <i class="fa fa-bell"></i>
          <span class="notification" id="notifCount" style="display:none;">0</span>
        </a>
        <ul
        class="dropdown-menu notif-box animated fadeIn"
        aria-labelledby="notifDropdown"
        >
        <li>
          <div class="dropdown-title" id="notifTitle">
            Tidak ada notifikasi
          </div>
        </li>
        <li>
          <div class="notif-scroll scrollbar-outer">
            <div class="notif-center" id="notifList"></div>
          </div>
        </li>
        <script>
          (function(){
            function esc(s){ var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
            function loadStockNotif(){
              fetch('<?php echo base_url(); ?>Dashboard/notif_stock', {credentials: 'same-origin'})
                .then(function(r){ return r.json(); })
                .then(function(res){
                  var total = res.total || 0;
                  var badge = document.getElementById('notifCount');
                  badge.textContent = total;
                  badge.style.display = total > 0 ? '' : 'none';
                  document.getElementById('notifTitle').textContent = total > 0 ? ('Ada ' + total + ' item di bawah minimal stock') : 'Tidak ada notifikasi';
                  var html = '';
                  (res.items || []).forEach(function(it){
                    html += '<a href="<?php echo base_url(); ?>Dashboard"><div class="notif-icon notif-danger"><i class="fas fa-box-open"></i></div>' +
                      '<div class="notif-content"><span class="block">' + esc(it.name) + '</span>' +
                      '<span class="time">Stok ' + it.stock + ' / Min ' + it.min + '</span></div></a>';
                  });
                  if(total > (res.items || []).length){
                    html += '<a href="<?php echo base_url(); ?>Dashboard"><div class="notif-content"><span class="time">+ ' + (total - res.items.length) + ' item lainnya, lihat di Dashboard</span></div></a>';
                  }
                  document.getElementById('notifList').innerHTML = html;
                })
                .catch(function(){});
            }
            document.addEventListener('DOMContentLoaded', loadStockNotif);
            setInterval(loadStockNotif, 300000);
          })();
        </script>
      </ul>
    </li>

<li class="nav-item topbar-user dropdown hidden-caret">
  <a
  class="dropdown-toggle profile-pic"
  data-bs-toggle="dropdown"
  href="#"
  aria-expanded="false"
  >
  <div class="avatar-sm">
    <img
    src="<?php echo base_url(); ?>dist//img/profile.jpg"
    alt="..."
    class="avatar-img rounded-circle"
    />
  </div>
  <span class="profile-username">
    <span class="op-7">Hi,</span>
    <span class="fw-bold"><?php echo $_SESSION['user_name']; ?></span>
  </span>
</a>
<ul class="dropdown-menu dropdown-user animated fadeIn">
  <div class="dropdown-user-scroll scrollbar-outer">
    <li>
      <div class="user-box">
        <div class="avatar-lg">
          <img src="<?php echo base_url(); ?>dist//img/profile.jpg" alt="image profile" class="avatar-img rounded"/>
        </div>
        <div class="u-text">
          <h4><?php echo $_SESSION['user_name']; ?></h4>
          <a href="profile.html" class="btn btn-xs btn-secondary btn-sm"><?php echo $_SESSION['user_role']; ?></a>
        </div>
      </div>
    </li>
    <li>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Account Setting</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="<?php echo base_url(); ?>Auth/logout">Logout</a>
    </li>
  </div>
</ul>
</li>
</ul>
</div>
</nav>
<!-- End Navbar -->