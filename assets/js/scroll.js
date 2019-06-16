$(document).ready(function() {

    $('.profile__detail__item').filter(':first').on('click', function(event) {
        event.preventDefault();

        let $scrollTop = $('#posts').offset().top - 64;
        $('html, body').animate({
            scrollTop: $scrollTop
        }, 250);
    });

});