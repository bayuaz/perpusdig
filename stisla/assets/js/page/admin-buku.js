"use strict";

$(document).ready(function() {
	$("#table-buku").dataTable({
	  "columnDefs": [
	    { "sortable": false, "targets": [5, 6] }
	  ]
	});

	$('.kategori-buku').select2({
    	dropdownParent: $("#tambah-buku")
	});

  	$('.kategori-buku-ubah').select2({
    	dropdownParent: $("#modal-ubah-buku")
  	});

  	$('.ubah-buku').click(function() {
	    $('#ubah-id').val($(this).data('id')).change();
	    $('#ubah-kategori').val($(this).data('kategori')).change();
	    $('#ubah-judul').val($(this).data('judul')).change();
	    $('#ubah-kode').val($(this).data('kode')).change();
	    $('#ubah-pengarang').val($(this).data('pengarang')).change();
	    $('#ubah-penerbit').val($(this).data('penerbit')).change();
	    $('#ubah-tahun-terbit').val($(this).data('tahun-terbit')).change();
	    $('#ubah-jumlah').val($(this).data('jumlah')).change();
  	});

  	$('.hapus-buku').click(function() {
	    $('#hapus-id').val($(this).data('id')).change();
	    $('#hapus-kategori').val($(this).data('kategori')).change();
	    $('#hapus-judul').val($(this).data('judul')).change();
	    $('#hapus-kode').val($(this).data('kode')).change();
	    $('#hapus-pengarang').val($(this).data('pengarang')).change();
	    $('#hapus-penerbit').val($(this).data('penerbit')).change();
	    $('#hapus-tahun-terbit').val($(this).data('tahun-terbit')).change();
	    $('#hapus-jumlah').val($(this).data('jumlah')).change();
  	});
});

var cleaveDT = new Cleave('#tambah-tahun-terbit', {
  date: true,
  datePattern: ['Y']
});

var cleaveDU = new Cleave('#ubah-tahun-terbit', {
  date: true,
  datePattern: ['Y']
});

var cleaveBT = new Cleave('#tambah-jumlah', {
  numeral: true,
  numeralThousandsGroupStyle: 'thousand'
});

var cleaveBU = new Cleave('#ubah-jumlah', {
  numeral: true,
  numeralThousandsGroupStyle: 'thousand'
});