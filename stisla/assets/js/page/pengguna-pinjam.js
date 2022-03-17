"use strict";

$(document).ready(function() {
	var judul_pinjam, judul_kembali, status_peminjaman, tgl_dikembalikan, no_buku_info, no_buku_kembali, status_info;

	$("#table-pinjam").dataTable({
	  "columnDefs": [
	    { "sortable": false, "targets": [6, 7] }
	  ]
	});

	$('.kembalikan-buku').click(function() {
		judul_kembali = $(this).data('judul');
		status_peminjaman = $(this).data('status');
		no_buku_kembali = $(this).data('no');

		$('#kembalikan-buku-id').val($(this).data('id')).change();
		$('#kembalikan-buku-nama').text($(this).data('nama')).change();
		$('#kembalikan-buku-judul').text(judul_kembali).change();
		$('#kembalikan-buku-no').text(no_buku_kembali).change();
		$('#kembalikan-buku-tgl-pinjam').text($(this).data('tgl-pinjam')).change();
		$('#kembalikan-buku-tgl-kembali').text($(this).data('tgl-kembali')).change();
		$('#kembalikan-buku-denda').text($(this).data('denda')).change();
		$('#kembalikan-buku-tgl-dikembalikan').text($(this).data('tgl-dikembalikan')).change();

		if (status_peminjaman == 'diajukan') {
			$('#konfirmasi-kembali').hide();
		}

		if (no_buku_kembali == '') {
			$('#kembalikan-buku-no').text('Nomor buku masih kosong.').addClass('text-danger').change();
		} else {
			$('#kembalikan-buku-no').text($(this).data('no')).change();
		}
	});

	$('.baca-buku').click(function() {
        var path = $(this).data('file');
        $('#source-file').attr('data', path);
        $('#alt-file').attr('href', path);
        $('.modal-title').text($(this).data('judul'));
    });

  	$(".file-kosong").click(function() {
		swal('File Tidak Ada', 'File belum diunggah oleh Admin Perpustakaan!', 'error');
	});

	$(".cover-kosong").click(function() {
		swal('Cover Tidak Ada', 'Cover belum diunggah oleh Admin Perpustakaan!', 'error');
	});

	$('#konfirmasi-kembali').click(function(e) {
	  e.preventDefault();
	  let form = $(this).parents('form');
	  swal({
	      title: 'Kembalikan Buku?',
	      text: 'Anda akan mengembalikan buku ' + judul_kembali,
	      icon: 'warning',
	      buttons: true,
	      dangerMode: true,
	    })
	    .then((result) => {
	      if (result) {
	      form.submit();
	      } else {
	      swal('Buku tidak jadi dikembalikan!', {
	      	icon: 'error',
	      });
	     }
	   });
	});

	$('.info-peminjaman').click(function() {
		judul_pinjam = $(this).data('judul');
		tgl_dikembalikan = $(this).data('tgl-dikembalikan');
		no_buku_info = $(this).data('no');
		status_info = $(this).data('status');

		$('#pinjam-buku-id').val($(this).data('id')).change();
		$('#info-peminjaman-nama').text($(this).data('nama')).change();
		$('#info-peminjaman-judul').text(judul_pinjam).change();
		$('#info-peminjaman-no').text(no_buku_info).change();
		$('#info-peminjaman-tgl-pinjam').text($(this).data('tgl-pinjam')).change();
		$('#info-peminjaman-tgl-kembali').text($(this).data('tgl-kembali')).change();
		$('#info-peminjaman-tgl-dikembalikan').text(tgl_dikembalikan).change();
		$('#info-peminjaman-denda').text($(this).data('denda')).change();

		if (tgl_dikembalikan == '') {
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

		if (no_buku_info == '') {
			$('#info-peminjaman-no').text('Nomor buku masih kosong.').addClass('text-danger').change();
		} else {
			$('#info-peminjaman-no').text($(this).data('no')).change();
		}

		if (status_info == 'diajukan') {
			$('#konfirmasi-pinjam').hide();
		}
	})

	$('#konfirmasi-pinjam').click(function(e) {
	  e.preventDefault();
	  let form = $(this).parents('form');
	  swal({
	      title: 'Pinjam Buku Kembali?',
	      text: 'Anda akan meminjam buku ' + judul_pinjam,
	      icon: 'warning',
	      buttons: true,
	      dangerMode: true,
	    })
	    .then((result) => {
	      if (result) {
	      form.submit();
	      } else {
	      swal('Buku tidak jadi dipinjam!', {
	      	icon: 'error',
	      });
	     }
	   });
	});
});

