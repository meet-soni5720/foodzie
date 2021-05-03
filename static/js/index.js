$(document).ready(function () {
    var path = window.location.href;

    $('.navbar-nav a').each(function () {

        if (this.href === path) {
            $(this).addClass('active');
        }
        else {
            $(this).removeClass('active');
        }

    });

});



CKEDITOR.replace('body');
