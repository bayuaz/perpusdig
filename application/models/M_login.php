<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {
	function cek_level() {
        return $this->session->userdata('level');
    }
    
	function cek_status() {
		return $this->session->userdata('status');
	}

	function cek($params) {
		// query
		$sql = "SELECT a.*, b.nama_level FROM tbl_pengguna a
				INNER JOIN tbl_level b ON a.id_level = b.id_level
				WHERE a.nis_nip_pengguna = ? AND a.pass_pengguna = ?";
		// execute
		$query = $this->db->query($sql, $params);
		// cek
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
            $query->free_result();
            return $result;
		} else {
			return [];
		}
	}

	function insert_tbl_logs($params) {
		return $this->db->insert('tbl_logs', $params);
	}
}