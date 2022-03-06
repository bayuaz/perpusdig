<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {
    function cek_level() {
        return $this->session->userdata('level');
    }

    function get_total_user() {
        // query
        $sql = "SELECT COUNT(id_pengguna) as total_pengguna FROM tbl_pengguna";
        // execute
        $query = $this->db->query($sql);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total_pengguna'];
        } else {
            return array();
        }
    }

    function get_total_buku_fisik() {
        // query
        $sql = "SELECT COUNT(id_buku) as total_buku FROM tbl_buku WHERE bentuk_buku = 'Fisik'";
        // execute
        $query = $this->db->query($sql);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total_buku'];
        } else {
            return array();
        }
    }

    function get_total_buku_digital() {
        // query
        $sql = "SELECT COUNT(id_buku) as total_buku FROM tbl_buku WHERE bentuk_buku = 'Digital'";
        // execute
        $query = $this->db->query($sql);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total_buku'];
        } else {
            return array();
        }
    }

    function get_total_peminjaman() {
        // query
        $sql = "SELECT COUNT(id_peminjaman) as total_peminjaman FROM tbl_peminjaman";
        // execute
        $query = $this->db->query($sql);
        // cek result
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total_peminjaman'];
        } else {
            return array();
        }
    }

    function get_data_user() {
        // query
        $sql = "SELECT a.*, b.nama_level FROM tbl_pengguna a
                INNER JOIN tbl_level b ON a.id_level = b.id_level
                ORDER BY id_pengguna DESC";
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

    function get_data_level() {
        // query
        $sql = "SELECT * FROM tbl_level";
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

    function get_data_level_user() {
        // query
        $sql = "SELECT a.*, COUNT(b.id_pengguna) as jumlah_pengguna FROM tbl_level a
                LEFT JOIN tbl_pengguna b ON a.id_level = b.id_level
                GROUP BY a.id_level
                ORDER BY a.id_level DESC";
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

    function get_data_buku() {
        // query
        $sql = "SELECT a.*, b.nama_kategori FROM tbl_buku a
                INNER JOIN tbl_kategori b on a.id_kategori = b.id_kategori
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

    function get_data_buku_terbaru() {
        // query
        $sql = "SELECT a.*, b.nama_kategori FROM tbl_buku a
                INNER JOIN tbl_kategori b on a.id_kategori = b.id_kategori
                ORDER BY a.id_buku DESC LIMIT 5";
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

    function get_data_kategori() {
        // query
        $sql = "SELECT * FROM tbl_kategori";
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

    function get_data_kategori_buku() {
        // query
        $sql = "SELECT a.*, COUNT(b.id_kategori) as jumlah_buku FROM tbl_kategori a 
                LEFT JOIN tbl_buku b ON a.id_kategori = b.id_kategori
                GROUP BY a.id_kategori
                ORDER BY a.id_kategori DESC";
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

    function get_data_peminjaman() {
        // query
        $sql = "SELECT a.*, b.nama_pengguna, c.judul_buku FROM tbl_peminjaman a
                INNER JOIN tbl_pengguna b ON a.id_pengguna = b.id_pengguna
                INNER JOIN tbl_buku c on a.id_buku = c.id_buku
                ORDER BY a.id_peminjaman DESC";
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

     function get_data_peminjaman_terbaru() {
        // query
        $sql = "SELECT a.*, b.nama_pengguna, c.judul_buku FROM tbl_peminjaman a
                INNER JOIN tbl_pengguna b ON a.id_pengguna = b.id_pengguna
                INNER JOIN tbl_buku c on a.id_buku = c.id_buku
                ORDER BY a.id_peminjaman DESC LIMIT 5";
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

    function get_data_logs() {
        // query
        $sql = "SELECT DISTINCT a.*, b.nama_pengguna, c.nama_level FROM tbl_logs a
                INNER JOIN tbl_pengguna b ON a.id_pengguna = b.id_pengguna
                INNER JOIN tbl_level c ON b.id_level = c.id_level
                INNER JOIN (SELECT MAX(id_logs) as id_logs FROM tbl_logs GROUP BY id_pengguna) d on d.id_logs = a.id_logs
                ORDER BY a.create_date DESC 
                LIMIT 4";
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

    function get_data_sering_dipinjam() {
        // query
        $sql = "SELECT COUNT(a.id_peminjaman) as jumlah_dipinjam, b.judul_buku, b.cover_buku, c.nama_kategori FROM tbl_peminjaman a
                INNER JOIN tbl_buku b ON a.id_buku = b.id_buku
                INNER JOIN tbl_kategori c ON b.id_kategori = c.id_kategori
                GROUP BY a.id_buku
                ORDER BY jumlah_dipinjam DESC
                LIMIT 4";
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

    function get_detail_user_profile($params) {
        // query
        $sql = "SELECT a.*, b.nama_level FROM tbl_pengguna a
                INNER JOIN tbl_level b ON a.id_level = b.id_level
                WHERE id_pengguna = ?";
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

    function get_detail_logs_user($params) {
        // query
        $sql = "SELECT * FROM tbl_logs WHERE id_pengguna = ?
                ORDER BY id_logs DESC LIMIT 1";
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

    function get_detail_kategori($params) {
        // query
        $sql = "SELECT * FROM tbl_kategori WHERE id_kategori = ?";
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

    function get_detail_level($params) {
        // query
        $sql = "SELECT * FROM tbl_level WHERE id_level = ?";
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

    function insert_tbl_buku($params) {
        return $this->db->insert('tbl_buku', $params);
    }

    function update_tbl_buku($params, $where) {
        return $this->db->update('tbl_buku', $params, $where);
    }

    function delete_tbl_buku($where) {
        return $this->db->delete('tbl_buku', $where);
    }

    function insert_tbl_kategori($params) {
        return $this->db->insert('tbl_kategori', $params);
    }

    function update_tbl_kategori($params, $where) {
        return $this->db->update('tbl_kategori', $params, $where);
    }

    function delete_tbl_kategori($where) {
        return $this->db->delete('tbl_kategori', $where);
    }

    function insert_tbl_pengguna($params) {
        return $this->db->insert('tbl_pengguna', $params);
    }

    function update_tbl_pengguna($params, $where) {
        return $this->db->update('tbl_pengguna', $params, $where);
    }

    function delete_tbl_pengguna($where) {
        return $this->db->delete('tbl_pengguna', $where);
    }

    function insert_tbl_level($params) {
        return $this->db->insert('tbl_level', $params);
    }

    function update_tbl_level($params, $where) {
        return $this->db->update('tbl_level', $params, $where);
    }

    function delete_tbl_level($where) {
        return $this->db->delete('tbl_level', $where);
    }
}