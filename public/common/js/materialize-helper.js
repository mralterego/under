$('.input-daterange input.form-control').each(function() {
    $(this).datepicker({
        language: 'ru'
    });

});
// интерактивность
$(document).ready(function() {
    $('.remove-action').closeFAB();
});