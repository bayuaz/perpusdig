      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>
            <?php 

            if ($this->uri->uri_string() == 'pengguna') {
              echo 'Home';
            } elseif ($this->uri->uri_string() == 'pengguna/buku') {
              echo 'Buku';
            } elseif ($this->uri->uri_string() == 'pengguna/pinjam') {
              echo 'Buku Dipinjam';
            }

            ?>
            </h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item">
              <?php 

              if ($this->uri->uri_string() == 'pengguna') {
                echo 'Home';
              } elseif ($this->uri->uri_string() == 'pengguna/buku') {
                echo 'Buku';
              } elseif ($this->uri->uri_string() == 'pengguna/pinjam') {
                echo 'Buku Dipinjam';
              }

              ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 mb-4">
              <div class="hero bg-primary text-white">
                <div class="hero-inner">
                  <h2><?= $salam; ?>, <?= $detail_user['nama_pengguna']; ?>!</h2>
                  <p class="lead">Mau ngapain hari ini?</p>
                  <div class="mt-4">
                    <a href="<?= base_url('pengguna/buku'); ?>" class="btn btn-outline-white btn-lg btn-icon icon-left mr-2"><i class="fas fa-book-reader"></i> Baca Buku</a>
                    <a href="<?= base_url('pengguna/buku'); ?>" class="btn btn-outline-white btn-lg btn-icon icon-left mr-2"><i class="fas fa-book"></i> Pinjam Buku</a>
                    <a href="<?= base_url('pengguna/pinjam'); ?>" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="fas fa-book-dead"></i> Pulangin Buku</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>