"use strict";

$(document).ready(function() {
	var info_tgl_dikembalikan, proses_tgl_dikembalikan, info_nobuku_peminjaman, proses_nobuku_peminjaman;

	$("#table-peminjaman").dataTable({
	  "columnDefs": [
	    { "sortable": false, "targets": [7] }
	  ]
	});

	$('.proses-peminjaman').click(function() {
		proses_tgl_dikembalikan = $(this).data('tgl-dikembalikan');
		proses_nobuku_peminjaman = $(this).data('no');
		
		$('#proses-pinjam-status').text($(this).data('status')).change()
		$('#proses-pinjam-nis-nip-pengguna').val($(this).data('nis-nip-pengguna')).change();
		$('#proses-pinjam-id-buku').val($(this).data('id-buku')).change();
		$('#proses-pinjam-kode-buku').val($(this).data('kode-buku')).change();
		$('#proses-pinjam-nama').text($(this).data('nama')).change();
		$('#proses-pinjam-judul').text($(this).data('judul')).change();
		$('#proses-pinjam-no').text($(this).data('no')).change();
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

		if (proses_nobuku_peminjaman == '') {
			$('#proses-pinjam-no').text('Nomor buku masih kosong. Silahkan isi terlebih dahulu!').addClass('text-danger').change();
		} else {
			$('#proses-pinjam-no').text($(this).data('no')).change();
			$('#tutup-modal').hide();
		}
	});

	$('.info-peminjaman').click(function() {
		info_tgl_dikembalikan = $(this).data('tgl-dikembalikan');
		info_nobuku_peminjaman = $(this).data('no');

		$('#info-peminjaman-nama').text($(this).data('nama')).change();
		$('#info-peminjaman-judul').text($(this).data('judul')).change();
		$('#info-peminjaman-no').text($(this).data('no')).change();
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

		if (info_nobuku_peminjaman == '') {
			$('#info-peminjaman-no').text('Nomor buku masih kosong. Silahkan isi terlebih dahulu!').addClass('text-danger').change();
			$('#setujui-peminjaman').hide();
		} else {
			$('#info-peminjaman-no').text($(this).data('no')).change();
		}
	});

	$('.ubah-peminjaman').click(function() {
	    $('#ubah-id').val($(this).data('id')).change();
	    $('#ubah-nis-nip').val($(this).data('nis-nip')).change();
	    $('#ubah-judul').val($(this).data('judul')).change();
	    $('#ubah-no').val($(this).data('no')).change();
  	});

  	$('.hapus-peminjaman').click(function() {
	    $('#hapus-id').val($(this).data('id')).change();
	    $('#hapus-nis-nip').val($(this).data('nis-nip')).change();
	    $('#hapus-judul').val($(this).data('judul')).change();
	    $('#hapus-no').val($(this).data('no')).change();
  	});
});

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode == 43) {
    	return true
    } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
    	return true;
    }
}