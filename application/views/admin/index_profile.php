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
          <div class="section-body">
            <h2 class="section-title">Hai, <?= $detail_user['nama_pengguna']; ?>!</h2>
            <p class="section-lead">
              Ubah informasi anda di halaman ini.
            </p>

            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                  <div class="profile-widget-header">
                    <?php $foto = isset($detail_user['foto_pengguna']) ? 'uploads/profile/'.$detail_user['foto_pengguna'] : 'img/avatar/avatar-1.png'; ?>
                    <img alt="image" src="<?= base_url('stisla/assets/'.$foto) ?>" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label"><?= $detail_user['id_level'] == '4' ? 'NIS' : 'NIP'; ?></div>
                        <div class="profile-widget-item-value"><?= $detail_user['nis_nip_pengguna']; ?></div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description">
                    <div class="profile-widget-name"><?= $detail_user['nama_pengguna'] ?> <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> <?= $detail_user['nama_level'] ?></div></div>
                    <?= $detail_user['bio_pengguna'] ?>
                  </div>
                  <div class="card-footer text-center">
                    <div class="font-weight-bold mb-2">Follow <?= $detail_user['nama_pengguna'] ?> On</div>
                    <a href="#" class="btn btn-social-icon btn-facebook mr-1">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-twitter mr-1">
                      <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-github mr-1">
                      <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-instagram">
                      <i class="fab fa-instagram"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                  <?php $attributes = ['class' => 'needs-validation was-validated', 'novalidate' => ''] ?>
                  <?= form_open_multipart('admin/ubah_profile_proses', $attributes) ?>
                  <form method="post" class="needs-validation" novalidate="">
                    <div class="card-header">
                      <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                      <input type="hidden" name="id" value="<?= $detail_user['id_pengguna'] ?>">
                      <div class="row">
                        <div class="form-group col-md-6 col-12">
                          <label>Nama</label>
                          <input type="text" name="nama" class="form-control" value="<?= $detail_user['nama_pengguna'] ?>" autocomplete="off" required="">
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
                        <div class="form-group col-md-6 col-12">
                          <label>Password</label>
                          <input type="password" name="pass" class="form-control" value="" autocomplete="off">
                          <div class="valid-feedback">Kosongkan jika tidak ada perubahan!</div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-7 col-12">
                          <label>Email</label>
                          <input type="email" name="email" class="form-control" value="<?= $detail_user['email_pengguna'] ?>" autocomplete="off">
                          <div class="valid-feedback"></div>
                        </div>
                        <div class="form-group col-md-5 col-12">
                          <label>No. HP</label>
                          <input type="text" name="nohp" class="form-control" value="<?= $detail_user['nohp_pengguna'] ?>" autocomplete="off" onkeypress="return isNumberKey(event)">
                          <div class="valid-feedback"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label>Foto</label>
                          <input type="file" name="foto" class="form-control" accept="image/png, image/gif, image/jpeg">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label>Bio</label>
                          <textarea name="bio" class="form-control summernote-simple" autocomplete="off"><?= $detail_user['bio_pengguna'] ?></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label>Alamat</label>
                          <textarea name="alamat" class="form-control summernote-simple" autocomplete="off"><?= $detail_user['alamat_pengguna'] ?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary">Simpan</button>
                    </div>
                  <?= form_close(); ?>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>