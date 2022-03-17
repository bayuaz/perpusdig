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
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Data Pengguna</h4>
                  </div>
                  <div class="card-body">
                    <?= $total_user ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-book"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Data Buku Fisik</h4>
                  </div>
                  <div class="card-body">
                    <?= $total_buku_fisik ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                  <i class="fas fa-atlas"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Data Buku Digital</h4>
                  </div>
                  <div class="card-body">
                    <?= $total_buku_digital ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-book-reader"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Data Peminjaman</h4>
                  </div>
                  <div class="card-body">
                    <?= $total_peminjaman ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
              <div class="card card-danger">
                <div class="card-header">
                  <h4 class="text-danger">Paling Sering Dipinjam</h4>
                  <div class="card-header-action">
                   <div class="badge badge-danger"><i class="fas fa-fire"></i></div>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="seringDipinjam"></canvas>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
              <div class="card card-danger">
                <div class="card-header">
                  <h4 class="text-danger">Paling Sering Login</h4>
                  <div class="card-header-action">
                   <div class="badge badge-danger"><i class="fas fa-fire"></i></div>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="topLogin"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Data Peminjaman Terbaru </h4>
                  <div class="card-header-action">
                    <a href="<?= base_url('admin/peminjaman') ?>" class="btn btn-primary"><i class="fas fa-eye mr-2"></i>Data Lengkap</a>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive table-invoice">
                    <table class="table table-striped">
                      <tr>
                        <th>Buku</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Tenggat Waktu</th>
                      </tr>
                      <?php if (!empty($data_peminjaman_terbaru)) : ?>
                      <?php foreach ($data_peminjaman_terbaru as $peminjaman) : ?>
                      <tr>
                        <td><?= $peminjaman['judul_buku'] ?></td>
                        <td class="font-weight-600"><?= $peminjaman['nama_pengguna'] ?></td>
                        <td>
                          <?php

                          $waktu_dikembalikan  = empty($peminjaman['tgl_dikembalikan']) ? date_create($peminjaman['tgl_pengembalian']) : date_create($peminjaman['tgl_dikembalikan']); // waktu dikembalikan
                          $waktu_pengembalian = date_create($peminjaman['tgl_pengembalian']); // waktu pengembalian seharusnya
                          $diff  = date_diff($waktu_dikembalikan, $waktu_pengembalian);

                          if ($diff->invert > 0) :
                            // set denda
                            $hari = $diff->d;
                            $nominal = 3000;
                            $denda = $hari * $nominal;

                            if ($peminjaman['status_peminjaman'] == 'dipinjam') : ?>
                                <div class="badge badge-danger">Telat <?= $diff->d ?> hari</div>
                            <?php elseif ($peminjaman['status_peminjaman'] == 'diajukan') : ?>
                              <div class="badge badge-danger">Menunggu</div>
                            <?php elseif ($peminjaman['status_peminjaman'] == 'ditolak') : ?>
                              <div class="badge badge-danger">Ditolak</div>
                            <?php elseif ($peminjaman['status_peminjaman'] == 'dikembalikan') : ?>
                              <div class="badge badge-success">Dikembalikan</div>
                            <?php endif;
                          else :
                            if ($peminjaman['status_peminjaman'] == 'diajukan') : 
                              if (empty($peminjaman['tgl_dikembalikan'])) : ?>
                                <div class="badge badge-warning">Menunggu</div>
                              <?php else : ?>
                                <div class="badge badge-danger">Menunggu</div>
                              <?php endif; ?>
                            <?php elseif ($peminjaman['status_peminjaman'] == 'ditolak') : ?>
                              <div class="badge badge-danger">Ditolak</div>
                            <?php elseif ($peminjaman['status_peminjaman'] == 'dipinjam') : ?>
                              <div class="badge badge-info">Dipinjam</div>
                            <?php elseif ($peminjaman['status_peminjaman'] == 'dikembalikan') : ?>
                              <div class="badge badge-success">Dikembalikan</div>
                            <?php endif;
                          endif; ?>
                        </td>
                        <td><?= tglIndo($peminjaman['tgl_pengembalian']) ?></td>
                      </tr>
                      <?php endforeach; ?>
                      <?php else : ?>
                      <tr>
                        <td class="text-center" colspan="4">
                          <div class="mt-4"> 
                            <i class="fa fa-3x fa-file-alt"></i><br><br>
                          </div>
                          <div class="mb-2">
                            <i>Belum ada data</i>
                          </div>
                        </td>   
                      </tr>
                      <?php endif; ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
              <div class="card card-danger">
                <div class="card-header">
                  <h4 class="text-danger">Sering Dipinjam</h4>
                  <div class="card-header-action">
                   <div class="badge badge-danger"><i class="fas fa-fire"></i></div>
                  </div>
                </div>
                <div class="card-body">
                  <?php if (!empty($data_sering_dipinjam)) : ?>
                  <ul class="list-unstyled list-unstyled-border">
                  <?php foreach ($data_sering_dipinjam as $sering_dipinjam) : ?>
                    <li class="media">
                      <img class="mr-3 rounded" width="55" src="<?= base_url('assets/uploads/cover/'.$sering_dipinjam['cover_buku']) ?>" alt="product">
                      <div class="media-body">
                        <div class="float-right"><div class="font-weight-600 text-danger text-small"><?= $sering_dipinjam['jumlah_dipinjam'] ?>x Dipinjam</div></div>
                        <div class="media-title"><?= $sering_dipinjam['judul_buku'] ?></div>
                        <span class="text-small text-muted"><?= $sering_dipinjam['nama_kategori'] ?></span>
                      </div>
                    </li>
                  <?php endforeach; ?>
                  </ul>
                  <?php else : ?>
                    <div class="media">
                      <div class="media-body">
                        <div class="media-title text-center text-danger">
                          <i class="fa fa-2x fa-file-alt"></i>
                          <div class="mt-3"> 
                            <span class="text-small"><i>Belum ada data</i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4 class="text-primary">Data Buku Terbaru</h4>
                  <div class="card-header-action">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#tambah-buku"><i class="fas fa-plus mr-2"></i>Tambah Data</a>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive table-invoice">
                    <table class="table table-striped">
                      <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Action</th>
                      </tr>
                      <?php if (!empty($data_buku_terbaru)) : ?>
                      <?php foreach ($data_buku_terbaru as $buku) : ?>
                      <tr>
                        <td class="font-weight-600" width="50%"><?= $buku['judul_buku']  ?></td>
                        <td><?= $buku['nama_kategori'] ?></td>
                        <td>
                          <a class="btn btn-primary btn-action mr-1 ubah-buku" title="Edit" data-toggle="modal" data-target="#modal-ubah-buku" data-id="<?= $buku['id_buku']; ?>" data-kategori="<?= $buku['id_kategori'] ?>" data-bentuk="<?= $buku['bentuk_buku'] ?>" data-judul="<?= $buku['judul_buku']; ?>" data-kode="<?= $buku['kode_buku']; ?>" data-pengarang="<?= $buku['pengarang_buku']; ?>" data-penerbit="<?= $buku['penerbit_buku']; ?>" data-tahun-terbit="<?= $buku['tahun_terbit_buku']; ?>" data-jumlah="<?= $buku['jumlah_buku']; ?>"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger btn-action hapus-buku" title="Delete" data-toggle="modal" data-target="#modal-hapus-buku" data-id="<?= $buku['id_buku']; ?>" data-kategori="<?= $buku['id_kategori'] ?>" data-bentuk="<?= $buku['bentuk_buku'] ?>" data-judul="<?= $buku['judul_buku']; ?>" data-kode="<?= $buku['kode_buku']; ?>" data-pengarang="<?= $buku['pengarang_buku']; ?>" data-penerbit="<?= $buku['penerbit_buku']; ?>" data-tahun-terbit="<?= $buku['tahun_terbit_buku']; ?>" data-jumlah="<?= $buku['jumlah_buku']; ?>"><i class="fas fa-trash"></i></a>
                      </tr>
                      <?php endforeach; ?>
                      <?php else : ?>
                      <tr>
                        <td class="text-center" colspan="3">
                          <div class="mt-4"> 
                            <i class="fa fa-3x fa-file-alt"></i><br><br>
                          </div>
                          <div class="mb-2">
                            <i>Belum ada data</i>
                          </div>
                        </td>   
                      </tr>
                      <?php endif; ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
              <div class="card card-success">
                <div class="card-header">
                  <h4 class="text-success">Aktivitas Terbaru</h4>
                  <div class="card-header-action">
                   <div class="badge badge-success"><i class="fas fa-signal"></i></div>
                  </div>
                </div>
                <div class="card-body">
                  <?php if (!empty($data_logs)) : ?>
                  <ul class="list-unstyled list-unstyled-border">
                    <?php foreach ($data_logs as $logs) : ?>
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="<?= ($logs['status_logs'] == 'login') ? base_url('stisla/assets/img/avatar/avatar-2.png') : base_url('stisla/assets/img/avatar/avatar-5.png') ?>" alt="avatar">
                      <div class="media-body">
                        <div class="float-right <?= ($logs['status_logs'] == 'login') ? 'text-success' : ''; ?>">
                          <?php 
                            // get last minute login
                            $awal  = date_create($logs['create_date']); // waktu login
                            $akhir = date_create(); // waktu sekarang
                            $diff  = date_diff($awal, $akhir);
                           ?>
                           <?= ($diff->h > 0) ? $diff->h.'j '.$diff->i.'m' : $diff->i.'m'; ?>
                        </div>
                        <div class="media-title"><?= $logs['nama_pengguna'] ?></div>
                        <span class="text-small text-muted"><?= $logs['nama_level'] ?></span>
                      </div>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                  <?php else : ?>
                    <div class="media">
                      <div class="media-body">
                        <div class="media-title text-center text-success">
                          <i class="fa fa-2x fa-file-alt"></i>
                          <div class="mt-3"> 
                            <span class="text-small"><i>Belum ada data</i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
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
                    <label class="col-sm-3 col-form-label">Bentuk</label>
                    <div class="col-sm-9">
                      <select name="bentuk" class="form-control select2 bentuk-buku" data-placeholder="Pilih" required="">
                        <option disabled selected value></option>
                        <option value="Fisik">Fisik</option>
                        <option value="Digital">Digital</option>
                      </select>
                      <?php if (form_error('bentuk')) : ?>
                      <div class="invalid-feedback">
                        Bentuk Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Bentuk Buku wajib diisi!
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
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Cover</label>
                    <div class="col-sm-9">
                      <input type="file" name="cover" class="form-control" required="">
                      <?php if (form_error('cover')) : ?>
                      <div class="invalid-feedback">
                        Cover Buku wajib diisi! <span class="text-warning">*JPG, JPEG, PNG, GIF</span>
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Cover Buku wajib diisi! <span class="text-warning">*JPG, JPEG, PNG, GIF</span>
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">File</label>
                    <div class="col-sm-9">
                      <input type="file" name="buku" class="form-control">
                      <div class="valid-feedback">Kosongkan jika tidak ada! <span class="text-warning">*PDF</span></div>
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
                    <label class="col-sm-3 col-form-label">Bentuk</label>
                    <div class="col-sm-9">
                      <select name="bentuk" class="form-control select2 bentuk-buku-ubah" data-placeholder="Pilih" id="ubah-bentuk" required="">
                        <option value="Fisik">Fisik</option>
                        <option value="Digital">Digital</option>
                      </select>
                      <?php if (form_error('bentuk')) : ?>
                      <div class="invalid-feedback">
                        Bentuk Buku wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Bentuk Buku wajib diisi!
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
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Cover</label>
                    <div class="col-sm-9">
                      <input type="file" name="cover" class="form-control">
                      <div class="valid-feedback">Kosongkan jika tidak ada perubahan! <span class="text-warning">*JPG, JPEG, PNG, GIF</span></div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">File</label>
                    <div class="col-sm-9">
                      <input type="file" name="buku" class="form-control">
                      <div class="valid-feedback">Kosongkan jika tidak ada perubahan! <span class="text-warning">*PDF</span></div>
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
                    <label class="col-sm-3 col-form-label">Bentuk</label>
                    <div class="col-sm-9">
                      <select name="bentuk" class="form-control select2 bentuk-buku-ubah" id="hapus-bentuk" data-placeholder="Pilih" disabled="">
                        <option value="Fisik">Fisik</option>
                        <option value="Digital">Digital</option>
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