"use strict";

$(document).ready(function() {
	var judul_pinjam, judul_kembali;

	$("#table-buku").dataTable({
	  "columnDefs": [
	    { "sortable": false, "targets": [3, 4] }
	  ]
	});

	$('.pinjam-buku').click(function() {
		judul_pinjam = $(this).data('judul');
		$('#pinjam-buku-id').val($(this).data('id')).change();
		$('#pinjam-buku-nama').text($(this).data('nama')).change();
		$('#pinjam-buku-judul').text(judul_pinjam).change();
	});

	$('.kembalikan-buku').click(function() {
		judul_kembali = $(this).data('judul');

		$('#kembalikan-buku-id').val($(this).data('id')).change();
		$('#kembalikan-buku-nama').text($(this).data('nama')).change();
		$('#kembalikan-buku-judul').text(judul_kembali).change();
		$('#kembalikan-buku-tgl-pinjam').text($(this).data('tgl-pinjam')).change();
		$('#kembalikan-buku-tgl-kembali').text($(this).data('tgl-kembali')).change();
		$('#kembalikan-buku-denda').text($(this).data('denda')).change();
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

	$('#konfirmasi-pinjam').click(function(e) {
	  e.preventDefault();
	  let form = $(this).parents('form');
	  swal({
	      title: 'Pinjam Buku?',
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
});

