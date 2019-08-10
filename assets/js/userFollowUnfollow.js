$(document).ready(function() {

    let inProgress = false;

    $('#profile__action').on('click', function(event) {
        let element = event.target;

        switch ($(element).attr('id')) {
            case 'follow':
                // if button is to follow
                followUnfollow.call(element, 'follow');
                break;
            case 'unfollow':
                // if button is to unfollow
                followUnfollow.call(element, 'unfollow');
                break;
        }
    });

    function followUnfollow(action) {
        if (inProgress === false) {
            // only if not in progress
            inProgress = true;
            // adding loading icon
            $(this).html('<img class="loading" src="/img/app/loading.svg" alt="">');

            $.ajax({
                type: 'post',
                url: window.location.pathname + '/' + action,
                success: (data, textStatus) => {
                    if (textStatus === 'success') {
                        if (data) {
                            // adding button with new action from response
                            $('#profile__action').html(data);

                            switch (action) {
                                case 'follow':
                                    // increment number of followers
                                    document.getElementsByClassName('profile__detail__item__count')[2].innerText++;
                                    break;
                                case 'unfollow':
                                    // decrement number of followers
                                    document.getElementsByClassName('profile__detail__item__count')[2].innerText--;
                            }
                        }
                    }
                },
                complete: () => {
                    inProgress = false;
                }
            });
        }
    }

});