$(document).ready(function() {

    let inProgress = false;
    let $text = $('#profile__create__text');
    let $button = $('#profile__create__button');

    $text.on('focus', function() {
        $(this).attr('rows', 3);
        $button.css('display', 'flex');
    });

    $text.on('blur', function() {
        if (!$(this).val()) {
            $(this).attr('rows', 1);
            $(this).css('height', '');
            $button.css('display', 'none');
        }
    });

    $text.on('input', function() {
        $(this).css('height', '');
        $(this).css('height', this.scrollHeight - 32 + 'px');
    });

    $button.on('click', function() {
        if (inProgress === false) {
            inProgress = true;

            $(this).html('<i class="fas fa-spinner fa-spin" style="font-size: 19px"></i>');

            $.ajax({
                type: 'post',
                url: window.location.pathname + '/create',
                data: {
                    'text': $text.val()
                },
                success: (data, textStatus) => {
                    if (textStatus === 'success') {
                        if (data) {
                            $('#empty').remove();
                            $('#posts').prepend(data);
                            minimize();
                            clear();
                            $button.text('Поделиться');
                            // increment number of posts
                            document.getElementsByClassName('profile__detail__item__count')[0].innerText++;
                        }
                    } else {
                        $button.text('Поделиться');
                    }
                },
                complete: () => {
                    inProgress = false;
                }
            });
        }
    });

    function minimize() {
        $('.post__body__text').each(function(index, element) {
            if ($(element).children('.post__body__text__hide').length > 0) {
                $(element).css('cursor', 'pointer');
            }
        });
    }

    function clear() {
        $text.val('').attr('rows', 1).css('height', '');
        $button.css('display', 'none');
    }

});