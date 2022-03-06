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
            } elseif ($this->uri->uri_string() == 'pengguna/profile') {
              echo 'Profile';
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
              } elseif ($this->uri->uri_string() == 'pengguna/profile') {
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
                  <h4 class="text-primary">Data Buku</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-pinjam">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Judul</th>
                          <th>Kategori</th>
                          <th>Tanggal Pinjam</th>
                          <th>Tanggal Kembali</th>
                          <th>Status</th>
                          <th>Cover</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data_pinjam as $key => $pinjam) : ?>
                        <tr>
                          <td><?= $key+1; ?></td>
                          <td><?= $pinjam['judul_buku'] ?></td>
                          <td><?= $pinjam['nama_kategori'] ?></td>
                          <td><?= tglIndo($pinjam['tgl_peminjaman']); ?></td>
                          <?php 
                          $waktu_pengembalian  = date_create($pinjam['tgl_pengembalian']); // waktu pengembalian
                          $waktu_sekarang = date_create(date('Y-m-d')); // waktu dikembalikan
                          $diff  = date_diff($waktu_sekarang, $waktu_pengembalian);
                          ?>
                          <td class="<?= $diff->invert > 0 ? 'text-danger' : 'text-success'; ?>"><?= tglIndo($pinjam['tgl_pengembalian']); ?></td>
                          <td>
                            <?php

                            $waktu_pengembalian  = date_create($pinjam['tgl_pengembalian']); // waktu pengembalian
                            $waktu_sekarang = date_create(); // waktu sekarang
                            $diff  = date_diff($waktu_sekarang, $waktu_pengembalian);

                            if ($diff->invert > 0) :
                              if ($pinjam['tgl_pengembalian'] == date('Y-m-d')) : ?>
                              <div class="badge badge-info">Dipinjam</div>
                              <?php else :
                                if ($pinjam['status_peminjaman'] == 'dipinjam') : ?>
                                  <div class="badge badge-danger">Telat <?= $diff->d ?> hari</div>
                                <?php elseif ($pinjam['status_peminjaman'] == 'diajukan') : ?>
                                  <div class="badge badge-warning">Menunggu Persetujuan</div>
                                <?php elseif ($pinjam['status_peminjaman'] == 'ditolak') : ?>
                                  <div class="badge badge-danger">Ditolak</div>
                                <?php elseif ($pinjam['status_peminjaman'] == 'dikembalikan') : ?>
                                  <div class="badge badge-success">Dikembalikan</div>
                                <?php endif;
                              endif;
                            else :
                              if ($pinjam['status_peminjaman'] == 'diajukan') : ?>
                                <div class="badge badge-warning">Menunggu Persetujuan</div>
                              <?php elseif ($pinjam['status_peminjaman'] == 'ditolak') : ?>
                                <div class="badge badge-danger">Ditolak</div>
                              <?php elseif ($pinjam['status_peminjaman'] == 'dipinjam') : ?>
                                <div class="badge badge-info">Dipinjam</div>
                              <?php elseif ($pinjam['status_peminjaman'] == 'dikembalikan') : ?>
                                <div class="badge badge-success">Dikembalikan</div>
                              <?php endif;
                            endif; ?>
                          </td>
                          <td>
                            <div class="gallery">
                              <div class="gallery-item" data-image="<?= base_url('assets/uploads/cover/') . $pinjam['cover_buku'] ?>" data-title="<?= $pinjam['judul_buku'] ?>"></div>
                            </div>
                          </td>
                          <td>
                            <?php if ($pinjam['status_peminjaman'] != 'diajukan' && $pinjam['status_peminjaman'] != 'ditolak') : ?>
                            <?php if (!empty($pinjam['file_buku'])) : ?>
                            <a class="btn btn-primary btn-action mr-1 baca-buku" title="Baca Buku" data-toggle="modal" data-target="#modal-baca-buku" data-judul="<?= $pinjam['judul_buku'] ?>" data-file="<?= base_url('assets/uploads/files/'.$pinjam['file_buku']) ?>"><i class="fas fa-book-reader"></i></a>
                            <?php else : ?>
                            <a class="btn btn-warning btn-action mr-1 file-kosong" title="File belum ada"><i class="fas fa-times"></i></a>
                            <?php endif; ?>
                            <?php endif; 

                            $denda = 2000 * $diff->d;
                            ?>
                            <a class="btn btn-danger btn-action kembalikan-buku" title="Pulangin Buku" data-toggle="modal" data-target="#modal-kembalikan-buku" data-id="<?= $pinjam['id_buku']; ?>" data-judul="<?= $pinjam['judul_buku']; ?>" data-nama="<?= $this->session->userdata('nama'); ?>" data-tgl-pinjam="<?= hariIndo(date('l', strtotime($pinjam['tgl_peminjaman']))) . ', ' . tglIndo($pinjam['tgl_peminjaman']) ?>" data-tgl-kembali="<?= hariIndo(date('l', strtotime($pinjam['tgl_pengembalian']))) . ', ' . tglIndo($pinjam['tgl_pengembalian']) ?>" data-denda="<?= $diff->invert > 0 ? rupiah($denda) : rupiah(0) ?>"><i class="fas fa-book-dead"></i></a>
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
        <!-- Start modal kembalikan buku -->
        <?= form_open('pengguna/kembalikan_buku_proses') ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="modal-kembalikan-buku">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Kembalikan Buku</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" id="kembalikan-buku-id" value="<?= set_value('id') ?>">
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <p id="kembalikan-buku-nama"></p>
                    </div>
                    <label class="col-sm-3 col-form-label">Judul</label>
                    <div class="col-sm-9">
                      <p id="kembalikan-buku-judul"></p>
                    </div>
                    <label class="col-sm-3 col-form-label">Pinjam</label>
                    <div class="col-sm-9">
                      <p id="kembalikan-buku-tgl-pinjam"></p>
                    </div>
                    <label class="col-sm-3 col-form-label">Kembali</label>
                    <div class="col-sm-9">
                      <p id="kembalikan-buku-tgl-kembali"></p>
                    </div>
                    <label class="col-sm-3 col-form-label">Dikembalikan</label>
                    <div class="col-sm-9">
                      <p id="kembalikan-buku-tgl-dikembalikan"><?= hariIndo(date('l')) . ', ' . tglIndo(date('Y-m-d')); ?></p>
                    </div>
                    <label class="col-sm-3 col-form-label">Denda</label>
                    <div class="col-sm-9">
                      <p class="font-weight-bold" id="kembalikan-buku-denda"></p>
                    </div>
                  </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="konfirmasi-kembali">Kembalikan</button>
                </div>
              </div>
            </div>
          </div>
        <?= form_close(); ?>
        <!-- End modal kembalikan buku -->
        <!-- Start modal baca buku -->
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-baca-buku">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Baca Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <object id="source-file" type="application/pdf" data="" height="500px" width="100%">
                <p>
                  File tidak dapat ditemukan atau plugin tidak aktif!
                  <br>
                  <a id="alt-file" href="">Klik disini untuk mendownload file.</a>
                </p>
              </object>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End modal baca buku -->
      </div>