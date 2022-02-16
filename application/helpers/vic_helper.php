<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function hariIndo($tanggal) {
  switch ($tanggal) {
    case 'Sunday':
      return 'Minggu';
    case 'Monday':
      return 'Senin';
    case 'Tuesday':
      return 'Selasa';
    case 'Wednesday':
      return 'Rabu';
    case 'Thursday':
      return 'Kamis';
    case 'Friday':
      return 'Jumat';
    case 'Saturday':
      return 'Sabtu';
    default:
      return 'hari tidak valid';
  }
}

function tglIndo($tanggal) {
  if (!empty($tanggal)) {
    $bulan = array (
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
  );
  $tgl_bln_thn = explode('-', $tanggal);

  return  substr($tgl_bln_thn[2],0,4) . ' ' . $bulan[ (int)$tgl_bln_thn[1] ] . ' ' . $tgl_bln_thn[0];
  }
}

function rupiah($nilai) {
  return 'Rp. '.number_format($nilai,0,",",".");
}

?>