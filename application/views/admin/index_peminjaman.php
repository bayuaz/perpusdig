      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>
            <?php 

            if ($this->uri->uri_string() == 'admin') {
              echo 'Home';
            } elseif ($this->uri->uri_string() == 'admin/buku') {
              echo 'Buku';
            } elseif ($this->uri->uri_string() == 'admin/kategori') {
              echo 'Kategori';
            } elseif ($this->uri->uri_string() == 'admin/peminjaman') {
              echo 'Peminjaman';
            } elseif ($this->uri->uri_string() == 'admin/pengguna') {
              echo 'Pengguna';
            } elseif ($this->uri->uri_string() == 'admin/level') {
              echo 'Level';
            } elseif ($this->uri->uri_string() == 'admin/profile') {
              echo 'Profile';
            }

            ?>
            </h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item">
              <?php 

              if ($this->uri->uri_string() == 'admin') {
                echo 'Home';
              } elseif ($this->uri->uri_string() == 'admin/buku') {
                echo 'Buku';
              } elseif ($this->uri->uri_string() == 'admin/kategori') {
                echo 'Kategori';
              } elseif ($this->uri->uri_string() == 'admin/peminjaman') {
                echo 'Peminjaman';
              } elseif ($this->uri->uri_string() == 'admin/pengguna') {
                echo 'Pengguna';
              } elseif ($this->uri->uri_string() == 'admin/level') {
                echo 'Level';
              } elseif ($this->uri->uri_string() == 'admin/profile') {
                echo 'Profile';
              }

              ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4 class="text-primary">Data Peminjaman</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-peminjaman">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Nama</th>
                          <th>Buku</th>
                          <th>Tanggal Pinjam</th>
                          <th>Tanggal Kembali</th>
                          <th>Status</th>
                          <th>Denda</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data_peminjaman as $key => $peminjaman) : ?>
                        <tr>
                          <td><?= $key+1; ?></td>
                          <td><?= $peminjaman['nama_pengguna'] ?></td>
                          <td><?= $peminjaman['judul_buku'] ?></td>
                          <td><?= tglIndo($peminjaman['tgl_peminjaman']) ?></td>
                          <td><?= tglIndo($peminjaman['tgl_pengembalian']) ?></td>
                          <td>
                            <?php

                            $waktu_pengembalian  = date_create($peminjaman['tgl_pengembalian']); // waktu pengembalian
                            $waktu_sekarang = date_create(); // waktu sekarang
                            $diff  = date_diff($waktu_sekarang, $waktu_pengembalian);

                            if ($diff->invert > 0) :
                              if ($peminjaman['tgl_pengembalian'] == date('Y-m-d')) : ?>
                              <div class="badge badge-info">Dipinjam</div>
                              <?php else :
                                if ($peminjaman['status_peminjaman'] == 'dipinjam') : ?>
                                  <div class="badge badge-danger">Telat <?= $diff->d ?> hari</div>
                                <?php elseif ($peminjaman['status_peminjaman'] == 'diajukan') : ?>
                                  <div class="badge badge-warning">Menunggu Persetujuan</div>
                                <?php elseif ($peminjaman['status_peminjaman'] == 'ditolak') : ?>
                                  <div class="badge badge-danger">Ditolak</div>
                                <?php elseif ($peminjaman['status_peminjaman'] == 'dikembalikan') : ?>
                                  <div class="badge badge-success">Dikembalikan</div>
                                <?php endif;
                              endif;
                            else :
                              if ($peminjaman['status_peminjaman'] == 'diajukan') : ?>
                                <div class="badge badge-warning">Menunggu Persetujuan</div>
                              <?php elseif ($peminjaman['status_peminjaman'] == 'ditolak') : ?>
                                <div class="badge badge-danger">Ditolak</div>
                              <?php elseif ($peminjaman['status_peminjaman'] == 'dipinjam') : ?>
                                <div class="badge badge-info">Dipinjam</div>
                              <?php elseif ($peminjaman['status_peminjaman'] == 'dikembalikan') : ?>
                                <div class="badge badge-success">Dikembalikan</div>
                              <?php endif;
                            endif; ?>
                          </td>
                          <td>
                            <div class="pull-left">Rp</div>
                            <div class="pull-right"><?= number_format($peminjaman['denda_peminjaman']); ?></div>
                          </td>
                        </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
       </div> 