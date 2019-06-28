$(document).ready(function() {

    // creating variable for timer
    let timer;

    $('#search').on('input', function() {
        // every keydown will clear the timer
        clearTimeout(timer);

        if ($(this).val().trim()) {
            // if query is not empty then starting the timer
            timer = setTimeout(search, 1000);
        } else {
            // if query is empty then clear list of users
            $('#users').html('');
        }
    });

    function search() {
        $.ajax({
            type: 'post',
            url: window.location.pathname,
            data: {
                'query': $('#search').val().trim()
            },
            success: (data, textStatus) => {
                if ($('#search').val().trim()) {
                    if (textStatus === 'success') {
                        if (data) {
                            // adding list of users from response
                            $('#users').html(data);
                        }
                    } else {
                        // if there is no results then show message
                        $('#users').html('<p id="empty">Ничего не найдено</p>');
                    }
                } else {
                    // if query is empty then clear list of users
                    $('#users').html('');
                }
            }
        });
    }

});