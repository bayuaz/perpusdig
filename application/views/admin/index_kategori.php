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
              }

              ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4 class="text-primary">Data Kategori</h4>
                  <div class="card-header-action">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#tambah-kategori"><i class="fas fa-plus mr-2"></i>Tambah Data</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-kategori">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Nama</th>
                          <th>Keterangan</th>
                          <th>Jumlah Buku</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data_kategori_buku as $key => $kategori_buku) : ?>
                        <tr>
                          <td><?= $key+1; ?></td>
                          <td><?= $kategori_buku['nama_kategori'] ?></td>
                          <td><?= $kategori_buku['ket_kategori'] ?></td>
                          <td><?= $kategori_buku['jumlah_buku'] ?></td>
                          <td>
                            <a class="btn btn-primary btn-action mr-1 ubah-kategori" title="Edit" data-toggle="modal" data-target="#modal-ubah-kategori" data-id="<?= $kategori_buku['id_kategori']; ?>" data-nama="<?= $kategori_buku['nama_kategori'] ?>" data-keterangan="<?= $kategori_buku['ket_kategori']; ?>"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn btn-danger btn-action hapus-kategori" title="Delete" data-toggle="modal" data-target="#modal-hapus-kategori" data-id="<?= $kategori_buku['id_kategori']; ?>" data-nama="<?= $kategori_buku['nama_kategori'] ?>" data-keterangan="<?= $kategori_buku['ket_kategori']; ?>"><i class="fas fa-trash"></i></a>
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
        <!-- Start modal tambah kategori -->
        <?php $attributes = ['class' => 'needs-validation was-validated', 'novalidate' => ''] ?>
        <?= form_open('admin/tambah_kategori_proses', $attributes) ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="tambah-kategori">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Tambah Kategori</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" name="nama" class="form-control" required="" autocomplete="off" value="<?= set_value('nama') ?>">
                      <?php if (form_error('nama')) : ?>
                      <div class="invalid-feedback">
                        Nama Kategori wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Nama Kategori wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-9">
                      <textarea name="keterangan" class="summernote-simple" autocomplete="off"></textarea>
                    </div>
                  </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </div>
            </div>
          </div>
        <?= form_close(); ?>
        <!-- End modal tambah kategori -->
        <!-- Start modal ubah kategori -->
        <?php $attributes = ['class' => 'needs-validation was-validated', 'novalidate' => ''] ?>
        <?= form_open('admin/ubah_kategori_proses', $attributes) ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="modal-ubah-kategori">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Ubah Kategori</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" id="ubah-id" value="<?= set_value('id') ?>">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" name="nama" class="form-control" id="ubah-nama" required="" autocomplete="off" value="<?= set_value('nama') ?>">
                      <?php if (form_error('nama')) : ?>
                      <div class="invalid-feedback">
                        Nama Kategori wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Nama Kategori wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-9">
                      <textarea name="keterangan" class="summernote-simple" id="ubah-keterangan" autocomplete="off"><?= set_value('keterangan') ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </div>
            </div>
          </div>
        <?= form_close(); ?>
        <!-- End modal ubah kategori -->
        <!-- Start modal hapus kategori -->
        <?= form_open('admin/hapus_kategori_proses') ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="modal-hapus-kategori">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Hapus Kategori</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" id="hapus-id" value="<?= set_value('id') ?>">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" name="nama" class="form-control" id="hapus-nama" value="<?= set_value('nama') ?>" disabled="">
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-9">
                      <textarea name="keterangan" class="summernote-simple" id="hapus-keterangan"><?= set_value('keterangan') ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
              </div>
            </div>
          </div>
        <?= form_close(); ?>
        <!-- End modal hapus kategori -->
      </div>