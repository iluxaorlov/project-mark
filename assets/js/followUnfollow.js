$(document).ready(function() {

    let inProgress = false;

    $('#profile__action').on('click', function(event) {
        let element = event.target;

        if ($(element).attr('id') === 'follow') {
            followUnfollow.call(element, 'follow');
        }

        if ($(element).attr('id') === 'unfollow') {
            followUnfollow.call(element, 'unfollow');
        }
    });

    function followUnfollow(action) {
        if (inProgress === false) {
            inProgress = true;
            // adding loading indicator
            $(this).html('<i class="fas fa-spinner fa-spin" style="font-size: 19px"></i>');

            $.ajax({
                type: 'post',
                url: window.location.pathname + '/' + action,
                success: (data, textStatus) => {
                    if (textStatus === 'success') {
                        if (data) {
                            // adding action button from response
                            $('#profile__action').html(data);

                            if (action === 'follow') {
                                // increment number of followers
                                document.getElementsByClassName('profile__detail__item__count')[2].innerText++;
                            }

                            if (action === 'unfollow') {
                                // decrement number of followers
                                document.getElementsByClassName('profile__detail__item__count')[2].innerText--;
                            }

                            inProgress = false;
                        }
                    }
                }
            });
        }
    }

});