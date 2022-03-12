"use strict";

$(document).ready(function() {
	var info_tgl_dikembalikan, proses_tgl_dikembalikan;

	$("#table-peminjaman").dataTable({
	  "columnDefs": [
	    { "sortable": false, "targets": [7] }
	  ]
	});

	$('.proses-peminjaman').click(function() {
		proses_tgl_dikembalikan = $(this).data('tgl-dikembalikan');
		
		$('#proses-pinjam-status').text($(this).data('status')).change()
		$('#proses-pinjam-id-pengguna').val($(this).data('id-pengguna')).change();
		$('#proses-pinjam-id-buku').val($(this).data('id-buku')).change();
		$('#proses-pinjam-nama').text($(this).data('nama')).change();
		$('#proses-pinjam-judul').text($(this).data('judul')).change();
		$('#proses-pinjam-tgl-pinjam').text($(this).data('tgl-pinjam')).change();
		$('#proses-pinjam-tgl-kembali').text($(this).data('tgl-kembali')).change();
		$('#proses-pinjam-tgl-dikembalikan').text($(this).data('tgl-dikembalikan')).change();
		$('#proses-pinjam-denda').text($(this).data('denda')).change();

		if (proses_tgl_dikembalikan == '') {
			$('#proses-label-dikembalikan').hide();
			$('#proses-pinjam-tgl-dikembalikan').hide();
			$('#proses-label-denda').hide();
			$('#proses-pinjam-denda').hide();
		} else {
			$('#proses-label-dikembalikan').show();
			$('#proses-pinjam-tgl-dikembalikan').show();
			$('#proses-label-denda').show();
			$('#proses-pinjam-denda').show();
		}
	});

	$('.info-peminjaman').click(function() {
		info_tgl_dikembalikan = $(this).data('tgl-dikembalikan');

		$('#info-peminjaman-nama').text($(this).data('nama')).change();
		$('#info-peminjaman-judul').text($(this).data('judul')).change();
		$('#info-peminjaman-tgl-pinjam').text($(this).data('tgl-pinjam')).change();
		$('#info-peminjaman-tgl-kembali').text($(this).data('tgl-kembali')).change();
		$('#info-peminjaman-tgl-dikembalikan').text(info_tgl_dikembalikan).change();
		$('#info-peminjaman-denda').text($(this).data('denda')).change();

		if (info_tgl_dikembalikan == '') {
			$('#info-label-dikembalikan').hide();
			$('#info-peminjaman-tgl-dikembalikan').hide();
			$('#info-label-denda').hide();
			$('#info-peminjaman-denda').hide();
		} else {
			$('#info-label-dikembalikan').show();
			$('#info-peminjaman-tgl-dikembalikan').show();
			$('#info-label-denda').show();
			$('#info-peminjaman-denda').show();
		}
	});
});