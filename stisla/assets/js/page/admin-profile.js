"use strict";

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