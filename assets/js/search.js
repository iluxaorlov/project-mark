$(document).ready(function() {

    let timeout;

    $('#search').on('input', function() {
        clearTimeout(timeout);

        if ($(this).val().trim()) {
            timeout = setTimeout(search, 1000);
        } else {
            $('#users').html('');
        }
    });

    function search() {
        $.ajax({
            type: 'POST',
            url: '/search',
            data: {
                'query': $('#search').val()
            },
            success: (data, textStatus) => {
                if (textStatus === 'success') {
                    if (data) {
                        if ($('#search').val().trim()) {
                            $('#users').html(data);
                        } else {
                            $('#users').html('');
                        }
                    }
                } else {
                    if ($('#search').val().trim()) {
                        $('#users').html('<p id="empty">Ничего не найдено</p>');
                    } else {
                        $('#users').html('');
                    }
                }
            }
        });
    }

});