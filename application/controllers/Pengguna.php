<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('M_pengguna');
		date_default_timezone_set('Asia/Jakarta');

		// cek session dan level pengguna
        if (!in_array($this->M_pengguna->cek_level(), ['2', '3', '4', '5'])) {
            redirect('login');
        }
    }

    public function index() {
		// get detail data
		$data['detail_user'] = $this->M_pengguna->get_detail_user($this->session->userdata('id'));
		$data['detail_user_header'] = $this->M_pengguna->get_detail_user_header(array($this->session->userdata('nis_nip'), $this->session->userdata('nis_nip')));

		// set ucapan salam
		$jam = date('H:i');
		if ($jam > '05:30' && $jam < '11:00') {
		    $data['salam'] = 'Pagi';
		} elseif ($jam >= '11:00' && $jam < '15:00') {
		    $data['salam'] = 'Siang';
		} elseif ($jam >= '15:00' && $jam < '18:00') {
		    $data['salam'] = 'Sore';
		} else {
		    $data['salam'] = 'Malam';
		}

		$this->vic_lib->pview('index', $data);
	}

	public function buku() {
		// get list data
		$data['data_buku'] = $this->M_pengguna->get_data_buku(array($this->session->userdata('nis_nip')));

		// get detail data
		$data['detail_user_header'] = $this->M_pengguna->get_detail_user_header(array($this->session->userdata('nis_nip'), $this->session->userdata('nis_nip')));

		$this->vic_lib->pview('index_buku', $data);
	}

	public function pinjam_buku_proses() {
		$this->form_validation->set_rules('id','ID Buku', 'trim|required');
		$this->form_validation->set_rules('no','No Buku', 'trim');

		// get input 
		$nis_nip_pengguna = $this->session->userdata('nis_nip');
		$id_buku = $this->input->post('id');
		$no_buku = $this->input->post('no');
		$detail_buku = $this->M_pengguna->get_detail_buku($id_buku);

		// cek data buku
		if (empty($detail_buku)) {
			$this->session->set_userdata('failed', 'Buku tidak ada!');
			$this->buku();
		}

		$cek_pinjam_buku = $this->M_pengguna->cek_pinjam_buku([$nis_nip_pengguna, $detail_buku['kode_buku']]);

		// cek sedang dipinjam
		if (!empty($cek_pinjam_buku)) {
			$this->session->set_userdata('failed', 'Buku sedang anda pinjam!');
			$this->buku();
		}

		$cek_sedang_dipinjam = $this->M_pengguna->cek_sedang_dipinjam([$detail_buku['kode_buku'], $no_buku]);

		if (!empty($cek_sedang_dipinjam)) {
			$this->session->set_userdata('failed', 'Buku sedang dipinjam!');
			$this->buku();
		}

		$get_sisa_buku = $this->M_pengguna->get_sisa_buku($id_buku);
		$sisa_buku = $get_sisa_buku['jumlah_buku'] - $get_sisa_buku['jumlah_dipinjam'];

		// cek sisa buku
		if ($sisa_buku <= 0) {
			$this->session->set_userdata('failed', 'Stok buku sedang kosong!');
			redirect('pengguna/buku');
		}

		if ($this->form_validation->run() !== false) {
			$params = [
				'nis_nip_pengguna' => $this->session->userdata('nis_nip'),
				'kode_buku' => $detail_buku['kode_buku'],
				'nobuku_peminjaman' => $this->input->post('no'),
				'tgl_peminjaman' => date('Y-m-d'),
				'tgl_pengembalian' => date('Y-m-d', strtotime('+3 days')),
				'status_peminjaman' => 'diajukan',
				'create_by' => $this->session->userdata('id'),
				'create_name' => $this->session->userdata('nama'),
				'create_date' => date('Y-m-d H:i:s')
			];

			if ($this->M_pengguna->insert_tbl_peminjaman($params)) {
				$this->session->set_userdata('success', 'Pinjam buku berhasil!');
				redirect('pengguna/buku');
			} else {
				$this->session->set_userdata('failed', 'Pinjam buku gagal!');
				$this->buku();
			}
		} else {
			$this->session->set_userdata('failed', 'Pinjam buku gagal!');
			$this->buku();
		}
	}

	function pinjam_buku_kembali_proses() {
		$this->form_validation->set_rules('id','ID Buku', 'trim|required');

		// get input 
		$nis_nip_pengguna = $this->session->userdata('nis_nip');
		$id_buku = $this->input->post('id');
		$detail_buku = $this->M_pengguna->get_detail_buku($id_buku);

		// cek data buku
		if (empty($detail_buku)) {
			$this->session->set_userdata('failed', 'Buku tidak ada!');
			$this->pinjam();
		}

		$id_peminjaman = $this->M_pengguna->get_id_peminjaman([$nis_nip_pengguna, $detail_buku['kode_buku']]);

		// cek id peminjaman
		if (empty($id_peminjaman)) {
			$this->session->set_userdata('failed', 'Transaksi peminjaman tidak ada!');
			$this->pinjam();
		}

		$cek_pinjam_kembali = $this->M_pengguna->cek_pinjam_kembali([$id_peminjaman, $nis_nip_pengguna, $detail_buku['kode_buku']]);

		// cek pinjam kembali
		if (!empty($cek_pinjam_kembali)) {
			$this->session->set_userdata('failed', 'Peminjaman Buku tidak ada!');
			$this->pinjam();
		}

		if ($this->form_validation->run() !== false) {
			$params = [
				'tgl_peminjaman' => date('Y-m-d'),
				'tgl_pengembalian' => date('Y-m-d', strtotime('+3 days')),
				'status_peminjaman' => 'diajukan',
				'mdb' => $this->session->userdata('id'),
				'mdb_name' => $this->session->userdata('nama'),
				'mdd' => date('Y-m-d H:i:s')
			];

			$where = ['id_peminjaman' => $id_peminjaman];

			if ($this->M_pengguna->update_tbl_peminjaman($params, $where)) {
				$this->session->set_userdata('success', 'Pinjam buku kembali berhasil!');
				redirect('pengguna/pinjam');
			} else {
				$this->session->set_userdata('failed', 'Pinjam buku kembali gagal!');
				$this->buku();
			}
		} else {
			$this->session->set_userdata('failed', 'Pinjam buku kembali gagal!');
			$this->buku();
		}
	}

	public function kembalikan_buku_proses() {
		$this->form_validation->set_rules('id','ID Buku', 'trim|required');

		// get input dan data
		$nis_nip_pengguna = $this->session->userdata('nis_nip');
		$id_buku = $this->input->post('id');
		$detail_buku = $this->M_pengguna->get_detail_buku($id_buku);

		// cek data buku
		if (empty($detail_buku)) {
			$this->session->set_userdata('failed', 'Kembalikan buku gagal!');
			$this->buku();
		}

		$id_peminjaman = $this->M_pengguna->get_id_peminjaman([$nis_nip_pengguna, $detail_buku['kode_buku']]);

		// cek id peminjaman
		if (empty($id_peminjaman)) {
			$this->session->set_userdata('failed', 'Transaksi peminjaman tidak ada!');
			$this->buku();
		}

		$detail_peminjaman = $this->M_pengguna->get_detail_peminjaman($id_peminjaman);
		$cek_pinjam_buku = $this->M_pengguna->cek_pinjam_buku([$nis_nip_pengguna, $detail_buku['kode_buku']]);

		// cek sedang dipinjam
		if (!empty($cek_pinjam_buku)) {
			$this->session->set_userdata('failed', 'Kembalikan buku gagal!');
			$this->buku();
		}

		// set denda pengembalian
        $waktu_dikembalikan  = empty($peminjaman['tgl_dikembalikan']) ? date_create($peminjaman['tgl_pengembalian']) : date_create($peminjaman['tgl_dikembalikan']); // waktu dikembalikan
      	$waktu_pengembalian = date_create($peminjaman['tgl_pengembalian']); // waktu pengembalian seharusnya
      	$diff  = date_diff($waktu_dikembalikan, $waktu_pengembalian);

        if ($diff->invert > 0) {
          $hari = $diff->d;
          $nominal = 3000;

          $denda = $hari * $nominal;
        } else {
        	$denda = 0;
        }

		if ($this->form_validation->run() !== false) {
			$params = [
				'status_peminjaman' => 'diajukan',
				'mdb' => $this->session->userdata('id'),
				'mdb_name' => $this->session->userdata('nama'),
				'mdd' => date('Y-m-d H:i:s'),
			];

			if ($detail_peminjaman['status_peminjaman'] != 'ditolak') {
				$params['tgl_dikembalikan'] = date('Y-m-d');
				$params['denda_peminjaman'] = $denda;
			}

			$where = ['id_peminjaman' => $id_peminjaman];

			if ($this->M_pengguna->update_tbl_peminjaman($params, $where)) {
				$this->session->set_userdata('success', 'Kembalikan buku berhasil!');
				redirect('pengguna/pinjam');
			} else {
				$this->session->set_userdata('failed', 'Kembalikan buku gagal!');
				$this->buku();
			}
		} else {
			$this->session->set_userdata('failed', 'Kembalikan buku gagal!');
			$this->buku();
		}
	}

	public function pinjam() {
		// get list data
		$data['data_pinjam'] = $this->M_pengguna->get_data_pinjam(array($this->session->userdata('nis_nip')));

		// get detail data
		$data['detail_user_header'] = $this->M_pengguna->get_detail_user_header(array($this->session->userdata('nis_nip'), $this->session->userdata('nis_nip')));

		$this->vic_lib->pview('index_pinjam', $data);
	}

	public function profile() {
		// get detail data
		$data['detail_user'] = $this->M_pengguna->get_detail_user_profile(array($this->session->userdata('id')));
		$data['detail_user_header'] = $this->M_pengguna->get_detail_user_header(array($this->session->userdata('nis_nip'), $this->session->userdata('nis_nip')));

		$this->vic_lib->pview('index_profile', $data);
	}

	public function ubah_profile_proses() {
		$this->form_validation->set_rules('nama','Nama Pengguna', 'trim|required');
		$this->form_validation->set_rules('pass','Password Pengguna', 'trim|required');
		$this->form_validation->set_rules('email','Email Pengguna', 'trim|required');
		$this->form_validation->set_rules('nohp','No. HP Pengguna', 'trim|required');

		// get input
		$id_pengguna = $this->input->post('id');
		$detail_pengguna = $this->M_pengguna->get_detail_user($id_pengguna);

		// cek data
		if (empty($detail_pengguna)) {
			$this->session->set_userdata('failed', 'Ubah data profil gagal!');
			$this->profile();
		}

		// cek kesamaan
		if ($id_pengguna != $this->session->userdata('id')) {
			$this->session->set_userdata('failed', 'Ubah data profil gagal!');
			$this->profile();
		}

		if ($this->form_validation->run() !== false) {
			$params = [
				'pass_pengguna' => $this->input->post('pass'),
				'nama_pengguna' => $this->input->post('nama'),
				'email_pengguna' => $this->input->post('email'),
				'nohp_pengguna' => $this->input->post('nohp'),
				'mdb' => $this->session->userdata('id'),
				'mdb_name' => $this->session->userdata('nama'),
				'mdd' => date('Y-m-d H:i:s'),
			];

			if ($this->input->post('bio') != '<p></p>' || $this->input->post('bio') != '') {
				$params['bio_pengguna'] = $this->input->post('bio');
			}

			if ($this->input->post('alamat') != '<p></p>' || $this->input->post('alamat') != '') {
				$params['alamat_pengguna'] = $this->input->post('alamat');
			}

			$where = ['id_pengguna' => $this->input->post('id')];

			if ($this->M_pengguna->update_tbl_pengguna($params, $where)) {
				$this->session->set_userdata('nama', $this->input->post('nama'));
				$this->session->set_userdata('success', 'Ubah data profile berhasil!');
				redirect('pengguna/profile');
			} else {
				$this->session->set_userdata('failed', 'Ubah data profile gagal!');
				$this->profile();
			}
		} else {
			$this->session->set_userdata('failed', 'Ubah data profile gagal!');
			$this->profile();
		}
	}

	public function logout() {
		$params = [
			'nis_nip_pengguna' => $this->session->userdata('nis_nip'),
			'status_logs' => 'logout',
			'create_by' => $this->session->userdata('id'),
			'create_name' => $this->session->userdata('nama'),
			'create_date' => date('Y-m-d H:i:s')
		];

		if ($this->M_pengguna->insert_tbl_logs($params)) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}
}