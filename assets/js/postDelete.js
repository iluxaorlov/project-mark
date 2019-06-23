$(document).ready(function() {

    let $posts = $('#posts');

    $posts.on('click', function(event) {
        let element = event.target;

        if ($(element).hasClass('post__head__menu__list__delete')) {
            $.ajax({
                type: 'post',
                url: '/' + $(element).parents('.post').attr('id') + '/delete',
                success: () => {
                    if (document.getElementsByClassName('profile__detail__item__count')[0]) {
                        document.getElementsByClassName('profile__detail__item__count')[0].innerText--;
                    }

                    $(element).parents('.post').fadeOut(250, 'linear', function() {
                        $(element).remove();

                        if (document.getElementsByClassName('post').length < 1) {
                            $posts.html('<p id="empty">Записи не найдены</p>');
                        }
                    });
                }
            });
        }
    });

});