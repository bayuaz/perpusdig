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
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data_peminjaman as $key => $peminjaman) : ?>
                        <tr>
                          <td><?= $key+1; ?></td>
                          <td><?= $peminjaman['nama_pengguna'] ?></td>
                          <td><?= $peminjaman['judul_buku'] ?></td>
                          <td><?= tglIndo($peminjaman['tgl_peminjaman']) ?></td>
                          <?php 
                          $waktu_dikembalikan  = empty($peminjaman['tgl_dikembalikan']) ? date_create($peminjaman['tgl_pengembalian']) : date_create($peminjaman['tgl_dikembalikan']); // waktu dikembalikan
                          $waktu_pengembalian = date_create($peminjaman['tgl_pengembalian']); // waktu pengembalian seharusnya
                          $diff  = date_diff($waktu_dikembalikan, $waktu_pengembalian);

                          $dikembalikan = empty($peminjaman['tgl_dikembalikan']) ? $peminjaman['tgl_pengembalian'] : $peminjaman['tgl_dikembalikan'];
                          ?>
                          <td class="<?= $diff->invert > 0 ? 'text-danger' : 'text-success'; ?>"><?= empty($peminjaman['tgl_dikembalikan']) ? tglIndo($peminjaman['tgl_pengembalian']) : tglIndo($peminjaman['tgl_dikembalikan']) ?></td>
                          <td>
                            <?php

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
                          <td>
                            <div class="pull-right"><?= rupiah($peminjaman['denda_peminjaman']); ?></div>
                          </td>
                          <td>
                            <?php if ($peminjaman['status_peminjaman'] == 'diajukan') : ?>
                            <a class="btn btn-primary btn-action mr-1 proses-peminjaman" title="Proses Peminjaman" data-toggle="modal" data-target="#modal-proses-peminjaman" data-id-pengguna="<?= $peminjaman['id_pengguna']; ?>" data-id-buku="<?= $peminjaman['id_buku']; ?>" data-judul="<?= $peminjaman['judul_buku']; ?>" data-nama="<?= $peminjaman['nama_pengguna'] ?>" data-tgl-pinjam="<?= hariIndo(date('l', strtotime($peminjaman['tgl_peminjaman']))) . ', ' . tglIndo($peminjaman['tgl_peminjaman']) ?>" data-tgl-kembali="<?= hariIndo(date('l', strtotime($peminjaman['tgl_pengembalian']))) . ', ' . tglIndo($peminjaman['tgl_pengembalian']) ?>" data-tgl-dikembalikan="<?= empty($peminjaman['tgl_dikembalikan']) ? '' : hariIndo(date('l', strtotime($peminjaman['tgl_dikembalikan']))) . ', ' . tglIndo(date($peminjaman['tgl_dikembalikan'])) ?>" data-denda="<?= $peminjaman['status_peminjaman'] == 'dikembalikan' ? rupiah($peminjaman['denda_peminjaman']) : ($diff->invert > 0 ? rupiah($denda) : rupiah(0)) ?>" data-status="<?= empty($peminjaman['tgl_dikembalikan']) ? 'Pinjam Buku' : 'Kembalikan Buku'; ?>"><i class="fas fa-edit"></i></a>
                            <?php else : ?>
                            <a class="btn btn-info btn-action mr-1 info-peminjaman" title="Info Peminjaman" data-toggle="modal" data-target="#modal-info-peminjaman" data-judul="<?= $peminjaman['judul_buku']; ?>" data-nama="<?= $peminjaman['nama_pengguna'] ?>" data-tgl-pinjam="<?= hariIndo(date('l', strtotime($peminjaman['tgl_peminjaman']))) . ', ' . tglIndo($peminjaman['tgl_peminjaman']) ?>" data-tgl-kembali="<?= hariIndo(date('l', strtotime($peminjaman['tgl_pengembalian']))) . ', ' . tglIndo($peminjaman['tgl_pengembalian']) ?>" data-tgl-dikembalikan="<?= empty($peminjaman['tgl_dikembalikan']) ? '' : hariIndo(date('l', strtotime($peminjaman['tgl_dikembalikan']))) . ', ' . tglIndo(date($peminjaman['tgl_dikembalikan'])) ?>" data-denda="<?= $peminjaman['status_peminjaman'] == 'dikembalikan' ? rupiah($peminjaman['denda_peminjaman']) : ($diff->invert > 0 ? rupiah($denda) : rupiah(0)) ?>"><i class="fas fa-info-circle"></i></a>
                            <?php endif; ?>
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
        <!-- Start modal proses buku -->
        <?= form_open('admin/pinjam_buku_proses') ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="modal-proses-peminjaman">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="proses-pinjam-status"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id_pengguna" id="proses-pinjam-id-pengguna" value="<?= set_value('id_pengguna') ?>">
                  <input type="hidden" name="id_buku" id="proses-pinjam-id-buku" value="<?= set_value('id_buku') ?>">
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <p id="proses-pinjam-nama"></p>
                    </div>
                    <label class="col-sm-3 col-form-label">Judul</label>
                    <div class="col-sm-9">
                      <p id="proses-pinjam-judul"></p>
                    </div>
                    <label class="col-sm-3 col-form-label">Pinjam</label>
                    <div class="col-sm-9">
                      <p id="proses-pinjam-tgl-pinjam"></p>
                    </div>
                    <label class="col-sm-3 col-form-label">Kembali</label>
                    <div class="col-sm-9">
                      <p id="proses-pinjam-tgl-kembali"></p>
                    </div>
                    <label class="col-sm-3 col-form-label" id="proses-label-dikembalikan">Dikembalikan</label>
                    <div class="col-sm-9">
                      <p id="proses-pinjam-tgl-dikembalikan"></p>
                    </div>
                    <label class="col-sm-3 col-form-label" id="proses-label-denda">Denda</label>
                    <div class="col-sm-9">
                      <p id="proses-pinjam-denda"></p>
                    </div>
                  </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                  <button type="submit" name="action" value="Tolak" class="btn btn-danger" id="tolak-peminjaman">Tolak</button>
                  <button type="submit" name="action" value="Setujui" class="btn btn-success" id="setujui-peminjaman">Setujui</button>
                </div>
              </div>
            </div>
          </div>
        <?= form_close(); ?>
        <!-- End modal proses buku -->
        <!-- Start modal kembalikan buku -->
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-info-peminjaman">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Info Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group row mb-0">
                  <label class="col-sm-3 col-form-label">Nama</label>
                  <div class="col-sm-9">
                    <p id="info-peminjaman-nama"></p>
                  </div>
                  <label class="col-sm-3 col-form-label">Judul</label>
                  <div class="col-sm-9">
                    <p id="info-peminjaman-judul"></p>
                  </div>
                  <label class="col-sm-3 col-form-label">Pinjam</label>
                  <div class="col-sm-9">
                    <p id="info-peminjaman-tgl-pinjam"></p>
                  </div>
                  <label class="col-sm-3 col-form-label">Kembali</label>
                  <div class="col-sm-9">
                    <p id="info-peminjaman-tgl-kembali"></p>
                  </div>
                  <label class="col-sm-3 col-form-label" id="info-label-dikembalikan">Dikembalikan</label>
                  <div class="col-sm-9">
                    <p id="info-peminjaman-tgl-dikembalikan"></p>
                  </div>
                  <label class="col-sm-3 col-form-label" id="info-label-denda">Denda</label>
                  <div class="col-sm-9">
                    <p class="font-weight-bold" id="info-peminjaman-denda"></p>
                  </div>
                </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End modal kembalikan buku -->
       </div> 