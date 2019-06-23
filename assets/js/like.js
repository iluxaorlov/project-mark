$(document).ready(function() {

    let inProgress = false;

    (function like() {
        $('#posts').on('click', function(event) {
            let element = event.target;

            if ($(element).hasClass('post__foot__like') || $(element).hasClass('post__foot__like__icon') || $(element).hasClass('post__foot__like__count')) {
                if (inProgress === false) {
                    inProgress = true;
                    $.ajax({
                        type: 'post',
                        url: '/' + $(element).parents('.post').attr('id') + '/like',
                        success: (data, textStatus) => {
                            if (textStatus === 'success') {
                                $(element).parents('.post__foot').html(data);
                                inProgress = false;
                            }
                        }
                    });
                }
            }
        });
    })();

    (function unlike() {
        $('#posts').on('click', function(event) {
            let element = event.target;

            if ($(element).hasClass('post__foot__unlike') || $(element).hasClass('post__foot__unlike__icon') || $(element).hasClass('post__foot__unlike__count')) {
                if (inProgress === false) {
                    inProgress = true;
                    $.ajax({
                        type: 'post',
                        url: '/' + $(element).parents('.post').attr('id') + '/unlike',
                        success: (data, textStatus) => {
                            if (textStatus === 'success') {
                                $(element).parents('.post__foot').html(data);
                                inProgress = false;
                            }
                        }
                    });
                }
            }
        });
    })();

});