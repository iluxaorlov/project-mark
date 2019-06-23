$(document).ready(function() {

    let inProgress = false;

    $(window).on('scroll', function() {
        if (window.scrollY >= document.documentElement.scrollHeight - window.innerHeight - window.innerHeight) {
            if ($('#posts').length > 0) {
                if (inProgress === false) {
                    loadPublications();
                }
            }

            if ($('#users').length > 0) {
                if (inProgress === false) {
                    loadUsers();
                }
            }
        }
    });

    function loadPublications() {
        inProgress = true;

        $.ajax({
            type: 'post',
            url: window.location.pathname,
            data: {
                'offset': $('.post').length
            },
            success: function(data, textStatus) {
                if (textStatus === 'success') {
                    if (data) {
                        $('#posts').append(data);
                        inProgress = false;
                        minimize();
                    }
                }
            }
        });
    }

    function loadUsers() {
        inProgress = true;

        $.ajax({
            type: 'post',
            url: window.location.pathname,
            data: {
                'offset': $('.user').length
            },
            success: function(data, textStatus) {
                if (textStatus === 'success') {
                    if (data) {
                        $('#users').append(data);
                        inProgress = false;
                    }
                }
            }
        });
    }

    function minimize() {
        $('.post__body__text').each(function(index, element) {
            if ($(element).children('.post__body__text__hide').length > 0) {
                $(element).css('cursor', 'pointer');
            }
        });
    }

});