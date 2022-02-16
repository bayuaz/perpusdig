"use strict";

$(document).ready(function() {
	$("#table-peminjaman").dataTable({
	  "columnDefs": [
	    { "sortable": false, "targets": [5] }
	  ]
	});
});