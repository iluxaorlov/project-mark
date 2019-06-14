$(document).ready(function() {

    let alreadyLoad = false;

    $(window).on('scroll', function() {
        if (window.scrollY >= document.documentElement.scrollHeight - window.innerHeight - window.innerHeight) {
            if ($('#publications').length > 0) {
                if (!alreadyLoad) {
                    loadPublications();
                }
            }

            if ($('#users').length > 0) {
                if (!alreadyLoad) {
                    loadUsers();
                }
            }
        }
    });

    function loadPublications() {
        alreadyLoad = true;

        $.ajax({
            type: 'post',
            url: window.location.pathname,
            data: {
                'offset': $('.publication').length
            },
            success: function(data, textStatus) {
                if (textStatus === 'success') {
                    if (data) {
                        $('#publications').append(data);
                        alreadyLoad = false;
                        minimize();
                    }
                }
            }
        });
    }

    function loadUsers() {
        alreadyLoad = true;

        $.ajax({
            type: 'post',
            url: window.location.pathname.replace(/\/$/, '') + '/load',
            data: {
                'offset': $('.user').length
            },
            success: function(data, textStatus) {
                if (textStatus === 'success') {
                    if (data) {
                        $('#users').append(data);
                        alreadyLoad = false;
                    }
                }
            }
        });
    }

    function minimize() {
        $text.each(function(index, element) {
            if ($(element).children('.publication__body__text__hide').length > 0) {
                $(element).css('cursor', 'pointer');
            }
        });
    }

});