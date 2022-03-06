<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('M_pengguna');
		date_default_timezone_set('Asia/Jakarta');

		// cek session dan level pengguna
        if (!in_array($this->M_pengguna->cek_level(), ['2', '3', '4'])) {
            redirect('login');
        }
    }

    public function index() {
		// get detail data
		$data['detail_user'] = $this->M_pengguna->get_detail_user($this->session->userdata('id'));
		$data['detail_user_header'] = $this->M_pengguna->get_detail_user_header(array($this->session->userdata('id'), $this->session->userdata('id')));

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
		$data['data_buku'] = $this->M_pengguna->get_data_buku(array($this->session->userdata('id')));

		// get detail data
		$data['detail_user_header'] = $this->M_pengguna->get_detail_user_header(array($this->session->userdata('id'), $this->session->userdata('id')));

		$this->vic_lib->pview('index_buku', $data);
	}

	public function pinjam_buku_proses() {
		$this->form_validation->set_rules('id','ID Buku', 'trim|required');

		// get input 
		$id_pengguna = $this->session->userdata('id');
		$id_buku = $this->input->post('id');
		$params_id = [$id_pengguna, $id_buku];
		$detail_buku = $this->M_pengguna->get_detail_buku($id_buku);
		$cek_pinjam_buku = $this->M_pengguna->cek_pinjam_buku($params_id);

		// cek data buku
		if (empty($detail_buku)) {
			$this->session->set_userdata('failed', 'Buku tidak ada!');
			$this->buku();
		}

		// cek sedang dipinjam
		if (!empty($cek_pinjam_buku)) {
			$this->session->set_userdata('failed', 'Buku sedang anda pinjam!');
			$this->buku();
		}

		if ($this->form_validation->run() !== false) {
			$params = [
				'id_pengguna' => $this->session->userdata('id'),
				'id_buku' => $this->input->post('id'),
				'tgl_peminjaman' => date('Y-m-d'),
				'tgl_pengembalian' => date('Y-m-d', strtotime('+3 days')),
				'status_peminjaman' => 'diajukan',
				'create_by' => $this->session->userdata('id'),
				'create_name' => $this->session->userdata('nama'),
				'create_date' => date('Y-m-d H:i:s'),
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

	public function kembalikan_buku_proses() {
		print_r($_POST);
		$this->form_validation->set_rules('id','ID Buku', 'trim|required');

		// get input dan data
		$id_pengguna = $this->session->userdata('id');
		$id_buku = $this->input->post('id');
		$params_id = [$id_pengguna, $id_buku];
		$id_peminjaman = $this->M_pengguna->get_id_peminjaman($params_id);
		print_r($id_peminjaman);die;
		$detail_buku = $this->M_pengguna->get_detail_buku($id_buku);
		$detail_peminjaman = $this->M_pengguna->get_detail_peminjaman($id_peminjaman);
		$cek_pinjam_buku = $this->M_pengguna->cek_pinjam_buku($params_id);

		// set denda pengembalian
		$waktu_pengembalian  = date_create($pinjam['tgl_pengembalian']); // waktu pengembalian
        $waktu_sekarang = date_create(); // waktu sekarang
        $diff  = date_diff($waktu_sekarang, $waktu_pengembalian);
        $denda = 2000 * $diff->d;

		// cek data buku
		if (empty($detail_buku)) {
			$this->session->set_userdata('failed', 'Kembalikan buku gagal!');
			$this->buku();
		}

		// cek sedang dipinjam
		if (!empty($cek_pinjam_buku)) {
			$this->session->set_userdata('failed', 'Kembalikan buku gagal!');
			$this->buku();
		}

		if (empty($id_peminjaman)) {
			$this->session->set_userdata('failed', 'Transaksi peminjaman tidak ada!');
			$this->buku();
		}

		if ($this->form_validation->run() !== false) {
			$params = [
				'status_peminjaman' => 'dikembalikan',
				'tgl_dikembalikan' => date('Y-m-d'),
				'denda_peminjaman' => $denda,
				'status_peminjaman' => 'dikembalikan',
				'mdb' => $this->session->userdata('id'),
				'mdb_name' => $this->session->userdata('nama'),
				'mdd' => date('Y-m-d H:i:s'),
			];

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
		$data['data_pinjam'] = $this->M_pengguna->get_data_pinjam(array($this->session->userdata('id')));

		// get detail data
		$data['detail_user_header'] = $this->M_pengguna->get_detail_user_header(array($this->session->userdata('id'), $this->session->userdata('id')));

		$this->vic_lib->pview('index_pinjam', $data);
	}

	public function profile() {
		// get detail data
		$data['detail_user'] = $this->M_pengguna->get_detail_user_profile(array($this->session->userdata('id')));
		$data['detail_user_header'] = $this->M_pengguna->get_detail_user_header(array($this->session->userdata('id'), $this->session->userdata('id')));

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
			'id_pengguna' => $this->session->userdata('id'),
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