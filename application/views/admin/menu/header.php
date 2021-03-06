<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $title ?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url('stisla/node_modules/izitoast/dist/css/iziToast.min.css') ?>">
  <?php if ($this->uri->uri_string() == 'admin/kategori' || $this->uri->uri_string() == 'admin/tambah_kategori_proses' || $this->uri->uri_string() == 'admin/ubah_kategori_proses' || $this->uri->uri_string() == 'admin/hapus_kategori_proses' || $this->uri->uri_string() == 'admin/pengguna' || $this->uri->uri_string() == 'admin/tambah_pengguna_proses' || $this->uri->uri_string() == 'admin/ubah_pengguna_proses' || $this->uri->uri_string() == 'admin/hapus_pengguna_proses' || $this->uri->uri_string() == 'admin/level' || $this->uri->uri_string() == 'admin/tambah_level_proses' || $this->uri->uri_string() == 'admin/ubah_level_proses' || $this->uri->uri_string() == 'admin/hapus_level_proses' || $this->uri->uri_string() == 'admin/profile' || $this->uri->uri_string() == 'admin/ubah_profile_proses') : ?>
  <link rel="stylesheet" href="<?= base_url('stisla/node_modules/summernote/dist/summernote-bs4.css') ?>">
  <?php endif; ?>
  <?php if ($this->uri->uri_string() == 'admin' || $this->uri->uri_string() == 'admin/buku' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses' || $this->uri->uri_string() == 'admin/pengguna' || $this->uri->uri_string() == 'admin/tambah_pengguna_proses' || $this->uri->uri_string() == 'admin/ubah_pengguna_proses' || $this->uri->uri_string() == 'admin/hapus_pengguna_proses') : ?>
  <link rel="stylesheet" href="<?= base_url('stisla/node_modules/select2/dist/css/select2.min.css') ?>">
  <?php endif; ?>
  <?php if ($this->uri->uri_string() == 'admin/buku' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses' || $this->uri->uri_string() == 'admin/kategori' || $this->uri->uri_string() == 'admin/tambah_kategori_proses' || $this->uri->uri_string() == 'admin/ubah_kategori_proses' || $this->uri->uri_string() == 'admin/hapus_kategori_proses' || $this->uri->uri_string() == 'admin/peminjaman' || $this->uri->uri_string() == 'admin/pinjam_buku_proses' || $this->uri->uri_string() == 'admin/pengguna' || $this->uri->uri_string() == 'admin/tambah_pengguna_proses' || $this->uri->uri_string() == 'admin/ubah_pengguna_proses' || $this->uri->uri_string() == 'admin/hapus_pengguna_proses' || $this->uri->uri_string() == 'admin/level' || $this->uri->uri_string() == 'admin/tambah_level_proses' || $this->uri->uri_string() == 'admin/ubah_level_proses' || $this->uri->uri_string() == 'admin/hapus_level_proses') : ?>
  <link rel="stylesheet" href="<?= base_url('stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') ?>">
  <?php endif; ?>
  <?php if ($this->uri->uri_string() == 'admin/buku' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses') : ?>
  <link rel="stylesheet" href="<?= base_url('stisla/node_modules/chocolat/dist/css/chocolat.css') ?>">
  <?php endif; ?>
  <?php if ($this->uri->uri_string() == 'admin/profile' || $this->uri->uri_string() == 'admin/ubah_profile_proses') : ?>
  <link rel="stylesheet" href="<?= base_url('stisla/node_modules/bootstrap-social/bootstrap-social.css') ?>">
  <?php endif; ?>

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('stisla/assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('stisla/assets/css/components.css') ?>">

  <!-- Internal CSS-->
  <style type="text/css">
    .was-validated .form-control:invalid + .select2 .select2-selection{
        border-color: #dc3545!important;
    }

    .was-validated .form-control:valid + .select2 .select2-selection{
        border-color: #28a745!important;
    }

    *:focus{
      outline:0px;
    }
  </style>
</head>
<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto" action="#">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <?php $foto = isset($detail_user_header['foto_pengguna']) ? 'uploads/profile/'.$detail_user_header['foto_pengguna'] : 'img/avatar/avatar-1.png'; ?>
            <img alt="image" src="<?= base_url('stisla/assets/'.$foto) ?>" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?= $detail_user_header['nama_pengguna'] ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <?php 

              // get last minute login
              $awal  = date_create($detail_user_header['create_date']); // waktu login
              $akhir = date_create(); // waktu sekarang
              $diff  = date_diff($awal, $akhir);

              ?>
              <div class="dropdown-title">Logged in <?= $diff->i ?> min ago</div>
              <a href="<?= base_url('admin/profile') ?>" class="dropdown-item has-icon">
                <i class="fas fa-user"></i> Profile
              </a>
              <a href="#" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>
              <a href="#" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?= base_url('admin/logout') ?>" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>