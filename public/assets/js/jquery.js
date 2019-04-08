$('.select-all').click(function(event) {  
    var nivel = $(this).attr('nivel');
    //alert('Nivel = '+nivel);
    if(this.checked) {
        $('.checkbox_categorie_'+nivel).each(function() {
            this.checked = true;                        
        });
    } else {
        $('.checkbox_categorie_'+nivel).each(function() {
            this.checked = false;                       
        });
    }
});


