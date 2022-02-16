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
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4 class="text-primary">Data Buku</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-b">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Judul</th>
                          <th>Kategori</th>
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
                          <td>
                            <div class="gallery">
                              <div class="gallery-item" data-image="<?= base_url('assets/uploads/cover/') . $pinjam['cover_buku'] ?>" data-title="<?= $pinjam['judul_buku'] ?>"></div>
                            </div>
                          </td>
                          <td>
                            <a class="btn btn-primary btn-action mr-1 baca-buku" title="Baca Buku"><i class="fas fa-book-reader"></i></a>
                            <a class="btn btn-danger btn-action kembali-buku" title="Pulangin Buku" data-toggle="modal" data-target="#modal-kembali-buku" data-id="<?= $buku['id_buku']; ?>" data-judul="<?= $buku['judul_buku']; ?>" data-nama="<?= $this->session->userdata('nama'); ?>"><i class="fas fa-book-dead"></i></a>
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
        <!-- Start modal pinjam buku -->
        <?= form_open('pengguna/kembali_buku_proses') ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="modal-kembali-buku">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Kembalikan Buku</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" id="pinjam-buku-id" value="<?= set_value('id') ?>">
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <p id="pinjam-buku-nama"></p>
                    </div>
                    <label class="col-sm-3 col-form-label">Judul</label>
                    <div class="col-sm-9">
                      <p id="pinjam-buku-judul"></p>
                    </div>
                    <label class="col-sm-3 col-form-label">Pinjam</label>
                    <div class="col-sm-9">
                      <p id="pinjam-buku-tanggal"><?= hariIndo(date('l')) . ', ' . date('d-m-Y'); ?></p>
                    </div>
                    <label class="col-sm-3 col-form-label">Kembali</label>
                    <div class="col-sm-9">
                      <p id="pinjam-buku-tanggal"><?= hariIndo(date('l', strtotime('+3 days'))) . ', ' . date('d-m-Y', strtotime('+3 days')); ?></p>
                    </div>
                  </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="konfirmasi-pinjam">Pinjam</button>
                </div>
              </div>
            </div>
          </div>
        <?= form_close(); ?>
        <!-- End modal pinjam buku -->
      </div>