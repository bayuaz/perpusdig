<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengguna extends CI_Model {
    function cek_level() {
        return $this->session->userdata('level');
    }

     public function get_data_buku() {
    	// query
        $sql = "SELECT a.*, d.nama_kategori, a.judul_buku, c.id_pengguna, c.tgl_peminjaman, c.tgl_pengembalian, c.status_peminjaman FROM tbl_buku a
                LEFT JOIN (
                    SELECT id_buku, MAX(id_peminjaman) as id_peminjaman
                    FROM tbl_peminjaman
                    GROUP BY id_buku
                ) b ON a.id_buku = b.id_buku
                LEFT JOIN tbl_peminjaman c ON b.id_buku = c.id_buku
                AND b.id_peminjaman = c.id_peminjaman
                INNER JOIN tbl_kategori d ON a.id_kategori = d.id_kategori
                ORDER BY a.id_buku DESC";
        // execute
        $query = $this->db->query($sql);
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
        $sql = "SELECT a.*, b.judul_buku, b.cover_buku, b.file_buku, c.nama_kategori FROM tbl_peminjaman a
                INNER JOIN tbl_buku b ON a.id_buku = b.id_buku
                INNER JOIN tbl_kategori c ON c.id_kategori = b.id_kategori
                WHERE id_pengguna = ? AND status_peminjaman = 'dipinjam'
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
                    SELECT id_pengguna, create_date FROM tbl_logs
                    WHERE id_pengguna = ?
                    ORDER BY id_pengguna DESC LIMIT 1
                ) b ON a.id_pengguna = b.id_pengguna
                WHERE b.id_pengguna = ?";
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

    function get_id_peminjaman($params) {
        // query
        $sql = "SELECT id_peminjaman FROM tbl_peminjaman
                WHERE id_pengguna = ? AND id_buku = ?
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
        $sql = "SELECT * FROM tbl_peminjaman WHERE id_pengguna = ? AND id_buku = ? AND status_peminjaman = 'dipinjam'";
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
}