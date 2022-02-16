"use strict";

$(document).ready(function() {
	$("#table-kategori").dataTable({
	  "columnDefs": [
	    { "sortable": false, "targets": [4] }
	  ]
	});

  	$('.ubah-kategori').click(function() {
	    $('#ubah-id').val($(this).data('id')).change();
	    $('#ubah-nama').val($(this).data('nama')).change();
	    $('#ubah-keterangan').summernote('code', $(this).data('keterangan'));
  	});

  	$('.hapus-kategori').click(function() {
	    $('#hapus-id').val($(this).data('id')).change();
	    $('#hapus-nama').val($(this).data('nama')).change();
	    $('#hapus-keterangan').summernote('code', $(this).data('keterangan'));
	    $('#hapus-keterangan').summernote('disable');
  	});
});