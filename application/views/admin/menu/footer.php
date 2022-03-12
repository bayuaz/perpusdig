      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; <?= date('Y') ?> <div class="bullet"></div> SMPN 1 Datuk Limapuluh
        </div>
        <div class="footer-right">
          <a href="https://getstisla.com/" target="_blank">2.3.0</a>
        </div>
      </footer>
    </div>
  </div>
  
  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="<?= base_url('stisla/assets/js/stisla.js') ?>"></script>

  <!-- JS Libraries -->
  <script src="<?= base_url('stisla/node_modules/izitoast/dist/js/iziToast.min.js') ?>"></script>
  <?php if ($this->uri->uri_string() == 'admin' || $this->uri->uri_string() == 'admin/buku' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses' || $this->uri->uri_string() == 'admin/pengguna' || $this->uri->uri_string() == 'admin/tambah_pengguna_proses' || $this->uri->uri_string() == 'admin/ubah_pengguna_proses' || $this->uri->uri_string() == 'admin/hapus_pengguna_proses') : ?>
  <script src="<?= base_url('stisla/node_modules/select2/dist/js/select2.full.min.js') ?>"></script>
  <script src="<?= base_url('stisla/node_modules/cleave.js/dist/cleave.min.js') ?>"></script>
  <?php endif; ?>
  <?php if ($this->uri->uri_string() == 'admin/buku' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses' || $this->uri->uri_string() == 'admin/kategori' || $this->uri->uri_string() == 'admin/tambah_kategori_proses' || $this->uri->uri_string() == 'admin/ubah_kategori_proses' || $this->uri->uri_string() == 'admin/hapus_kategori_proses' || $this->uri->uri_string() == 'admin/peminjaman' || $this->uri->uri_string() == 'admin/pinjam_buku_proses' || $this->uri->uri_string() == 'admin/pengguna' || $this->uri->uri_string() == 'admin/tambah_pengguna_proses' || $this->uri->uri_string() == 'admin/ubah_pengguna_proses' || $this->uri->uri_string() == 'admin/hapus_pengguna_proses' || $this->uri->uri_string() == 'admin/level' || $this->uri->uri_string() == 'admin/tambah_level_proses' || $this->uri->uri_string() == 'admin/ubah_level_proses' || $this->uri->uri_string() == 'admin/hapus_level_proses') : ?>
  <script src="<?= base_url('stisla/node_modules/datatables/media/js/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('stisla/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') ?>"></script>
  <?php endif; ?>
  <?php if ($this->uri->uri_string() == 'admin/buku' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses') : ?>
  <script src="<?= base_url('stisla/node_modules/chocolat/dist/js/jquery.chocolat.min.js') ?>"></script>
  <script src="<?= base_url('stisla/node_modules/sweetalert/dist/sweetalert.min.js') ?>"></script>
  <?php elseif ($this->uri->uri_string() == 'admin/kategori' || $this->uri->uri_string() == 'admin/tambah_kategori_proses' || $this->uri->uri_string() == 'admin/ubah_kategori_proses' || $this->uri->uri_string() == 'admin/hapus_kategori_proses' || $this->uri->uri_string() == 'admin/pengguna' || $this->uri->uri_string() == 'admin/tambah_pengguna_proses' || $this->uri->uri_string() == 'admin/ubah_pengguna_proses' | $this->uri->uri_string() == 'admin/hapus_pengguna_proses' || $this->uri->uri_string() == 'admin/level' || $this->uri->uri_string() == 'admin/tambah_level_proses' || $this->uri->uri_string() == 'admin/ubah_level_proses' || $this->uri->uri_string() == 'admin/hapus_level_proses' || $this->uri->uri_string() == 'admin/profile') : ?>
  <script src="<?= base_url('stisla/node_modules/summernote/dist/summernote-bs4.js') ?>"></script>
  <?php endif; ?>

  <!-- Template JS File -->
  <script src="<?= base_url('stisla/assets/js/scripts.js') ?>"></script>
  <script src="<?= base_url('stisla/assets/js/custom.js') ?>"></script>

  <!-- Page Specific JS File -->
  <?php if ($this->uri->uri_string() == 'admin' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses') : ?>
  <script src="<?= base_url('stisla/assets/js/page/index-0.js') ?>"></script>
  <?php  elseif ($this->uri->uri_string() == 'admin/buku' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses') : ?>
  <script src="<?= base_url('stisla/assets/js/page/admin-buku.js') ?>"></script>
  <?php elseif ($this->uri->uri_string() == 'admin/kategori' || $this->uri->uri_string() == 'admin/tambah_kategori_proses' || $this->uri->uri_string() == 'admin/ubah_kategori_proses' || $this->uri->uri_string() == 'admin/hapus_kategori_proses') : ?>
  <script src="<?= base_url('stisla/assets/js/page/admin-kategori.js') ?>"></script>
  <?php elseif ($this->uri->uri_string() == 'admin/peminjaman' || $this->uri->uri_string() == 'admin/pinjam_buku_proses') : ?>
  <script src="<?= base_url('stisla/assets/js/page/admin-peminjaman.js') ?>"></script>
  <?php elseif ($this->uri->uri_string() == 'admin/pengguna' || $this->uri->uri_string() == 'admin/tambah_pengguna_proses' || $this->uri->uri_string() == 'admin/ubah_pengguna_proses' || $this->uri->uri_string() == 'admin/hapus_pengguna_proses') : ?>
  <script src="<?= base_url('stisla/assets/js/page/admin-pengguna.js') ?>"></script>
  <?php elseif ($this->uri->uri_string() == 'admin/level' || $this->uri->uri_string() == 'admin/tambah_level_proses' || $this->uri->uri_string() == 'admin/ubah_level_proses' || $this->uri->uri_string() == 'admin/hapus_level_proses') : ?>
  <script src="<?= base_url('stisla/assets/js/page/admin-level.js') ?>"></script>
  <?php elseif ($this->uri->uri_string() == 'admin/profile' || $this->uri->uri_string() == 'admin/ubah_profile_proses') : ?>
  <script src="<?= base_url('stisla/assets/js/page/admin-profile.js') ?>"></script>
  <?php endif; ?>

  <?php
    if ($this->session->userdata('success')) {
      echo 
      "<script type='text/javascript'>
        iziToast.success({
          title: 'Success!',
          message: '".$this->session->userdata('success')."',
          position: 'topRight'
        });
      </script>";

      $this->session->unset_userdata('success');
    }

    if ($this->session->userdata('failed')) {
      echo 
      "<script type='text/javascript'>
        iziToast.error({
          title: 'Failed!',
          message: '".$this->session->userdata('failed')."',
          position: 'topRight'
        });
      </script>";
    }

    $this->session->unset_userdata('failed');
  ?>
</body>
</html>