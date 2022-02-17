"use strict";

$(document).ready(function() {
	var judul_pinjam, judul_kembali;

	$("#table-pinjam").dataTable({
	  "columnDefs": [
	    { "sortable": false, "targets": [5, 6] }
	  ]
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

