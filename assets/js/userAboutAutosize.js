$(document).ready(function() {

    let $aboutUser = $('#user_about');

    if (document.getElementById('user_about')) {
        $aboutUser.css('height', '');
        $aboutUser.css('height', document.getElementById('user_about').scrollHeight - 32 + 'px');
    }

    $aboutUser.on('input', function() {
        $(this).css('height', 57 + 'px');
        $(this).css('height', this.scrollHeight - 32 + 'px');
    });

});