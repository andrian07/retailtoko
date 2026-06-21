<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Pionir Backoffice</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
  <link rel="icon" href="<?php echo base_url(); ?>assets/logo.png" type="image/x-icon"/>
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

</head>
<body>
  <div class="wrapper sidebar_minimize">
    <!-- Sidebar -->
    <div class="sidebar sidebar-style-2" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="<?php echo base_url(); ?>/Dashboard" class="logo">
            <img
            src="<?php echo base_url(); ?>assets/logo.png"
            alt="navbar brand"
            class="navbar-brand"
            height="50"
            /><h1 style="color:#ffffff; margin-top:10px;">Pionir</h1>
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
          <span class="notification">2</span>
        </a>
        <ul
        class="dropdown-menu notif-box animated fadeIn"
        aria-labelledby="notifDropdown"
        >
        <li>
          <div class="dropdown-title">
            Ada 2 Notiifikasi Terbaru
          </div>
        </li>
        <li>
          <div class="notif-scroll scrollbar-outer">
            <div class="notif-center">
              <a href="#">
                <div class="notif-icon notif-primary">
                  <i class="fas fa-coins"></i>
                </div>
                <div class="notif-content">
                  <span class="block">Item Di Bawah Stock </span>
                  <span class="time">4 Item</span>
                </div>
              </a>
              <a href="#">
                <div class="notif-icon notif-success">
                  <i class="fas fa-file-invoice"></i>
                </div>
                <div class="notif-content">
                  <span class="block">Tagihan Jatuh Tempo Hari Ini</span>
                  <span class="time">5 Tagihan</span>
                </div>
              </a>
            </div>
          </div>
        </li>
      </ul>
    </li>
    <li class="nav-item topbar-icon dropdown hidden-caret">
      <a
      class="nav-link"
      data-bs-toggle="dropdown"
      href="#"
      aria-expanded="false"
      >
      <i class="fas fa-layer-group"></i>
    </a>
    <div class="dropdown-menu quick-actions animated fadeIn">
      <div class="quick-actions-header">
        <span class="title mb-1">Quick Actions</span>
        <span class="subtitle op-7">Shortcuts</span>
      </div>
      <div class="quick-actions-scroll scrollbar-outer">
        <div class="quick-actions-items">
          <div class="row m-0">
            <a class="col-6 col-md-4 p-0" href="#">
              <div class="quick-actions-item">
                <div class="avatar-item bg-danger rounded-circle">
                  <i class="far fa-calendar-alt"></i>
                </div>
                <span class="text">Calendar</span>
              </div>
            </a>
            <a class="col-6 col-md-4 p-0" href="#">
              <div class="quick-actions-item">
                <div
                class="avatar-item bg-warning rounded-circle"
                >
                <i class="fas fa-map"></i>
              </div>
              <span class="text">Maps</span>
            </div>
          </a>
          <a class="col-6 col-md-4 p-0" href="#">
            <div class="quick-actions-item">
              <div class="avatar-item bg-info rounded-circle">
                <i class="fas fa-file-excel"></i>
              </div>
              <span class="text">Reports</span>
            </div>
          </a>
          <a class="col-6 col-md-4 p-0" href="#">
            <div class="quick-actions-item">
              <div
              class="avatar-item bg-success rounded-circle"
              >
              <i class="fas fa-envelope"></i>
            </div>
            <span class="text">Emails</span>
          </div>
        </a>
        <a class="col-6 col-md-4 p-0" href="#">
          <div class="quick-actions-item">
            <div
            class="avatar-item bg-primary rounded-circle"
            >
            <i class="fas fa-file-invoice-dollar"></i>
          </div>
          <span class="text">Invoice</span>
        </div>
      </a>
      <a class="col-6 col-md-4 p-0" href="#">
        <div class="quick-actions-item">
          <div
          class="avatar-item bg-secondary rounded-circle"
          >
          <i class="fas fa-credit-card"></i>
        </div>
        <span class="text">Payments</span>
      </div>
    </a>
  </div>
</div>
</div>
</div>
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