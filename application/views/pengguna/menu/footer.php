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
  <?php if ($this->uri->uri_string() == 'pengguna/buku' || $this->uri->uri_string() == 'pengguna/pinjam') : ?>
  <script src="<?= base_url('stisla/node_modules/datatables/media/js/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('stisla/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('stisla/node_modules/chocolat/dist/js/jquery.chocolat.min.js') ?>"></script>
  <script src="<?= base_url('stisla/node_modules/sweetalert/dist/sweetalert.min.js') ?>"></script>
  <?php endif; ?>
  
  <!-- Template JS File -->
  <script src="<?= base_url('stisla/assets/js/scripts.js') ?>"></script>
  <script src="<?= base_url('stisla/assets/js/custom.js') ?>"></script>

  <!-- Page Specific JS File -->
  <?php if ($this->uri->uri_string() == 'pengguna/buku') : ?>
  <script src="<?= base_url('stisla/assets/js/page/pengguna-buku.js') ?>"></script>
  <?php elseif ($this->uri->uri_string() == 'pengguna/pinjam') : ?>
  <script src="<?= base_url('stisla/assets/js/page/pengguna-pinjam.js') ?>"></script>
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