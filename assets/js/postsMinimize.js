$(document).ready(function() {

    $('.post__body__text').each(function(index, element) {
        if ($(element).children('.post__body__text__hide').length > 0) {
            $(element).css('cursor', 'pointer');
        }
    });

    $('#posts').on('click', function(event) {
        let element = event.target;

        if ($(element).hasClass('post__body__text')) {
            if ($(element).children('.post__body__text__hide').length > 0) {
                let $text = $(element).children('.post__body__text__hide').html();
                $(element).children('.post__body__text__hide').remove();
                $(element).children('.post__body__text__show').remove();
                $(element).html($(element).html() + $text);
                $(element).css('cursor', '');
            }
        }

        if ($(element).hasClass('post__body__text__show')) {
            $(element).parent().click();
        }
    });

});