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
                  <h4 class="text-primary">Data Pengguna</h4>
                  <div class="card-header-action">
                    <a href="#" class="btn btn-primary mr-2" data-toggle="modal" data-target="#tambah-pengguna"><i class="fas fa-plus mr-2"></i>Tambah Data</a>
                    <a href="<?= base_url('assets/template/import/pengguna.xlsx'); ?>" class="btn btn-info"><i class="fas fa-download mr-2"></i>Unduh Template</a>
                    <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#import-pengguna"><i class="fas fa-upload mr-2"></i>Import Data</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-pengguna">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>NIS/NIP</th>
                          <th>Nama</th>
                          <th>Email</th>
                          <th>No. HP</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data_user as $key => $user) : ?>
                        <tr>
                          <td><?= $key+1; ?></td>
                          <td><?= $user['nis_nip_pengguna']; ?></td>
                          <td><?= $user['nama_pengguna']; ?></td>
                          <td><a href="mailto:<?= $user['email_pengguna']; ?>"><?= $user['email_pengguna']; ?></a></td>
                          <td><a href="https://wa.me/<?= $user['nohp_pengguna']; ?>" target="_blank"><?= $user['nohp_pengguna']; ?></a></td>
                          <td>
                            <?php if ($user['id_level'] == '1') : ?>
                            <div class="badge badge-success">
                            <?php elseif ($user['id_level'] == '2') : ?>
                            <div class="badge badge-info">
                            <?php elseif ($user['id_level'] == '3') : ?>
                            <div class="badge badge-warning">
                            <?php elseif ($user['id_level'] == '4') : ?>
                            <div class="badge badge-light">
                            <?php elseif ($user['id_level'] == '6') : ?>
                            <div class="badge badge-secondary">
                            <?php endif; ?>
                            <?= $user['nama_level'] ?>
                            </div>
                          <td>
                             <a class="btn btn-primary btn-action mr-1 ubah-pengguna" title="Edit" data-toggle="modal" data-target="#modal-ubah-pengguna" data-id="<?= $user['id_pengguna']; ?>" data-level="<?= $user['id_level']; ?>" data-nis-nip="<?= $user['nis_nip_pengguna']; ?>" data-nama="<?= $user['nama_pengguna']; ?>" data-pass="<?= $user['pass_pengguna']; ?>" data-email="<?= $user['email_pengguna']; ?>" data-nohp="<?= $user['nohp_pengguna'] ?>" data-bio="<?= $user['bio_pengguna']; ?>" data-alamat="<?= $user['alamat_pengguna']; ?>"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn btn-danger btn-action hapus-pengguna" title="Delete" data-toggle="modal" data-target="#modal-hapus-pengguna" data-id="<?= $user['id_pengguna']; ?>" data-level="<?= $user['id_level']; ?>" data-nis-nip="<?= $user['nis_nip_pengguna']; ?>" data-nama="<?= $user['nama_pengguna']; ?>" data-pass="<?= $user['pass_pengguna']; ?>" data-email="<?= $user['email_pengguna']; ?>" data-nohp="<?= $user['nohp_pengguna'] ?>" data-bio="<?= $user['bio_pengguna']; ?>" data-alamat="<?= $user['alamat_pengguna']; ?>"><i class="fas fa-trash"></i></a>
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
        <!-- Start modal tambah pengguna -->
        <?php $attributes = ['class' => 'needs-validation was-validated', 'novalidate' => ''] ?>
        <?= form_open('admin/tambah_pengguna_proses', $attributes) ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="tambah-pengguna">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Tambah Pengguna</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Level</label>
                    <div class="col-sm-9">
                      <select name="level" class="form-control select2 level-pengguna" data-placeholder="Pilih" required="">
                        <option disabled selected value></option>
                        <?php foreach($data_level as $level) : ?> 
                        <option value="<?= $level['id_level'] ?>" <?= set_select('level', $level['id_level']); ?>><?= $level['nama_level'] ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?php if (form_error('level')) : ?>
                      <div class="invalid-feedback">
                        Level Pengguna wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Level Pengguna wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">NIS/NIP</label>
                    <div class="col-sm-9">
                      <input type="text" name="nis_nip" class="form-control" required="" autocomplete="off" value="<?= set_value('nis_nip') ?>" onkeypress="return isNumberKey(event)">
                      <?php if (form_error('nis_nip')) : ?>
                      <div class="invalid-feedback">
                        NIS/NIP Pengguna wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        NIS/NIP Pengguna wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" name="nama" class="form-control" required="" autocomplete="off" value="<?= set_value('nama') ?>">
                      <?php if (form_error('nama')) : ?>
                      <div class="invalid-feedback">
                        Nama Pengguna wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Nama Pengguna wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                      <input type="password" name="pass" class="form-control" required="" autocomplete="off" value="<?= set_value('pass') ?>">
                      <?php if (form_error('pass')) : ?>
                      <div class="invalid-feedback">
                        Password Pengguna wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Password Pengguna wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" name="email" class="form-control" required="" autocomplete="off" value="<?= set_value('email') ?>">
                      <?php if (form_error('email')) : ?>
                      <div class="invalid-feedback">
                        Email Pengguna wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Email Pengguna wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No. HP</label>
                    <div class="col-sm-9">
                      <input type="text" name="nohp" class="form-control nohp-input" required="" autocomplete="off" value="<?= set_value('nohp') ?>" onkeypress="return isNumberKey(event)">
                      <?php if (form_error('nohp')) : ?>
                      <div class="invalid-feedback">
                        No. HP Pengguna wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                       No. HP Pengguna wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Bio</label>
                    <div class="col-sm-9">
                      <textarea name="bio" class="summernote-simple" autocomplete="off"></textarea>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                      <textarea name="alamat" class="summernote-simple" autocomplete="off"></textarea>
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
        <!-- End modal tambah pengguna -->
        <!-- Start modal ubah pengguna -->
        <?php $attributes = ['class' => 'needs-validation was-validated', 'novalidate' => ''] ?>
        <?= form_open_multipart('admin/ubah_pengguna_proses', $attributes) ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="modal-ubah-pengguna">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Ubah Pengguna</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" id="ubah-id" value="<?= set_value('id') ?>">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Level</label>
                    <div class="col-sm-9">
                      <select name="level" class="form-control select2 level-pengguna-ubah" id="ubah-level" data-placeholder="Pilih" required="">
                        <?php foreach($data_level as $level) : ?> 
                        <option value="<?= $level['id_level'] ?>"><?= $level['nama_level'] ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?php if (form_error('level')) : ?>
                      <div class="invalid-feedback">
                        Level Pengguna wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Level Pengguna wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">NIS/NIP</label>
                    <div class="col-sm-9">
                      <input type="text" name="nis_nip" class="form-control" id="ubah-nis-nip" required="" autocomplete="off" value="<?= set_value('nis_nip') ?>" onkeypress="return isNumberKey(event)">
                      <?php if (form_error('nis_nip')) : ?>
                      <div class="invalid-feedback">
                        NIS/NIP Pengguna wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        NIS/NIP Pengguna wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" name="nama" class="form-control" id="ubah-nama" required="" autocomplete="off" value="<?= set_value('nama') ?>">
                      <?php if (form_error('nama')) : ?>
                      <div class="invalid-feedback">
                        Nama Pengguna wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Nama Pengguna wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                      <input type="password" name="pass" class="form-control" id="ubah-pass" required="" autocomplete="off" value="<?= set_value('pass') ?>">
                      <?php if (form_error('pass')) : ?>
                      <div class="invalid-feedback">
                        Password Pengguna wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Password Pengguna wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" name="email" class="form-control" id="ubah-email" required="" autocomplete="off" value="<?= set_value('email') ?>">
                      <?php if (form_error('email')) : ?>
                      <div class="invalid-feedback">
                        Email Pengguna wajib diisi!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        Email Pengguna wajib diisi!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No. HP</label>
                    <div class="col-sm-9">
                      <input type="text" name="nohp" class="form-control" id="ubah-nohp" required="" autocomplete="off" value="<?= set_value('nohp') ?>" onkeypress="return isNumberKey(event)">
                      <?php if (form_error('nohp')) : ?>
                      <div class="invalid-feedback">
                        No. HP Pengguna wajib diisi dan berawalan +62!
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                       No. HP Pengguna wajib diisi dan berawalan +62!
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Bio</label>
                    <div class="col-sm-9">
                      <textarea name="bio" class="summernote-simple" id="ubah-bio" autocomplete="off"><?= set_value('bio') ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                      <textarea name="alamat" class="summernote-simple" id="ubah-alamat" autocomplete="off"><?= set_value('alamat') ?></textarea>
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
        <!-- End modal ubah pengguna -->
        <!-- Start modal hapus pengguna -->
        <?= form_open('admin/hapus_pengguna_proses') ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="modal-hapus-pengguna">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Hapus Pengguna</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" id="hapus-id" value="<?= set_value('id') ?>">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Level</label>
                    <div class="col-sm-9">
                      <select name="level" class="form-control select2 level-pengguna-ubah" id="hapus-level" data-placeholder="Pilih" disabled="">
                        <?php foreach($data_level as $level) : ?> 
                        <option value="<?= $level['id_level'] ?>"><?= $level['nama_level'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">NIS/NIP</label>
                    <div class="col-sm-9">
                      <input type="text" name="nis_nip" class="form-control" id="hapus-nis-nip" value="<?= set_value('nis_nip') ?>" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" name="nama" class="form-control" id="hapus-nama" value="<?= set_value('nama') ?>" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                      <input type="password" name="pass" class="form-control" id="hapus-pass" value="<?= set_value('pass') ?>" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" name="email" class="form-control" id="hapus-email" value="<?= set_value('email') ?>" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No. HP</label>
                    <div class="col-sm-9">
                      <input type="text" name="nohp" class="form-control" id="hapus-nohp" value="<?= set_value('nohp') ?>" disabled="">
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Bio</label>
                    <div class="col-sm-9">
                      <textarea name="bio" class="summernote-simple" id="hapus-bio"><?= set_value('bio') ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                      <textarea name="alamat" class="summernote-simple" id="hapus-alamat"><?= set_value('alamat') ?></textarea>
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
        <!-- End modal hapus pengguna -->
        <!-- Start modal import peminjaman -->
        <?php $attributes = ['class' => 'needs-validation was-validated', 'novalidate' => ''] ?>
        <?= form_open_multipart('admin/import_pengguna_proses', $attributes) ?>
          <div class="modal fade" tabindex="-1" role="dialog" id="import-pengguna">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Import Data Pengguna</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">File</label>
                    <div class="col-sm-9">
                      <input type="file" name="file_excel" class="form-control" required="">
                      <?php if (form_error('file_excel')) : ?>
                      <div class="invalid-feedback">
                        File Excel wajib diisi! <span class="text-warning">*XLS, XLSX, CSV</span>
                      </div>
                      <?php else : ?>
                      <div class="invalid-feedback">
                        File Excel wajib diisi! <span class="text-warning">*XLS, XLSX, CSV</span>
                      </div>
                      <?php endif; ?>
                      <div class="valid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Unggah</button>
                </div>
              </div>
            </div>
          </div>
        <?= form_close(); ?>
        <!-- End modal import peminjaman -->
       </div> 