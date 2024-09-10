<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Surgepays - HR</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="<?php echo URLROOT ?>/assets/img/surge-pays-fav.png" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  
  <!-- Fonts and icons -->
  <script src="<?php echo URLROOT ?>/assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {families: ["Public Sans:300,400,500,600,700"]},
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["<?php echo URLROOT ?>/assets/css/fonts.min.css"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="<?php echo URLROOT ?>/assets/css/bootstrap.min.css?<?php echo rand(1, 9999) ?>" />
  <link rel="stylesheet" href="<?php echo URLROOT ?>/assets/css/plugins.min.css?<?php echo rand(1, 9999) ?>" />
  <link rel="stylesheet" href="<?php echo URLROOT ?>/assets/css/kaiadmin.min.css?<?php echo rand(1, 9999) ?>" />
<link rel="stylesheet" href="<?php echo URLROOT ?>/assets/css/custom.css?<?php echo rand(1, 9999) ?>" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link rel="stylesheet" href="<?php //echo URLROOT ?>/assets/css/demo.css" /> -->
</head>

<body>
  <div class="wrapper">
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header COL-SM -->
          <div class="logo-header" data-background-color="dark">
            <a href="<?php echo URLROOT ?>/" class="logo">
              <!-- <img src="<?php echo URLROOT ?>/assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" /> -->
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

        <?php require APPROOT . '/views/inc/navbar.php'; ?>
      </div> <!-- end/main-header -->