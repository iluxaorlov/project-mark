$(document).ready(function() {

    let inProgress = false;

    $('#posts').on('click', function(event) {
        let element = event.target;

        if ($(element).hasClass('post__head__menu__list__delete')) {
            if (inProgress === false) {
                // only if not in progress
                inProgress = true;

                $.ajax({
                    type: 'post',
                    url: '/' + $(element).parents('.post').attr('id') + '/delete',
                    success: () => {
                        if (document.getElementsByClassName('profile__detail__item__count')[0]) {
                            // it is true if current user on his page
                            document.getElementsByClassName('profile__detail__item__count')[0].innerText--;
                        }

                        $(element).parents('.post').fadeOut(250, 'linear', function() {
                            // remove element after fading out
                            $(element).remove();

                            if (document.getElementsByClassName('post').length < 1) {
                                // if there is no more posts then show message
                                $('#posts').html('<p id="empty">Записи не найдены</p>');
                            }
                        });
                    },
                    complete: () => {
                        inProgress = false;
                    }
                });
            }
        }
    });

});