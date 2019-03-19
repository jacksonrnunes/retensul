/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$('#select-all').click(function(event) {   
    if(this.checked) {
        $('.checkbox_categorie_nc').each(function() {
            this.checked = true;                        
        });
    } else {
        $('.checkbox_categorie_nc').each(function() {
            this.checked = false;                       
        });
    }
});
$(document).on('click', '#select-all-n2', function () {
    if(this.checked) {
        $('.checkbox_categorie_n2').each(function() {
            this.checked = true;                        
        });
    } else {
        $('.checkbox_categorie_n2').each(function() {
            this.checked = false;                       
        });
    }
});

