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

    .sidebar_minimize .main-header, .sidebar_minimize .main-panel {
      width: 100% !important;
      transition: all .3s;
    }
    
    @media screen and (min-width: 992px) {
      .sidebar_minimize .main-header, .sidebar_minimize .main-panel {
        width: 100% !important;
        transition: all .3s;
      }
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

    <div class="main-panel">
      <div class="main-header">
        <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
          <div class="container-fluid">
            Detail PO
          </div>
        </nav>
<!-- End Navbar -->