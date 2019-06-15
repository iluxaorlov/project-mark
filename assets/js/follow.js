$(document).ready(function() {

    function follow() {
        $('#follow').on('click', function() {
            if (document.getElementById('load')) {
                return;
            }

            $(this).html('<i id="load" class="fas fa-spinner fa-spin" style="font-size: 19px"></i>');
            $.ajax({
                type: 'post',
                url: window.location.pathname + '/follow',
                success: function(data, textStatus) {
                    if (textStatus === 'success') {
                        if (data) {
                            $('#profile__action').html(data);
                            document.getElementsByClassName('profile__detail__item__count')[2].innerText++;
                            unfollow();
                        }
                    }
                }
            });
        });
    }

    function unfollow() {
        $('#unfollow').on('click', function() {
            if (document.getElementById('load')) {
                return;
            }

            $(this).html('<i id="load" class="fas fa-spinner fa-spin" style="font-size: 19px"></i>');
            $.ajax({
                type: 'post',
                url: window.location.pathname + '/unfollow',
                success: function(data, textStatus) {
                    if (textStatus === 'success') {
                        if (data) {
                            $('#profile__action').html(data);
                            document.getElementsByClassName('profile__detail__item__count')[2].innerText--;
                            follow();
                        }
                    }
                }
            });
        });
    }

    follow();
    unfollow();

});