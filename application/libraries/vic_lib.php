<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vic_lib {
	function aview($view, $data = array())
	{
		$ci =& get_instance();
		
		if (!array_key_exists('title', $data)) {
			$data['title'] = 'Sistem Informasi Perpustakaan - SMPN 2 Limapuluh';
		}

		$ci->load->view('admin/menu/header', $data);
		$ci->load->view('admin/menu/sidebar', $data);
		$ci->load->view('admin/'.$view, $data);
		$ci->load->view('admin/menu/footer', $data);
	}

	function pview($view, $data = array())
	{
		$ci =& get_instance();
		
		if (!array_key_exists('title', $data)) {
			$data['title'] = 'Sistem Informasi Perpustakaan - SMPN 2 Limapuluh';
		}

		$ci->load->view('pengguna/menu/header', $data);
		$ci->load->view('pengguna/menu/sidebar', $data);
		$ci->load->view('pengguna/'.$view, $data);
		$ci->load->view('pengguna/menu/footer', $data);
	}
}