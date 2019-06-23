$(document).ready(function() {

    let inProgress = false;

    $('#posts').on('click', function(event) {
        let element = event.target;

        if ($(element).hasClass('post__foot__like') || $(element).hasClass('post__foot__like__icon') || $(element).hasClass('post__foot__like__count')) {
            likeUnlike.call(element, 'like');
        }

        if ($(element).hasClass('post__foot__unlike') || $(element).hasClass('post__foot__unlike__icon') || $(element).hasClass('post__foot__unlike__count')) {
            likeUnlike.call(element, 'unlike');
        }
    });

    function likeUnlike(action) {
        if (inProgress === false) {
            inProgress = true;

            $.ajax({
                type: 'post',
                url: '/' + $(this).parents('.post').attr('id') + '/' + action,
                success: (data, textStatus) => {
                    if (textStatus === 'success') {
                        $(this).parents('.post__foot').html(data);
                        inProgress = false;
                    }
                }
            });
        }
    }

});