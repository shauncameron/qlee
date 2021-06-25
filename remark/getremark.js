$('body').on('DOMSubtreeModified', 'div#remarkuserinput', function refreshMessageData () {
    let content = $('div#remarkuserinput').html()
        .replaceAll('<br>', '\n')
        .replaceAll('</div>', '')
        .replaceAll('<div>', '\n');
    $.ajax(
        {
            type: 'GET',
            url: 'getremark.inc.php',
            data: {
                toremark: content
            }
        }
    ).done(function(data) {
        $('div#remarkuseroutput').html(data);
    })
});

/*
create table tbl_ChatLog (
 	chatLogID int not null primary key auto_increment,
    chatLogAuthorID int not null,
    chatLogContent varchar(4096) not null,
    chatLogCreation date not null default current_date(),
    foreign key (chatLogAuthorID) references tbl_Users(userID)
);

create table tbl_UserChatLog (
    userChatLogBoundUserID int not null,
 	userChatLog int not null,
    userReadChatLog boolean not null default false,
	foreign key (userChatLogBoundUserID) references table tbl_Users(userID),
	foreign key (userChatLog) references table tbl_ChatLog(chatLogID)
);
*/

//setInterval(refreshMessageData, 10)