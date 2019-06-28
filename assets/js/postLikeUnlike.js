$(document).ready(function() {

    let inProgress = false;

    $('#posts').on('click', function(event) {
        let element = event.target;

        if ($(element).hasClass('post__foot__like') || $(element).hasClass('post__foot__like__icon') || $(element).hasClass('post__foot__like__count')) {
            // send request to like method
            likeUnlike.call(element, 'like');
        }

        if ($(element).hasClass('post__foot__unlike') || $(element).hasClass('post__foot__unlike__icon') || $(element).hasClass('post__foot__unlike__count')) {
            // send request to unlike method
            likeUnlike.call(element, 'unlike');
        }
    });

    function likeUnlike(action) {
        if (inProgress === false) {
            // only if not in progress
            inProgress = true;

            $.ajax({
                type: 'post',
                url: '/' + $(this).parents('.post').attr('id') + '/' + action,
                success: (data, textStatus) => {
                    if (textStatus === 'success') {
                        // adding like or unlike button from response
                        $(this).parents('.post__foot').html(data);
                    }
                },
                complete: () => {
                    inProgress = false;
                }
            });
        }
    }

});