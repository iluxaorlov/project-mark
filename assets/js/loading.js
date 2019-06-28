$(document).ready(function() {

    let inProgress = false;

    $(window).on('scroll', function() {
        if (window.scrollY >= document.documentElement.scrollHeight - window.innerHeight - window.innerHeight) {
            if ($('#posts').length > 0) {
                // length of posts is offset for request
                loading.call($('#posts'), $('.post').length);
            }

            if ($('#users').length > 0) {
                // length of users is offset for request
                loading.call($('#users'), $('.user').length);
            }
        }
    });

    function loading(offset) {
        if (inProgress === false) {
            // only if not in progress
            inProgress = true;

            $.ajax({
                type: 'post',
                url: window.location.pathname,
                data: {
                    'offset': offset
                },
                success: (data, textStatus) => {
                    if (textStatus === 'success') {
                        if (data) {
                            // appending elements form response
                            $(this).append(data);

                            if ($(this).attr('id') === 'posts') {
                                // minimize long posts
                                minimize();
                            }
                        }
                    }
                },
                complete: () => {
                    inProgress = false;
                }
            });
        }
    }

    function minimize() {
        $('.post__body__text').each((index, element) => {
            if ($(element).children('.post__body__text__hide').length > 0) {
                $(element).css('cursor', 'pointer');
            }
        });
    }

});