<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengguna extends CI_Model {
    function cek_level() {
        return $this->session->userdata('level');
    }

     public function get_data_buku($params) {
    	// query
        $sql = "SELECT a.*, e.jumlah_dipinjam, d.nama_kategori, c.nis_nip_pengguna, c.nobuku_peminjaman, c.tgl_peminjaman, c.tgl_pengembalian, c.tgl_dikembalikan, c.status_peminjaman, c.denda_peminjaman FROM tbl_buku a
                LEFT JOIN (
                    SELECT kode_buku, MAX(id_peminjaman) as id_peminjaman
                    FROM tbl_peminjaman
                    WHERE nis_nip_pengguna = ?
                    GROUP BY kode_buku
                ) b ON a.kode_buku = b.kode_buku
                LEFT JOIN tbl_peminjaman c ON b.kode_buku = c.kode_buku AND b.id_peminjaman = c.id_peminjaman
                INNER JOIN tbl_kategori d ON a.id_kategori = d.id_kategori
                LEFT JOIN (
                    SELECT kode_buku, COUNT(id_peminjaman) as jumlah_dipinjam FROM tbl_peminjaman
                    WHERE status_peminjaman = 'diajukan' OR status_peminjaman = 'dipinjam' OR status_peminjaman = 'ditolak'
                    GROUP BY kode_buku
                ) e ON a.kode_buku = e.kode_buku
                ORDER BY a.kode_buku DESC";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_data_pinjam($params) {
        // query
        $sql = "SELECT a.*, b.id_buku, b.judul_buku, b.cover_buku, b.file_buku, c.nama_kategori FROM tbl_peminjaman a
                INNER JOIN tbl_buku b ON a.kode_buku = b.kode_buku
                INNER JOIN tbl_kategori c ON c.id_kategori = b.id_kategori
                WHERE nis_nip_pengguna = ? AND (status_peminjaman = 'diajukan' OR status_peminjaman = 'ditolak' OR status_peminjaman = 'dipinjam')
                ORDER BY id_peminjaman DESC";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_sisa_buku($params) {
        // query
        $sql = "SELECT a.jumlah_buku, COUNT(b.id_peminjaman) as jumlah_dipinjam FROM tbl_buku a
                INNER JOIN tbl_peminjaman b ON a.kode_buku = b.kode_buku
                WHERE a.id_buku = ? AND (status_peminjaman = 'diajukan' OR status_peminjaman = 'dipinjam' OR status_peminjaman = 'ditolak')";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function get_detail_user($params) {
        // query
        $sql = "SELECT * FROM tbl_pengguna WHERE id_pengguna = ?";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function get_detail_user_header($params) {
        // query
        $sql = "SELECT a.*, b.create_date FROM tbl_pengguna a
                INNER JOIN (
                    SELECT nis_nip_pengguna, create_date FROM tbl_logs
                    WHERE nis_nip_pengguna = ?
                    ORDER BY nis_nip_pengguna DESC LIMIT 1
                ) b ON a.nis_nip_pengguna = b.nis_nip_pengguna
                WHERE b.nis_nip_pengguna = ?";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function get_detail_buku($params) {
        // query
        $sql = "SELECT * FROM tbl_buku WHERE id_buku = ?";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function get_detail_user_profile($params) {
        // query
        $sql = "SELECT a.*, b.nama_level FROM tbl_pengguna a
                INNER JOIN tbl_level b ON a.id_level = b.id_level
                WHERE a.id_pengguna = ?";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function get_detail_peminjaman($params) {
        // query
        $sql = "SELECT * FROM tbl_peminjaman
                WHERE id_peminjaman = ?";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function get_id_peminjaman($params) {
        // query
        $sql = "SELECT id_peminjaman FROM tbl_peminjaman
                WHERE nis_nip_pengguna = ? AND kode_buku = ?
                ORDER BY id_peminjaman DESC LIMIT 1";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['id_peminjaman'];
        } else {
            return array();
        }
    }

    function cek_pinjam_buku($params) {
        // query
        $sql = "SELECT * FROM tbl_peminjaman
                WHERE nis_nip_pengguna = ? AND kode_buku = ?
                AND (status_peminjaman = 'dipinjam' OR status_peminjaman = 'diajukan')";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function cek_sedang_dipinjam($params) {
        // query
        $sql = "SELECT * FROM tbl_peminjaman
                WHERE kode_buku = ? AND nobuku_peminjaman = ?
                AND (status_peminjaman = 'dipinjam' OR status_peminjaman = 'diajukan')";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function cek_pinjam_kembali($params) {
        // query
        $sql = "SELECT * FROM tbl_peminjaman WHERE id_peminjaman = ? AND nis_nip_pengguna = ? AND kode_buku = ? AND status_peminjaman = 'ditolak'";
        // execute
        $query = $this->db->query($sql, $params);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function insert_tbl_logs($params) {
        return $this->db->insert('tbl_logs', $params);
    }

    function insert_tbl_peminjaman($params) {
        return $this->db->insert('tbl_peminjaman', $params);
    }

    function update_tbl_peminjaman($params, $where) {
        return $this->db->update('tbl_peminjaman', $params, $where);
    }

    function update_tbl_pengguna($params, $where) {
        return $this->db->update('tbl_pengguna', $params, $where);
    }
}