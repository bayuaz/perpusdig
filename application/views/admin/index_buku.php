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
                  <h4 class="text-primary">Data Buku</h4>
                  <div class="card-header-action">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#tambah-buku"><i class="fas fa-plus mr-2"></i>Tambah Data</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-buku">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Judul</th>
                          <th>Kategori</th>
                          <th>Pengarang</th>
                          <th>Jumlah</th>
                          <th>Cover</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data_buku as $key => $buku) : ?>
                        <tr>
                          <td><?= $key+1; ?></td>
                          <td><?= $buku['judul_buku'] ?></td>
                          <td><?= $buku['nama_kategori'] ?></td>
                          <td><?= $buku['pengarang_buku'] ?></td>
                          <td><?= $buku['jumlah_buku'] ?></td>
                          <td>
                            <div class="gallery">
                              <div class="gallery-item" data-image="<?= base_url('assets/uploads/cover/') . $buku['cover_buku'] ?>" data-title="<?= $buku['judul_buku'] ?>"></div>
                            </div>
                          </td>
                          <td>
                            <a class="btn btn-primary btn-action mr-1 ubah-buku" title="Edit" data-toggle="modal" data-target="#modal-ubah-buku" data-id="<?= $buku['id_buku']; ?>" data-kategori="<?= $buku['id_kategori'] ?>" data-judul="<?= $buku['judul_buku']; ?>" data-kode="<?= $buku['kode_buku']; ?>" data-pengarang="<?= $buku['pengarang_buku']; ?>" data-penerbit="<?= $buku['penerbit_buku']; ?>" data-tahun-terbit="<?= $buku['tahun_terbit_buku']; ?>" data-jumlah="<?= $buku['jumlah_buku']; ?>"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn btn-danger btn-action hapus-buku" title="Delete" data-toggle="modal" data-target="#modal-hapus-buku" data-id="<?= $buku['id_buku']; ?>" data-kategori="<?= $buku['id_kategori'] ?>" data-judul="<?= $buku['judul_buku']; ?>" data-kode="<?= $buku['kode_buku']; ?>" data-pengarang="<?= $buku['pengarang_buku']; ?>" data-penerbit="<?= $buku['penerbit_buku']; ?>" data-tahun-terbit="<?= $buku['tahun_terbit_buku']; ?>" data-jumlah="<?= $buku['jumlah_buku']; ?>"><i class="fas fa-trash"></i></a>
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
        <!-- Start modal tambah buku -->
        <?php $attributes = ['class' => 'needs-validation was-validated', 'novalidate' => ''] ?>
        <?= form_open_multipart('admin/tambah_buku_proses', $attributes) ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="tambah-buku">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Tambah Buku</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="no-redirect" value="false">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kategori</label>
                    <div class="col-sm-9">
                      <select name="kategori" class="form-control select2 kategori-buku" data-placeholder="Pilih" required="">
                        <option disabled selected value></option>
                        <?php foreach($data_kategori as $kategori) : ?> 
                        <option value="<?= $kategori['id_kategori'] ?>" <?= set_select('kategori', $kategori['id_kategori']); ?>><?= $kategori['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?php if (form_error('kategori')) : ?>
                      <div class="invalid-feedback">
                        Kategori Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Kategori Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Judul</label>
                    <div class="col-sm-9">
                      <input type="text" name="judul" class="form-control" required="" autocomplete="off" value="<?= set_value('judul') ?>">
                      <?php if (form_error('judul')) : ?>
                      <div class="invalid-feedback">
                        Judul Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Judul Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kode</label>
                    <div class="col-sm-9">
                      <input type="text" name="kode" class="form-control" required="" autocomplete="off" value="<?= set_value('kode') ?>">
                      <?php if (form_error('kode')) : ?>
                      <div class="invalid-feedback">
                        Kode Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Kode Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pengarang</label>
                    <div class="col-sm-9">
                      <input type="text" name="pengarang" class="form-control" required="" autocomplete="off" value="<?= set_value('pengarang') ?>">
                      <?php if (form_error('pengarang')) : ?>
                      <div class="invalid-feedback">
                        Pengarang Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Pengarang Buku wajib diisi!
                      </div>
                      <?php endif; ?>                      
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Penerbit</label>
                    <div class="col-sm-9">
                      <input type="text" name="penerbit" class="form-control" required="" autocomplete="off" value="<?= set_value('penerbit') ?>">
                      <?php if (form_error('penerbit')) : ?>
                      <div class="invalid-feedback">
                        Penerbit Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Penerbit Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tahun Terbit</label>
                    <div class="col-sm-9">
                      <input type="text" name="tahun_terbit" class="form-control" id="tambah-tahun-terbit" required="" autocomplete="off" value="<?= set_value('tahun_terbit') ?>">
                      <?php if (form_error('tahun_terbit')) : ?>
                      <div class="invalid-feedback">
                        Tahun Terbit Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Tahun Terbit Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jumlah</label>
                    <div class="col-sm-9">
                      <input type="text" name="jumlah" class="form-control" id="tambah-jumlah" required="" autocomplete="off" value="<?= set_value('jumlah') ?>">
                      <?php if (form_error('jumlah')) : ?>
                      <div class="invalid-feedback">
                        Jumlah Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Jumlah Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Cover</label>
                    <div class="col-sm-9">
                      <input type="file" name="cover" class="form-control" required="">
                      <?php if (form_error('cover')) : ?>
                      <div class="invalid-feedback">
                        Cover Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Cover Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
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
        <!-- End modal tambah buku -->
        <!-- Start modal ubah buku -->
        <?php $attributes = ['class' => 'needs-validation was-validated', 'novalidate' => ''] ?>
        <?= form_open_multipart('admin/ubah_buku_proses', $attributes) ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="modal-ubah-buku">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Ubah Buku</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="no-redirect" value="false">
                  <input type="hidden" name="id" id="ubah-id" value="<?= set_value('id') ?>">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kategori</label>
                    <div class="col-sm-9">
                      <select name="kategori" class="form-control select2 kategori-buku-ubah" id="ubah-kategori" data-placeholder="Pilih" required="">
                        <?php foreach($data_kategori as $kategori) : ?> 
                        <option value="<?= $kategori['id_kategori'] ?>"><?= $kategori['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?php if (form_error('kategori')) : ?>
                      <div class="invalid-feedback">
                        Kategori Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Kategori Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Judul</label>
                    <div class="col-sm-9">
                      <input type="text" name="judul" class="form-control" id="ubah-judul" required="" autocomplete="off" value="<?= set_value('judul') ?>">
                      <?php if (form_error('judul')) : ?>
                      <div class="invalid-feedback">
                        Judul Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Judul Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kode</label>
                    <div class="col-sm-9">
                      <input type="text" name="kode" class="form-control" id="ubah-kode" required="" autocomplete="off" value="<?= set_value('kode') ?>">
                      <?php if (form_error('kode')) : ?>
                      <div class="invalid-feedback">
                        Kode Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Kode Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pengarang</label>
                    <div class="col-sm-9">
                      <input type="text" name="pengarang" class="form-control" id="ubah-pengarang" required="" autocomplete="off" value="<?= set_value('pengarang') ?>">
                      <?php if (form_error('pengarang')) : ?>
                      <div class="invalid-feedback">
                        Pengarang Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Pengarang Buku wajib diisi!
                      </div>
                      <?php endif; ?>                      
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Penerbit</label>
                    <div class="col-sm-9">
                      <input type="text" name="penerbit" class="form-control" id="ubah-penerbit" required="" autocomplete="off" value="<?= set_value('penerbit') ?>">
                      <?php if (form_error('penerbit')) : ?>
                      <div class="invalid-feedback">
                        Penerbit Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Penerbit Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tahun Terbit</label>
                    <div class="col-sm-9">
                      <input type="text" name="tahun_terbit" class="form-control" id="ubah-tahun-terbit" required="" autocomplete="off" value="<?= set_value('tahun_terbit') ?>">
                      <?php if (form_error('tahun_terbit')) : ?>
                      <div class="invalid-feedback">
                        Tahun Terbit Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Tahun Terbit Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jumlah</label>
                    <div class="col-sm-9">
                      <input type="text" name="jumlah" class="form-control" id="ubah-jumlah" required="" autocomplete="off" value="<?= set_value('jumlah') ?>">
                      <?php if (form_error('jumlah')) : ?>
                      <div class="invalid-feedback">
                        Jumlah Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Jumlah Buku wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Cover</label>
                    <div class="col-sm-9">
                      <input type="file" name="cover" class="form-control">
                      <div class="valid-feedback">Kosongkan jika tidak ada perubahan</div>
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
        <!-- End modal ubah buku -->
        <!-- Start modal hapus buku -->
        <?= form_open_multipart('admin/hapus_buku_proses') ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="modal-hapus-buku">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Hapus Buku</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="no-redirect" value="false">
                  <input type="hidden" name="id" id="hapus-id" value="<?= set_value('id') ?>">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kategori</label>
                    <div class="col-sm-9">
                      <select name="kategori" class="form-control select2 kategori-buku-ubah" id="hapus-kategori" data-placeholder="Pilih" disabled="">
                        <?php foreach($data_kategori as $kategori) : ?> 
                        <option value="<?= $kategori['id_kategori'] ?>"><?= $kategori['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Judul</label>
                    <div class="col-sm-9">
                      <input type="text" name="judul" class="form-control" id="hapus-judul" value="<?= set_value('judul') ?>" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kode</label>
                    <div class="col-sm-9">
                      <input type="text" name="kode" class="form-control" id="hapus-kode" value="<?= set_value('kode') ?>" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pengarang</label>
                    <div class="col-sm-9">
                      <input type="text" name="pengarang" class="form-control" id="hapus-pengarang" value="<?= set_value('pengarang') ?>" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Penerbit</label>
                    <div class="col-sm-9">
                      <input type="text" name="penerbit" class="form-control" id="hapus-penerbit" value="<?= set_value('penerbit') ?>" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tahun Terbit</label>
                    <div class="col-sm-9">
                      <input type="text" name="tahun_terbit" class="form-control" id="hapus-tahun-terbit" value="<?= set_value('tahun_terbit') ?>" disabled="">
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Jumlah</label>
                    <div class="col-sm-9">
                      <input type="text" name="jumlah" class="form-control" id="hapus-jumlah" value="<?= set_value('jumlah') ?>" disabled="">
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
        <!-- End modal hapus buku -->
      </div>