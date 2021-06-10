function refreshMessageData () {
    $.post('../home.php', {value: 'Hello'}, function(data) {
        $('div#livemessages').append('<p> Hello </p>');
    })
}

setInterval(refreshMessageData, 1000);