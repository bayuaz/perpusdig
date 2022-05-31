"use strict";

$(document).ready(function() {
	$("#table-pengguna").dataTable({
	  "columnDefs": [
	    { "sortable": false, "targets": [6] },
	    { "width": "21%", "targets": [4]}
	  ]
	});

	$('.level-pengguna').select2({
    	dropdownParent: $("#tambah-pengguna")
	});

  	$('.level-pengguna-ubah').select2({
    	dropdownParent: $("#modal-ubah-pengguna")
  	});

  	$('.ubah-pengguna').click(function() {
		var nohp;

		if ($(this).data('nohp') == '') {
			nohp = '+62';
		} else {
			nohp = $(this).data('nohp');
		}

	    $('#ubah-id').val($(this).data('id')).change();
	    $('#ubah-level').val($(this).data('level')).change();
	    $('#ubah-nis-nip').val($(this).data('nis-nip')).change();
	    $('#ubah-nama').val($(this).data('nama')).change();
	    $('#ubah-pass').val($(this).data('pass')).change();
	    $('#ubah-email').val($(this).data('email')).change();
	    $('#ubah-nohp').val(nohp).change();
	    $('#ubah-bio').summernote('code', $(this).data('bio'));
	    $('#ubah-alamat').summernote('code', $(this).data('alamat'));
  	});

  	$('.hapus-pengguna').click(function() {
	    $('#hapus-id').val($(this).data('id')).change();
	    $('#hapus-level').val($(this).data('level')).change();
	    $('#hapus-nis-nip').val($(this).data('nis-nip')).change();
	    $('#hapus-nama').val($(this).data('nama')).change();
	    $('#hapus-pass').val($(this).data('pass')).change();
	    $('#hapus-email').val($(this).data('email')).change();
	    $('#hapus-nohp').val($(this).data('nohp')).change();
	    $('#hapus-bio').summernote('code', $(this).data('bio'));
	    $('#hapus-bio').summernote('disable');
	    $('#hapus-alamat').summernote('code', $(this).data('alamat'));
	    $('#hapus-alamat').summernote('disable');
  	});
});

var cleaveI = new Cleave('.nohp-input', {
  prefix: '+62',
  blocks: [15],
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