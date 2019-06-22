$(document).ready(function() {

    $('#posts').on('click', function(event) {
        let element = event.target;

        if ($(element).hasClass('post__head__menu__list__delete')) {
            event.preventDefault();

            let $post = $(element).parent().parent().parent().parent();

            $.ajax({
                type: 'POST',
                url: '/' + $post.attr('id') + '/delete',
                success: () => {
                    document.getElementsByClassName('profile__detail__item__count')[0].innerText--;

                    $post.fadeOut(250, 'linear', function() {
                        $(this).remove();

                        if (document.getElementsByClassName('post').length < 1) {
                            $('#posts').html('<p id="empty">Записи не найдены</p>');
                        }
                    });
                }
            });
        }
    });

});