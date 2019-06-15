$(document).ready(function() {

    if (document.getElementById('user_about')) {
        $('#user_about').css('height', 57 + 'px');
        $('#user_about').css('height', document.getElementById('user_about').scrollHeight - 32 + 'px');
    }

    $('#user_about').on('input', function() {
        $(this).css('height', 57 + 'px');
        $(this).css('height', this.scrollHeight - 32 + 'px');
    });

});