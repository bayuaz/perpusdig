<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class Admin extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('M_admin');
		date_default_timezone_set('Asia/Jakarta');

		//cek session dan level admin
        if ($this->M_admin->cek_level() != '1') {
            redirect("login");
        }
	}

	public function index() {
		//judul
		$data['title'] = 'Sistem Informasi Perpustakaan - SMPN 2 Limapuluh';

		// get total data
		$data['total_user'] = $this->M_admin->get_total_user();
		$data['total_buku_fisik'] = $this->M_admin->get_total_buku_fisik();
		$data['total_buku_digital'] = $this->M_admin->get_total_buku_digital();
		$data['total_peminjaman'] = $this->M_admin->get_total_peminjaman();

		// get list data
		$data['data_buku_terbaru'] = $this->M_admin->get_data_buku_terbaru();
		$data['data_peminjaman_terbaru'] = $this->M_admin->get_data_peminjaman_terbaru();
		$data['data_logs'] = $this->M_admin->get_data_logs();
		$data['data_sering_dipinjam'] = $this->M_admin->get_data_sering_dipinjam();
		$data['data_kategori'] = $this->M_admin->get_data_kategori();
		$data['data_sering_login'] = $this->M_admin->get_data_sering_login();

		// get detail data
		$data['detail_user_header'] = $this->M_admin->get_detail_user_header(array($this->session->userdata('nis_nip'), $this->session->userdata('nis_nip')));
		$data['detail_logs_user'] = $this->M_admin->get_detail_logs_user(array($this->session->userdata('nis_nip')));

		$this->load->view('admin/menu/header', $data);
		$this->load->view('admin/menu/sidebar', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('admin/menu/footer', $data);
	}

	public function buku() {
		// get list data
		$data['data_buku'] = $this->M_admin->get_data_buku();
		$data['data_kategori'] = $this->M_admin->get_data_kategori();

		// get detail data
		$data['detail_user_header'] = $this->M_admin->get_detail_user_header(array($this->session->userdata('nis_nip'), $this->session->userdata('nis_nip')));

		$this->vic_lib->aview('index_buku', $data);
	}

	public function import_buku_proses() {
		// file type
        $file_mimes = [
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        if (isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {

            $arr_file = explode('.', $_FILES['file_excel']['name']); // get file
            $extension = end($arr_file); // get file extension

            // select spreadsheet reader depends on file extension
            if ($extension == 'csv') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else if ($extension == 'xlsx'){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $this->session->set_userdata('failed', 'Ekstensi file tidak dikenali!');
                redirect('admin/buku');
            }

            // 'Data' Table
            $dataList = [];
            $dataListArray = [];

            $reader->setReadDataOnly(true);

            //Get filename
            $objPHPExcel = $reader->load($_FILES['file_excel']['tmp_name']);
            
            //Get sheet by name
            $worksheet = $objPHPExcel->getSheetByName('Buku');

            /*
            * Get sheet by index
            * Get the second sheet in the workbook
            * Note that sheets are indexed from 0
            */ 
            // $spreadsheet->getSheet(1);

            /*
            * Get current active sheet
            */ 

            //$spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow(); // e.g. 12
            $highestColumn = $worksheet->getHighestColumn(); // e.g M'

            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 7
            //Ignoring first row (As it contains column name)
            for ($row = 8; $row <= $highestRow; ++$row) {
                //A row selected
                for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                    // values till $cityList['1'] till $cityList['last_column_no'] 
                    $dataList[$col] = $worksheet->getCellByColumnAndRow($col, $row)->getValue(); 
                } 

                array_push($dataListArray, $dataList);
                //next row, from top
            }

            // print_r($dataListArray);
            
            if ($this->M_admin->import_buku($dataListArray) == TRUE) {
                // what to do if import successfull
                $this->session->set_userdata('success', 'Import data buku berhasil!');
                redirect('admin/buku');
			} else {
                // what to do if import failed
				$this->session->set_userdata('failed', 'Import data buku gagal!');
                redirect('admin/buku');
			}
        } else {
			$this->session->set_userdata('failed', 'Import data buku gagal!');
            redirect('admin/buku');
        }
	}

	public function tambah_buku_proses() {
		$this->form_validation->set_rules('kode','Kode Buku', 'trim|required');
		$this->form_validation->set_rules('kategori','Kategori Buku', 'trim|required');
		$this->form_validation->set_rules('bentuk','Bentuk Buku', 'trim|required');
		$this->form_validation->set_rules('judul','Judul Buku', 'trim|required');
		$this->form_validation->set_rules('pengarang','Pengarang Buku', 'trim|required');
		$this->form_validation->set_rules('penerbit','Penerbit Buku', 'trim|required');
		$this->form_validation->set_rules('tahun_terbit','Tahun Terbit Buku', 'trim|required');
		$this->form_validation->set_rules('jumlah','Jumlah Buku', 'trim|required');
		if (empty($_FILES['cover']['name'])) {
		    $this->form_validation->set_rules('cover', 'Cover Buku', 'required');
		}

		// print_r($_POST);
		// echo "<br>";
		// print_r($_FILES);die;

		if ($this->form_validation->run() !== false) {
			// upload config cover
            $config_cover['upload_path'] = 'stisla/assets/uploads/cover/';
            $config_cover['allowed_types'] = 'jpg|jpeg|png|gif';
            $config_cover['max_size'] = '2000';
            // inisiasi config
            $this->upload->initialize($config_cover);
            // proses upload gambar
            if ($this->upload->do_upload('cover')) {
            	$data_cover = $this->upload->data();

            	if (!empty($_FILES['buku']['name'])) {
            		// upload config file
		            $config_file['upload_path'] = 'stisla/assets/uploads/files/';
		            $config_file['allowed_types'] = 'pdf';
		            $config_file['max_size'] = '5000';
		            // inisiasi config
		            $this->upload->initialize($config_file);

	            	if ($this->upload->do_upload('buku')) {
	            		$data_file = $this->upload->data();

						$params = [
							'id_kategori' => $this->input->post('kategori'),
							'bentuk_buku' => $this->input->post('bentuk'),
							'judul_buku' => $this->input->post('judul'),
							'kode_buku' => $this->input->post('kode'),
							'pengarang_buku' => $this->input->post('pengarang'),
							'penerbit_buku' => $this->input->post('penerbit'),
							'tahun_terbit_buku' => $this->input->post('tahun_terbit'),
							'jumlah_buku' => str_replace(',', '', $this->input->post('jumlah')),
							'cover_buku' => $data_cover['file_name'],
							'file_buku' => $data_file['file_name'],
							'create_by' => $this->session->userdata('id'),
							'create_name' => $this->session->userdata('nama'),
							'create_date' => date('Y-m-d H:i:s'),
						];

						if ($this->M_admin->insert_tbl_buku($params)) {
							$this->session->set_userdata('success', 'Tambah data buku berhasil!');
							($this->input->post('no-redirect')) ? redirect('admin/buku') : redirect('admin');
						} else {
							$this->session->set_userdata('failed', 'Tambah data buku gagal 1!');
							($this->input->post('no-redirect')) ? $this->buku() : $this->index();
						}
	            	} else {
	            		$this->session->set_userdata('failed', 'Tambah data buku gagal 2!');
						($this->input->post('no-redirect')) ? $this->buku() : $this->index();
	            	}
            	} else {
            		$params = [
						'id_kategori' => $this->input->post('kategori'),
						'kode_buku' => $this->input->post('kode'),
						'bentuk_buku' => $this->input->post('bentuk'),
						'judul_buku' => $this->input->post('judul'),
						'pengarang_buku' => $this->input->post('pengarang'),
						'penerbit_buku' => $this->input->post('penerbit'),
						'tahun_terbit_buku' => $this->input->post('tahun_terbit'),
						'jumlah_buku' => str_replace(',', '', $this->input->post('jumlah')),
						'cover_buku' => $data_cover['file_name'],
						'create_by' => $this->session->userdata('nis_nip'),
						'create_name' => $this->session->userdata('nama'),
						'create_date' => date('Y-m-d H:i:s'),
					];

					if ($this->M_admin->insert_tbl_buku($params)) {
						$this->session->set_userdata('success', 'Tambah data buku berhasil!');
						($this->input->post('no-redirect')) ? redirect('admin/buku') : redirect('admin');
					} else {
						$this->session->set_userdata('failed', 'Tambah data buku gagal 3!');
						($this->input->post('no-redirect')) ? $this->buku() : $this->index();
					}
            	}
            } else {
            	$this->session->set_userdata('failed', 'Tambah data buku gagal 4!');
				($this->input->post('no-redirect')) ? $this->buku() : $this->index();
            }
		} else {
			$this->session->set_userdata('failed', 'Tambah data buku gagal 5!');
			($this->input->post('no-redirect')) ? $this->buku() : $this->index();
		}
	}

	public function ubah_buku_proses() {
		$this->form_validation->set_rules('id','ID Buku', 'trim|required');
		$this->form_validation->set_rules('kategori','Kategori Buku', 'trim|required');
		$this->form_validation->set_rules('judul','Judul Buku', 'trim|required');
		$this->form_validation->set_rules('kode','Kode Buku', 'trim|required');
		$this->form_validation->set_rules('pengarang','Pengarang Buku', 'trim|required');
		$this->form_validation->set_rules('penerbit','Penerbit Buku', 'trim|required');
		$this->form_validation->set_rules('tahun_terbit','Tahun Terbit Buku', 'trim|required');
		$this->form_validation->set_rules('jumlah','Jumlah Buku', 'trim|required');

		// get input
		$id_buku = $this->input->post('id');
		$detail_buku = $this->M_admin->get_detail_buku($id_buku);

		// cek data
		if (empty($detail_buku)) {
			$this->session->set_userdata('failed', 'Ubah data buku gagal!');
			($this->input->post('no-redirect')) ? $this->buku() : $this->index();
		}

		if ($this->form_validation->run() !== false) {
			if (!empty($_FILES['cover']['name']) && !empty($_FILES['buku']['name'])) {
				// upload config cover
	            $config_cover['upload_path'] = 'stisla/assets/uploads/cover/';
	            $config_cover['allowed_types'] = 'jpg|jpeg|png|gif';
	            $config_cover['max_size'] = '5000';
	            // inisiasi config cover
	            $this->upload->initialize($config_cover);
	            // proses upload gambar
	            if ($this->upload->do_upload('cover')) {
	            	// hapus cover sebelumnya
	            	unlink('stisla/assets/uploads/cover/'.$detail_buku['cover_buku']);
	            	$data_cover = $this->upload->data();

            		// upload config file
		            $config_file['upload_path'] = 'stisla/assets/uploads/files/';
		            $config_file['allowed_types'] = 'pdf';
		            $config_file['max_size'] = '5000';
		            // inisiasi config file
		            $this->upload->initialize($config_file);

		            if ($this->upload->do_upload('buku')) {
		                // hapus file sebelumnya
		            	unlink('stisla/assets/uploads/files/'.$detail_buku['file_buku']);
		            	$data_file = $this->upload->data();

						$params = [
							'id_kategori' => $this->input->post('kategori'),
							'judul_buku' => $this->input->post('judul'),
							'kode_buku' => $this->input->post('kode'),
							'pengarang_buku' => $this->input->post('pengarang'),
							'penerbit_buku' => $this->input->post('penerbit'),
							'tahun_terbit_buku' => $this->input->post('tahun_terbit'),
							'jumlah_buku' => str_replace(',', '', $this->input->post('jumlah')),
							'cover_buku' => $data_cover['file_name'],
							'file_buku' => $data_file['file_name'],
							'mdb' => $this->session->userdata('id'),
							'mdb_name' => $this->session->userdata('nama'),
							'mdd' => date('Y-m-d H:i:s'),
						];

						$where = ['id_buku' => $this->input->post('id')];

						if ($this->M_admin->update_tbl_buku($params, $where)) {
							$this->session->set_userdata('success', 'Ubah data buku berhasil!');
							($this->input->post('no-redirect')) ? redirect('admin/buku') : redirect('admin');
						} else {
							$this->session->set_userdata('failed', 'Ubah data buku gagal!');
							($this->input->post('no-redirect')) ? $this->buku() : $this->index();
						}
		           	} else {
		           		$this->session->set_userdata('failed', 'Ubah data buku gagal!');
						($this->input->post('no-redirect')) ? $this->buku() : $this->index();
		           	}
	            } else {
	            	$this->session->set_userdata('failed', 'Ubah data buku gagal!');
					($this->input->post('no-redirect')) ? $this->buku() : $this->index();
	            }
			} else if (!empty($_FILES['cover']['name']) && empty($_FILES['buku']['name'])) {
				// upload config cover
	            $config_cover['upload_path'] = 'stisla/assets/uploads/cover/';
	            $config_cover['allowed_types'] = 'jpg|jpeg|png|gif';
	            $config_cover['max_size'] = '2000';
	            // inisiasi config cover
	            $this->upload->initialize($config_cover);
	            // proses upload gambar
	            if ($this->upload->do_upload('cover')) {
	            	// hapus cover sebelumnya
	            	unlink('stisla/uploads/cover/'.$detail_buku['cover_buku']);
	            	$data_cover = $this->upload->data();

	            	$params = [
						'id_kategori' => $this->input->post('kategori'),
						'judul_buku' => $this->input->post('judul'),
						'kode_buku' => $this->input->post('kode'),
						'pengarang_buku' => $this->input->post('pengarang'),
						'penerbit_buku' => $this->input->post('penerbit'),
						'tahun_terbit_buku' => $this->input->post('tahun_terbit'),
						'jumlah_buku' => str_replace(',', '', $this->input->post('jumlah')),
						'cover_buku' => $data_cover['file_name'],
						'mdb' => $this->session->userdata('id'),
						'mdb_name' => $this->session->userdata('nama'),
						'mdd' => date('Y-m-d H:i:s'),
					];

					$where = ['id_buku' => $this->input->post('id')];

					if ($this->M_admin->update_tbl_buku($params, $where)) {
						$this->session->set_userdata('success', 'Ubah data buku berhasil!');
						($this->input->post('no-redirect')) ? redirect('admin/buku') : redirect('admin');
					} else {
						$this->session->set_userdata('failed', 'Ubah data buku gagal!');
						($this->input->post('no-redirect')) ? $this->buku() : $this->index();
					}
				} else {
					$this->session->set_userdata('failed', 'Ubah data buku gagal!');
					($this->input->post('no-redirect')) ? $this->buku() : $this->index();
				}
			} else if (empty($_FILES['cover']['name']) && !empty($_FILES['buku']['name'])) {
				// upload config file
	            $config_file['upload_path'] = 'stisla/assets/uploads/files/';
	            $config_file['allowed_types'] = 'pdf';
	            $config_file['max_size'] = '5000';
	            // inisiasi config file
	            $this->upload->initialize($config_file);
	            // proses upload gambar
	            if ($this->upload->do_upload('buku')) {
	            	// hapus cover sebelumnya
	            	unlink('stisla/assets/uploads/files/'.$detail_buku['file_buku']);
	            	$data_file = $this->upload->data();

	            	$params = [
						'id_kategori' => $this->input->post('kategori'),
						'judul_buku' => $this->input->post('judul'),
						'kode_buku' => $this->input->post('kode'),
						'pengarang_buku' => $this->input->post('pengarang'),
						'penerbit_buku' => $this->input->post('penerbit'),
						'tahun_terbit_buku' => $this->input->post('tahun_terbit'),
						'jumlah_buku' => str_replace(',', '', $this->input->post('jumlah')),
						'file_buku' => $data_file['file_name'],
						'mdb' => $this->session->userdata('id'),
						'mdb_name' => $this->session->userdata('nama'),
						'mdd' => date('Y-m-d H:i:s'),
					];

					$where = ['id_buku' => $this->input->post('id')];

					if ($this->M_admin->update_tbl_buku($params, $where)) {
						$this->session->set_userdata('success', 'Ubah data buku berhasil!');
						($this->input->post('no-redirect')) ? redirect('admin/buku') : redirect('admin');
					} else {
						$this->session->set_userdata('failed', 'Ubah data buku gagal!');
						($this->input->post('no-redirect')) ? $this->buku() : $this->index();
					}
				} else {
					$this->session->set_userdata('failed', 'Ubah data buku gagal!');
					($this->input->post('no-redirect')) ? $this->buku() : $this->index();
				}
			} else {
				$params = [
					'id_kategori' => $this->input->post('kategori'),
					'judul_buku' => $this->input->post('judul'),
					'kode_buku' => $this->input->post('kode'),
					'pengarang_buku' => $this->input->post('pengarang'),
					'penerbit_buku' => $this->input->post('penerbit'),
					'tahun_terbit_buku' => $this->input->post('tahun_terbit'),
					'jumlah_buku' => str_replace(',', '', $this->input->post('jumlah')),
					'mdb' => $this->session->userdata('id'),
					'mdb_name' => $this->session->userdata('nama'),
					'mdd' => date('Y-m-d H:i:s')
				];

				$where = ['id_buku' => $this->input->post('id')];

				if ($this->M_admin->update_tbl_buku($params, $where)) {
					$this->session->set_userdata('success', 'Ubah data buku berhasil!');
					($this->input->post('no-redirect')) ? redirect('admin/buku') : redirect('admin');
				} else {
					$this->session->set_userdata('failed', 'Ubah data buku gagal!');
					($this->input->post('no-redirect')) ? $this->buku() : $this->index();
				}
			}
		} else {
			$this->session->set_userdata('failed', 'Ubah data buku gagal!');
			($this->input->post('no-redirect')) ? $this->buku() : $this->index();
		}
	}

	public function hapus_buku_proses() {
		$this->form_validation->set_rules('id','ID Buku', 'trim|required');

		// get input
		$id_buku = $this->input->post('id');
		$detail_buku = $this->M_admin->get_detail_buku($id_buku);

		// cek data
		if (empty($detail_buku)) {
			$this->session->set_userdata('failed', 'Hapus data buku gagal!');
			($this->input->post('no-redirect')) ? $this->buku() : $this->index();
		}

		if ($this->form_validation->run() !== false) {
			$where = ['id_buku' => $this->input->post('id')];

			if ($this->M_admin->delete_tbl_buku($where)) {
				unlink('stisla/assets/uploads/cover/'.$detail_buku['cover_buku']);
				unlink('stisla/assets/uploads/files/'.$detail_buku['file_buku']);
				$this->session->set_userdata('success', 'Hapus data buku berhasil!');
				($this->input->post('no-redirect')) ? redirect('admin/buku') : redirect('admin');
			} else {
				$this->session->set_userdata('failed', 'Hapus data buku gagal!');
				($this->input->post('no-redirect')) ? $this->buku() : $this->index();
			}
		} else {
			$this->session->set_userdata('failed', 'Hapus data buku gagal!');
			($this->input->post('no-redirect')) ? $this->buku() : $this->index();
		}
	}

	public function kategori() {
		// get list data
		$data['data_kategori_buku'] = $this->M_admin->get_data_kategori_buku();

		// get detail data
		$data['detail_user_header'] = $this->M_admin->get_detail_user_header(array($this->session->userdata('nis_nip'), $this->session->userdata('nis_nip')));

		$this->vic_lib->aview('index_kategori', $data);
	}

	public function tambah_kategori_proses() {
		$this->form_validation->set_rules('nama','Nama Kategori', 'trim|required');
		$this->form_validation->set_rules('keterangan','Keterangan Kategori', 'trim');

		if ($this->form_validation->run() !== false) {
			$params = [
				'nama_kategori' => $this->input->post('nama'),
				'create_by' => $this->session->userdata('id'),
				'create_name' => $this->session->userdata('nama'),
				'create_date' => date('Y-m-d H:i:s'),
			];

			if ($this->input->post('keterangan') != '<p></p>' || $this->input->post('keterangan') != '') {
				$params['deskripsi_kategori'] = $this->input->post('keterangan');
			}

			if ($this->M_admin->insert_tbl_kategori($params)) {
				$this->session->set_userdata('success', 'Tambah data kategori berhasil!');
				redirect('admin/kategori');
			} else {
				$this->session->set_userdata('failed', 'Tambah data kategori gagal!');
				$this->kategori();
			}
		} else {
			$this->session->set_userdata('failed', 'Tambah data kategori gagal!');
			$this->kategori();
		}
	}

	public function ubah_kategori_proses() {
		$this->form_validation->set_rules('id','ID Kategori', 'trim|required');
		$this->form_validation->set_rules('nama','Nama Kategori', 'trim|required');
		$this->form_validation->set_rules('keterangan','Keterangan Kategori', 'trim');

		// get input
		$id_kategori = $this->input->post('id');
		$detail_kategori = $this->M_admin->get_detail_kategori($id_kategori);

		// cek data
		if (empty($detail_kategori)) {
			$this->session->set_userdata('failed', 'Ubah data kategori gagal!');
			$this->kategori();
		}

		if ($this->form_validation->run() !== false) {
			$params = [
				'nama_kategori' => $this->input->post('nama'),
				'mdb' => $this->session->userdata('id'),
				'mdb_name' => $this->session->userdata('nama'),
				'mdd' => date('Y-m-d H:i:s'),
			];

			if ($this->input->post('keterangan') != '<p></p>' || $this->input->post('keterangan') != '') {
				$params['deskripsi_kategori'] = $this->input->post('keterangan');
			}

			$where = ['id_kategori' => $this->input->post('id')];

			if ($this->M_admin->update_tbl_kategori($params, $where)) {
				$this->session->set_userdata('success', 'Ubah data kategori berhasil!');
				redirect('admin/kategori');
			} else {
				$this->session->set_userdata('failed', 'Ubah data kategori gagal!');
				$this->kategori();
			}
		} else {
			$this->session->set_userdata('failed', 'Ubah data kategori gagal!');
			$this->kategori();
		}
	}

	public function hapus_kategori_proses() {
		$this->form_validation->set_rules('id','ID Kategori', 'trim|required');

		// get input
		$id_kategori = $this->input->post('id');
		$detail_kategori = $this->M_admin->get_detail_kategori($id_kategori);

		// cek data
		if (empty($detail_kategori)) {
			$this->session->set_userdata('failed', 'Hapus data kategori gagal!');
			$this->kategori();
		}

		if ($this->form_validation->run() !== false) {
			$where = ['id_kategori' => $this->input->post('id')];

			if ($this->M_admin->delete_tbl_kategori($where)) {
				$this->session->set_userdata('success', 'Hapus data kategori berhasil!');
				redirect('admin/kategori');
			} else {
				$this->session->set_userdata('failed', 'Hapus data kategori gagal!');
				$this->kategori();
			}
		} else {
			$this->session->set_userdata('failed', 'Hapus data kategori gagal!');
			$this->kategori();
		}
	}

	public function peminjaman() {
		// get list data
		$data['data_peminjaman'] = $this->M_admin->get_data_peminjaman();

		// get detail data
		$data['detail_user_header'] = $this->M_admin->get_detail_user_header(array($this->session->userdata('nis_nip'), $this->session->userdata('nis_nip')));

		$this->vic_lib->aview('index_peminjaman', $data);
	}

	public function tambah_peminjaman_proses() {
		$this->form_validation->set_rules('nis_nip','NIS/NIP Pengguna', 'trim|required');
		$this->form_validation->set_rules('kode','Kode Buku', 'trim|required');
		$this->form_validation->set_rules('no','Nomor Buku', 'trim|required');

		// get input
		$nis_nip = $this->input->post('nis_nip');
		if (empty($this->M_admin->cek_nis_nip($nis_nip))) {
            $this->session->set_userdata('failed', 'Tambah data peminjaman gagal!');
			redirect('admin/peminjaman');
        }

		$kode_buku = $this->input->post('kode');
        if (empty($this->M_admin->cek_kode_buku($kode_buku))) {
            $this->session->set_userdata('failed', 'Tambah data peminjaman gagal!');
			redirect('admin/peminjaman');
        }

        $no_buku = $this->input->post('no');

    	// cek pinjam buku
        if (!empty($this->M_admin->cek_pinjam_buku([$nis_nip, $kode_buku, $no_buku]))) {
            $this->session->set_userdata('failed', 'Tambah data peminjaman gagal!');
			redirect('admin/peminjaman');
        }

		if ($this->form_validation->run() !== false) {
			$params = [
                'nis_nip_pengguna' => $nis_nip,
                'kode_buku' => $kode_buku,
                'nobuku_peminjaman' => $no_buku,
                'tgl_peminjaman' => date('Y-m-d'),
                'tgl_pengembalian' => date('Y-m-d', strtotime('+3 days')),
                'status_peminjaman' => 'dipinjam',
                'create_by' => $this->session->userdata('id'),
                'create_name' => $this->session->userdata('nama'),
                'create_date' => date('Y-m-d H:i:s')
            ];

			if ($this->M_admin->insert_tbl_peminjaman($params)) {
				$this->session->set_userdata('success', 'Tambah data peminjaman berhasil!');
				redirect('admin/peminjaman');
			} else {
				$this->session->set_userdata('failed', 'Tambah data peminjaman gagal!');
				$this->peminjaman();
			}
		} else {
			$this->session->set_userdata('failed', 'Tambah data peminjaman gagal!');
			$this->peminjaman();
		}
	}

	public function ubah_peminjaman_proses() {
		$this->form_validation->set_rules('id','ID Peminjaman', 'trim|required');
		$this->form_validation->set_rules('no','Nomor Buku', 'trim|required');

		// get input
		$id_peminjaman = $this->input->post('id');

		// get detail peminjaman
		$detail_peminjaman = $this->M_admin->get_detail_peminjaman($id_peminjaman);

		if (empty($detail_peminjaman)) {
			$this->session->set_userdata('failed', 'Ubah data peminjaman gagal!');
			$this->peminjaman();
		}

		if ($this->form_validation->run() !== false) {
			$params = [
				'nobuku_peminjaman' => $this->input->post('no'),
				'mdb' => $this->session->userdata('id'),
				'mdb_name' => $this->session->userdata('nama'),
				'mdd' => date('Y-m-d H:i:s'),
			];

			$where = ['id_peminjaman' => $this->input->post('id')];

			if ($this->M_admin->update_tbl_peminjaman($params, $where)) {
				$this->session->set_userdata('success', 'Ubah data peminjaman berhasil!');
				redirect('admin/peminjaman');
			} else {
				$this->session->set_userdata('failed', 'Ubah data peminjaman gagal!');
				$this->peminjaman();
			}
		} else {
			$this->session->set_userdata('failed', 'Ubah data peminjaman gagal!');
			$this->peminjaman();
		}
	}

	public function hapus_peminjaman_proses() {
		$this->form_validation->set_rules('id','ID Peminjaman', 'trim|required');

		// get input
		$id_peminjaman = $this->input->post('id');

		// get detail peminjaman
		$detail_peminjaman = $this->M_admin->get_detail_peminjaman($id_peminjaman);

		if (empty($detail_peminjaman)) {
			$this->session->set_userdata('failed', 'Ubah data peminjaman gagal!');
			$this->peminjaman();
		}

		if ($this->form_validation->run() !== false) {
			$where = ['id_peminjaman' => $this->input->post('id')];

			if ($this->M_admin->delete_tbl_peminjaman($where)) {
				$this->session->set_userdata('success', 'Hapus data peminjaman berhasil!');
				redirect('admin/peminjaman');
			} else {
				$this->session->set_userdata('failed', 'Hapus data peminjaman gagal!');
				$this->peminjaman();
			}
		} else {
			$this->session->set_userdata('failed', 'Hapus data peminjaman gagal!');
			$this->peminjaman();
		}
	}

	public function import_peminjaman_proses() {
		// file type
        $file_mimes = [
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        if (isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {

            $arr_file = explode('.', $_FILES['file_excel']['name']); // get file
            $extension = end($arr_file); // get file extension

            // select spreadsheet reader depends on file extension
            if ($extension == 'csv') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else if ($extension == 'xlsx'){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $this->session->set_userdata('failed', 'Ekstensi file tidak dikenali!');
                redirect('admin/peminjaman/tambah');
            }

            // 'Data' Table
            $dataList = [];
            $dataListArray = [];

            $reader->setReadDataOnly(true);

            //Get filename
            $objPHPExcel = $reader->load($_FILES['file_excel']['tmp_name']);
            
            //Get sheet by name
            $worksheet = $objPHPExcel->getSheetByName('Peminjaman');

            /*
            * Get sheet by index
            * Get the second sheet in the workbook
            * Note that sheets are indexed from 0
            */ 
            // $spreadsheet->getSheet(1);

            /*
            * Get current active sheet
            */ 

            //$spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow(); // e.g. 12
            $highestColumn = $worksheet->getHighestColumn(); // e.g M'

            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 7
            //Ignoring first row (As it contains column name)
            for ($row = 3; $row <= $highestRow; ++$row) {
                //A row selected
                for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                    // values till $cityList['1'] till $cityList['last_column_no'] 
                    $dataList[$col] = $worksheet->getCellByColumnAndRow($col, $row)->getValue(); 
                } 

                array_push($dataListArray, $dataList);
                //next row, from top
            }
            
            if ($this->M_admin->import_peminjaman($dataListArray) == TRUE) {
                // what to do if import successfull
                $this->session->set_userdata('success', 'Import data peminjaman berhasil!');
                redirect('admin/peminjaman');
			} else {
                // what to do if import failed
				$this->session->set_userdata('failed', 'Import data peminjaman gagal!');
                redirect('admin/peminjaman/tambah');
			}
        } else {
			$this->session->set_userdata('failed', 'Import data peminjaman gagal!');
            redirect('admin/peminjaman/tambah');
        }
	}

	public function pinjam_buku_proses() {
		$this->form_validation->set_rules('nis_nip', 'NIS/NIP Pengguna', 'trim|required');
		$this->form_validation->set_rules('id', 'ID Buku', 'trim|required');
		$this->form_validation->set_rules('kode', 'Kode Buku', 'trim|required');
		$this->form_validation->set_rules('action', 'Action Proses', 'trim|required');

		// get data
		$action = $this->input->post('action');
		$nis_nip_pengguna = $this->input->post('nis_nip');
		$id_buku = $this->input->post('id');
		$kode_buku = $this->input->post('kode');
		$detail_buku = $this->M_admin->get_detail_buku($id_buku);

		// cek data
		if (empty($detail_buku)) {
			$this->session->set_userdata('failed', 'Proses peminjaman gagal!');
			$this->peminjaman();
		}

		$id_peminjaman = $this->M_admin->get_id_peminjaman([$nis_nip_pengguna, $kode_buku]);

		// cek id peminjaman
		if (empty($id_peminjaman)) {
			$this->session->set_userdata('failed', 'Transaksi peminjaman tidak ada!');
			$this->peminjaman();
		}

		$detail_peminjaman = $this->M_admin->get_detail_peminjaman($id_peminjaman);

		if ($this->form_validation->run() !== false) {
			$params = [
				'mdb' => $this->session->userdata('id'),
				'mdb_name' => $this->session->userdata('nama'),
				'mdd' => date('Y-m-d H:i:s'),
			];

			if ($action == 'Tolak') {
				$params['status_peminjaman'] = 'ditolak';
			} elseif ($action == 'Setujui') {
				$params['status_peminjaman'] = empty($detail_peminjaman['tgl_dikembalikan']) ? 'dipinjam' : 'dikembalikan';
			} else {
				$this->session->set_userdata('failed', 'Proses peminjaman gagal!');
				$this->peminjaman();
			}

			$where = [
				'id_peminjaman' => $id_peminjaman
			];

			if ($this->M_admin->update_tbl_peminjaman($params, $where)) {
				$this->session->set_userdata('success', 'Proses peminjaman berhasil!');
				redirect('admin/peminjaman');
			} else {
				$this->session->set_userdata('failed', 'Proses peminjaman gagal!');
				$this->peminjaman();
			}
		} else {
			$this->session->set_userdata('failed', 'Proses peminjaman gagal!!');
			$this->peminjaman();
		}
	}

	public function pengguna() {
		// get list data
		$data['data_user'] = $this->M_admin->get_data_user();
		$data['data_level'] = $this->M_admin->get_data_level();

		// get detail data
		$data['detail_user_header'] = $this->M_admin->get_detail_user_header(array($this->session->userdata('nis_nip'), $this->session->userdata('nis_nip')));

		$this->vic_lib->aview('index_user', $data);
	}

	public function import_pengguna_proses() {
		// file type
        $file_mimes = [
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        if (isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {

            $arr_file = explode('.', $_FILES['file_excel']['name']); // get file
            $extension = end($arr_file); // get file extension

            // select spreadsheet reader depends on file extension
            if ($extension == 'csv') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else if ($extension == 'xlsx'){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $this->session->set_userdata('failed', 'Ekstensi file tidak dikenali!');
                redirect('admin/pengguna');
            }

            // 'Data' Table
            $dataList = [];
            $dataListArray = [];

            $reader->setReadDataOnly(true);

            //Get filename
            $objPHPExcel = $reader->load($_FILES['file_excel']['tmp_name']);
            
            //Get sheet by name
            $worksheet = $objPHPExcel->getSheetByName('Pengguna');

            /*
            * Get sheet by index
            * Get the second sheet in the workbook
            * Note that sheets are indexed from 0
            */ 
            // $spreadsheet->getSheet(1);

            /*
            * Get current active sheet
            */ 

            //$spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow(); // e.g. 12
            $highestColumn = $worksheet->getHighestColumn(); // e.g M'

            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 7
            //Ignoring first row (As it contains column name)
            for ($row = 9; $row <= $highestRow; ++$row) {
                //A row selected
                for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                    // values till $cityList['1'] till $cityList['last_column_no'] 
                    $dataList[$col] = $worksheet->getCellByColumnAndRow($col, $row)->getValue(); 
                }
                
                array_push($dataListArray, $dataList);
                //next row, from top
            }
            
            if ($this->M_admin->import_pengguna($dataListArray) == TRUE) {
                // what to do if import successfull
                $this->session->set_userdata('success', 'Import data pengguna berhasil!');
                redirect('admin/pengguna');
			} else {
                // what to do if import failed
				$this->session->set_userdata('failed', 'Import data pengguna gagal!');
                redirect('admin/pengguna');
			}
        } else {
			$this->session->set_userdata('failed', 'Import data pengguna gagal!');
            redirect('admin/pengguna');
        }
	}

	public function tambah_pengguna_proses() {
		$this->form_validation->set_rules('level','Level Pengguna', 'trim|required');
		$this->form_validation->set_rules('nis_nip','NIS/NIP Pengguna', 'trim|required');
		$this->form_validation->set_rules('nama','Nama Pengguna', 'trim|required');
		$this->form_validation->set_rules('pass','Password Pengguna', 'trim|required');
		$this->form_validation->set_rules('email','Email Pengguna', 'trim|required');
		$this->form_validation->set_rules('nohp','No. HP Pengguna', 'trim|required');

		if ($this->form_validation->run() !== false) {
			$params = [
				'id_level' => $this->input->post('level'),
				'nis_nip_pengguna' => $this->input->post('nis_nip'),
				'pass_pengguna' => $this->input->post('pass'),
				'nama_pengguna' => $this->input->post('nama'),
				'email_pengguna' => $this->input->post('email'),
				'nohp_pengguna' => $this->input->post('nohp'),
				'create_by' => $this->session->userdata('id'),
				'create_name' => $this->session->userdata('nama'),
				'create_date' => date('Y-m-d H:i:s'),
			];

			if ($this->input->post('bio') != '<p></p>' || $this->input->post('bio') != '') {
				$params['bio_pengguna'] = $this->input->post('bio');
			}

			if ($this->input->post('alamat') != '<p></p>' || $this->input->post('alamat') != '') {
				$params['alamat_pengguna'] = $this->input->post('alamat');
			}

			if ($this->M_admin->insert_tbl_pengguna($params)) {
				$this->session->set_userdata('success', 'Tambah data pengguna berhasil!');
				redirect('admin/pengguna');
			} else {
				$this->session->set_userdata('failed', 'Tambah data pengguna gagal!');
				$this->pengguna();
			}
		} else {
			$this->session->set_userdata('failed', 'Tambah data pengguna gagal!');
			$this->pengguna();
		}
	}

	public function ubah_pengguna_proses() {
		$this->form_validation->set_rules('id','ID Pengguna', 'trim|required');
		$this->form_validation->set_rules('level','Level Pengguna', 'trim|required');
		$this->form_validation->set_rules('nis_nip','NIS/NIP Pengguna', 'trim|required');
		$this->form_validation->set_rules('nama','Nama Pengguna', 'trim|required');
		$this->form_validation->set_rules('pass','Password Pengguna', 'trim|required');
		$this->form_validation->set_rules('email','Email Pengguna', 'trim|required');
		$this->form_validation->set_rules('nohp','No. HP Pengguna', 'trim|required');

		// get input
		$id_pengguna = $this->input->post('id');
		$detail_pengguna = $this->M_admin->get_detail_user($id_pengguna);

		// cek data
		if (empty($detail_pengguna)) {
			$this->session->set_userdata('failed', 'Ubah data pengguna gagal!');
			$this->pengguna();
		}

		if ($this->form_validation->run() !== false) {
			$params = [
				'id_level' => $this->input->post('level'),
				'nis_nip_pengguna' => $this->input->post('nis_nip'),
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

			if ($this->M_admin->update_tbl_pengguna($params, $where)) {
				$this->session->set_userdata('success', 'Ubah data pengguna berhasil!');
				redirect('admin/pengguna');
			} else {
				$this->session->set_userdata('failed', 'Ubah data pengguna gagal!');
				$this->pengguna();
			}
		} else {
			$this->session->set_userdata('failed', 'Ubah data pengguna gagal!');
			$this->pengguna();
		}
	}

	public function hapus_pengguna_proses() {
		$this->form_validation->set_rules('id','ID Pengguna', 'trim|required');

		// get input
		$id_pengguna = $this->input->post('id');
		$detail_pengguna = $this->M_admin->get_detail_user($id_pengguna);

		// cek data
		if (empty($detail_pengguna)) {
			$this->session->set_userdata('failed', 'Hapus data pengguna gagal!');
			$this->pengguna();
		}

		if ($this->form_validation->run() !== false) {
			$where = ['id_pengguna' => $this->input->post('id')];

			if ($this->M_admin->delete_tbl_pengguna($where)) {
				$this->session->set_userdata('success', 'Hapus data pengguna berhasil!');
				redirect('admin/pengguna');
			} else {
				$this->session->set_userdata('failed', 'Hapus data pengguna gagal!');
				$this->pengguna();
			}
		} else {
			$this->session->set_userdata('failed', 'Hapus data pengguna gagal!');
			$this->pengguna();
		}
	}

	public function level() {
		// get list data
		$data['data_level_user'] = $this->M_admin->get_data_level_user();

		// get detail data
		$data['detail_user_header'] = $this->M_admin->get_detail_user_header(array($this->session->userdata('nis_nip'), $this->session->userdata('nis_nip')));

		$this->vic_lib->aview('index_level', $data);
	}

	public function tambah_level_proses() {
		$this->form_validation->set_rules('nama','Nama Level', 'trim|required');
		$this->form_validation->set_rules('keterangan','Keterangan Level', 'trim');

		if ($this->form_validation->run() !== false) {
			$params = [
				'nama_level' => $this->input->post('nama'),
				'create_by' => $this->session->userdata('id'),
				'create_name' => $this->session->userdata('nama'),
				'create_date' => date('Y-m-d H:i:s'),
			];

			if ($this->input->post('keterangan') != '<p></p>' || $this->input->post('keterangan') != '') {
				$params['deskripsi_level'] = $this->input->post('keterangan');
			}

			if ($this->M_admin->insert_tbl_level($params)) {
				$this->session->set_userdata('success', 'Tambah data level berhasil!');
				redirect('admin/level');
			} else {
				$this->session->set_userdata('failed', 'Tambah data level gagal!');
				$this->level();
			}
		} else {
			$this->session->set_userdata('failed', 'Tambah data level gagal!');
			$this->level();
		}
	}

	public function ubah_level_proses() {
		$this->form_validation->set_rules('id','ID Level', 'trim|required');
		$this->form_validation->set_rules('nama','Nama Level', 'trim|required');
		$this->form_validation->set_rules('keterangan','Keterangan Level', 'trim');

		// get input
		$id_level = $this->input->post('id');
		$detail_level = $this->M_admin->get_detail_level($id_level);

		// cek data
		if (empty($detail_level)) {
			$this->session->set_userdata('failed', 'Ubah data level gagal!');
			$this->level();
		}

		if ($this->form_validation->run() !== false) {
			$params = [
				'nama_level' => $this->input->post('nama'),
				'mdb' => $this->session->userdata('id'),
				'mdb_name' => $this->session->userdata('nama'),
				'mdd' => date('Y-m-d H:i:s'),
			];

			if ($this->input->post('keterangan') != '<p></p>' || $this->input->post('keterangan') != '') {
				$params['deskripsi_level'] = $this->input->post('keterangan');
			}

			$where = ['id_level' => $this->input->post('id')];

			if ($this->M_admin->update_tbl_level($params, $where)) {
				$this->session->set_userdata('success', 'Ubah data level berhasil!');
				redirect('admin/level');
			} else {
				$this->session->set_userdata('failed', 'Ubah data level gagal!');
				$this->level();
			}
		} else {
			$this->session->set_userdata('failed', 'Ubah data level gagal!');
			$this->level();
		}
	}

	public function hapus_level_proses() {
		$this->form_validation->set_rules('id','ID Level', 'trim|required');

		// get input
		$id_level = $this->input->post('id');
		$detail_level = $this->M_admin->get_detail_level($id_level);

		// cek data
		if (empty($detail_level)) {
			$this->session->set_userdata('failed', 'Hapus data level gagal!');
			$this->level();
		}

		if ($this->form_validation->run() !== false) {
			$where = ['id_level' => $this->input->post('id')];

			if ($this->M_admin->delete_tbl_level($where)) {
				$this->session->set_userdata('success', 'Hapus data level berhasil!');
				redirect('admin/level');
			} else {
				$this->session->set_userdata('failed', 'Hapus data level gagal!');
				$this->level();
			}
		} else {
			$this->session->set_userdata('failed', 'Hapus data level gagal!');
			$this->level();
		}
	}

	public function profile() {
		// get detail data
		$data['detail_user'] = $this->M_admin->get_detail_user_profile(array($this->session->userdata('id')));
		$data['detail_user_header'] = $this->M_admin->get_detail_user_header(array($this->session->userdata('nis_nip'), $this->session->userdata('nis_nip')));

		$this->vic_lib->aview('index_profile', $data);
	}

	public function ubah_profile_proses() {
		$this->form_validation->set_rules('nama','Nama Pengguna', 'trim|required');
		$this->form_validation->set_rules('pass','Password Pengguna', 'trim|required');
		$this->form_validation->set_rules('email','Email Pengguna', 'trim|required');
		$this->form_validation->set_rules('nohp','No. HP Pengguna', 'trim|required');

		// get input
		$id_pengguna = $this->input->post('id');
		$detail_pengguna = $this->M_admin->get_detail_user($id_pengguna);

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

			if ($this->M_admin->update_tbl_pengguna($params, $where)) {
				$this->session->set_userdata('nama', $this->input->post('nama'));
				$this->session->set_userdata('success', 'Ubah data profile berhasil!');
				redirect('admin/profile');
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

		if ($this->M_admin->insert_tbl_logs($params)) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}
}