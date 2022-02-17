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
            <li class="<?= ($this->uri->uri_string() == 'pengguna') ? 'active' : '' ?>"><a class="nav-link" href="<?= ($this->uri->uri_string() == 'pengguna') ? '#' : base_url('pengguna') ?>"><i class="fas fa-home"></i> <span>Home</span></a></li>
            <li class="menu-header">Pages</li>
            <li class="<?= ($this->uri->uri_string() == 'pengguna/buku' || $this->uri->uri_string() == 'pengguna/pinjam_buku_proses' || $this->uri->uri_string() == 'pengguna/kembalikan_buku_proses') ? 'active' : '' ?>"><a class="nav-link" href="<?= ($this->uri->uri_string() == 'pengguna/buku' || $this->uri->uri_string() == 'pengguna/pinjam_buku_proses' || $this->uri->uri_string() == 'pengguna/kembalikan_buku_proses') ? '#' : base_url('pengguna/buku') ?>"><i class="fas fa-book"></i> <span>Buku</span></a></li>
            <li class="<?= ($this->uri->uri_string() == 'pengguna/pinjam' || $this->uri->uri_string() == 'pengguna/kembalikan_buku_proses') ? 'active' : '' ?>"><a class="nav-link" href="<?= ($this->uri->uri_string() == 'pengguna/pinjam' || $this->uri->uri_string() == 'pengguna/kembalikan_buku_proses') ? '#' : base_url('pengguna/pinjam') ?>"><i class="fas fa-book-reader"></i> <span>Dipinjam</span></a></li>
          </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="https://smpnegeri1datuklimapuluh.sch.id/" target="_blank" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Web Utama
              </a>
            </div>
        </aside>
      </div>