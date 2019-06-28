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
                // save hide text
                let $text = $(element).children('.post__body__text__hide').html();
                // remove section with hide text
                $(element).children('.post__body__text__hide').remove();
                // remove three dots
                $(element).children('.post__body__text__show').remove();
                // concatenate visible text and hide text
                $(element).html($(element).html() + $text);
                $(element).css('cursor', '');
            }
        }

        if ($(element).hasClass('post__body__text__show')) {
            // like clicking on text
            $(element).parent().click();
        }
    });

});