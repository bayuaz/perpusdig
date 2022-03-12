      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#">PERPUSDIG</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">PPD</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="<?= ($this->uri->uri_string() == 'admin' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses') ? 'active' : '' ?>"><a class="nav-link" href="<?= ($this->uri->uri_string() == 'admin' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses') ? '#' : base_url('admin') ?>"><i class="fas fa-home"></i> <span>Home</span></a></li>
            <li class="menu-header">Pages</li>
            <li class="<?= ($this->uri->uri_string() == 'admin/buku' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses') ? 'active' : '' ?>"><a class="nav-link" href="<?= ($this->uri->uri_string() == 'admin/buku' || $this->uri->uri_string() == 'admin/tambah_buku_proses' || $this->uri->uri_string() == 'admin/ubah_buku_proses' || $this->uri->uri_string() == 'admin/hapus_buku_proses') ? '#' : base_url('admin/buku') ?>"><i class="fas fa-book"></i> <span>Buku</span></a></li>
            <li class="<?= ($this->uri->uri_string() == 'admin/kategori' || $this->uri->uri_string() == 'admin/tambah_kategori_proses' || $this->uri->uri_string() == 'admin/ubah_kategori_proses' || $this->uri->uri_string() == 'admin/hapus_kategori_proses') ? 'active' : '' ?>"><a class="nav-link" href="<?= ($this->uri->uri_string() == 'admin/kategori' || $this->uri->uri_string() == 'admin/tambah_kategori_proses' || $this->uri->uri_string() == 'admin/ubah_kategori_proses' || $this->uri->uri_string() == 'admin/hapus_kategori_proses') ? '#' : base_url('admin/kategori') ?>"><i class="fas fa-th"></i> <span>Kategori</span></a></li>
            <li class="<?= ($this->uri->uri_string() == 'admin/peminjaman' || $this->uri->uri_string() == 'admin/pinjam_buku_proses') ? 'active' : '' ?>"><a class="nav-link" href="<?= ($this->uri->uri_string() == 'admin/peminjaman' || $this->uri->uri_string() == 'admin/pinjam_buku_proses') ? '#' : base_url('admin/peminjaman') ?>"><i class="fas fa-book-reader"></i> <span>Peminjaman</span></a></li>
            <li class="<?= ($this->uri->uri_string() == 'admin/pengguna' || $this->uri->uri_string() == 'admin/tambah_pengguna_proses' || $this->uri->uri_string() == 'admin/ubah_pengguna_proses' || $this->uri->uri_string() == 'admin/hapus_pengguna_proses') ? 'active' : '' ?>"><a class="nav-link" href="<?= ($this->uri->uri_string() == 'admin/pengguna' || $this->uri->uri_string() == 'admin/tambah_pengguna_proses' || $this->uri->uri_string() == 'admin/ubah_pengguna_proses' || $this->uri->uri_string() == 'admin/hapus_pengguna_proses') ? '#' : base_url('admin/pengguna') ?>"><i class="fas fa-user"></i> <span>Pengguna</span></a></li>
            <li class="<?= ($this->uri->uri_string() == 'admin/level' || $this->uri->uri_string() == 'admin/tambah_level_proses' || $this->uri->uri_string() == 'admin/ubah_level_proses' || $this->uri->uri_string() == 'admin/hapus_level_proses') ? 'active' : '' ?>"><a class="nav-link" href="<?= ($this->uri->uri_string() == 'admin/level' || $this->uri->uri_string() == 'admin/tambah_level_proses' || $this->uri->uri_string() == 'admin/ubah_level_proses' || $this->uri->uri_string() == 'admin/hapus_level_proses') ? '#' : base_url('admin/level') ?>"><i class="fas fa-users"></i> <span>Level</span></a></li>
          </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="https://smpnegeri1datuklimapuluh.sch.id/" target="_blank" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Web Utama
              </a>
            </div>
        </aside>
      </div>