$(document).ready(function() {

    let inProgress = false;

    $(window).on('scroll', function() {
        if (window.scrollY >= document.documentElement.scrollHeight - window.innerHeight - window.innerHeight) {
            if ($('#posts').length > 0) {
                loading($('#posts'), $('.post'));
            }

            if ($('#users').length > 0) {
                loading($('#users'), $('.user'));
            }
        }
    });

    function loading($container, $items) {
        if (inProgress === false) {
            inProgress = true;

            $.ajax({
                type: 'post',
                url: window.location.pathname,
                data: {
                    'offset': $items.length
                },
                success: (data, textStatus) => {
                    if (textStatus === 'success') {
                        if (data) {
                            $container.append(data);
                            inProgress = false;

                            if ($($container).attr('id') === 'posts') {
                                // minimize long posts
                                minimize();
                            }
                        }
                    }
                }
            });
        }

        function minimize() {
            $('.post__body__text').each((index, element) => {
                if ($(element).children('.post__body__text__hide').length > 0) {
                    $(element).css('cursor', 'pointer');
                }
            });
        }
    }

});