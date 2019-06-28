$(document).ready(function() {

    let inProgress = false;
    let $textField = $('#profile__create__text');
    let $shareButton = $('#profile__create__button');

    $textField.on('focus', function() {
        $(this).attr('rows', 3);
        $shareButton.css('display', 'flex');
    });

    $textField.on('blur', function() {
        if ($(this).val() === '') {
            $(this).attr('rows', 1);
            $(this).css('height', '');
            $shareButton.css('display', 'none');
        }
    });

    $textField.on('input', function() {
        $(this).css('height', '');
        $(this).css('height', this.scrollHeight - 32 + 'px');
    });

    $shareButton.on('click', function() {
        if (inProgress === false) {
            // only if not in progress
            inProgress = true;
            // adding loading icon
            $(this).html('<i class="fas fa-spinner fa-spin" style="font-size: 19px"></i>');

            $.ajax({
                type: 'post',
                url: window.location.pathname + '/create',
                data: {
                    'text': $textField.val()
                },
                success: (data, textStatus) => {
                    if (textStatus === 'success') {
                        if (data) {
                            // remove message that there is no posts
                            $('#empty').remove();
                            // adding list of posts from response to start of posts container
                            $('#posts').prepend(data);
                            // minimize long posts
                            minimize();
                            // clear input field
                            clear();
                            // change share button text to default
                            $shareButton.text('Поделиться');
                            // increment number of posts
                            document.getElementsByClassName('profile__detail__item__count')[0].innerText++;
                        }
                    } else {
                        // anyway if there is an error change share button text to default
                        $shareButton.text('Поделиться');
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
        $textField.val('').attr('rows', 1).css('height', '');
        $shareButton.css('display', 'none');
    }

});