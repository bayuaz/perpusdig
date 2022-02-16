<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('M_login');

		// cek status login
		if ($this->M_login->cek_status() == 'login') {
			if ($this->M_login->cek_level() == '1') {
				redirect('admin');
			} elseif (in_array($this->M_login->cek_level(), ['2', '3', '4'])) {
				redirect('pengguna');
			} else {
				redirect('login');
			}
		}
	}

	public function index() {
		if (empty($this->input->post())) {
			$this->load->view('login/index');
		} else {
			$this->form_validation->set_rules('nis_nip','NIS / NIP', 'trim|required');
			$this->form_validation->set_rules('password','Password', 'trim|required');

			if ($this->form_validation->run() !== false) {
				$nis_nip = $this->input->post('nis_nip');
				$password = $this->input->post('password');

				// cek login
				$cek = $this->M_login->cek(array($nis_nip, $password));

				if (!empty($cek)) {
					$params = [
						'id_pengguna' => $cek['id_pengguna'],
						'status_logs' => 'login',
						'create_by' => $cek['id_pengguna'],
						'create_name' => $cek['nama_pengguna'],
						'create_date' => date('Y-m-d H:i:s')
					];

					if ($this->M_login->insert_tbl_logs($params)) {
						$session = array(
							'id' => $cek['id_pengguna'],
		                    'nama' => $cek['nama_pengguna'],
		                    'nis_nip' => $cek['nis_nip_pengguna'],
		                    'level' => $cek['id_level'],
		                    'status' => 'login'
		                );

		                $this->session->set_userdata($session);

		                if ($cek['id_level'] == '1') {	
		                	$this->session->set_userdata('success', 'Anda berhasil login!');
		                	redirect('admin');
		                } elseif (in_array($cek['id_level'], ['2', '3', '4'])) {
		                	$this->session->set_userdata('success', 'Anda berhasil login!');
		                	redirect('pengguna');
		                } else {
		                	redirect('login');
		                }
					} else {
						$data['error'] = 'Username dan Password yang anda masukkan salah!';
						$this->load->view('login/index', $data);
					}
				} else {
					$data['error'] = 'Username dan Password yang anda masukkan salah!';
					$this->load->view('login/index', $data);
				}
			} else {
				$data['error'] = 'Periksa kembali inputan form!';
				$this->load->view('login/index', $data);
			}
		}
	}
}