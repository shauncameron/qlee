<?php require_once("../include/header.inc.php"); ?>
<html lang="en">
    <head>
        <title> Qlee -> Home </title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="../css/reset.css"/>
        <link rel="stylesheet" href="../css/~debug.css"/>
        <link rel="stylesheet" href="../css/forum-main.css"/>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <?php require_once("../include/navigation.php"); ?>
    </head>
    <body>
        <div>
            <style>
                #remarkuserinput, #remarkuseroutput {
                    border: 5px solid #cfcfc4;
                    padding: 5px;
                    height: 270px;
                    margin: 10px auto;
                    margin-left: 10px;
                    margin-right: 10px;
                    overflow: hidden;
                    overflow-y: scroll;
                }
            </style>
                <div id="remarkuserinput" onchange="refreshMessageData()" contenteditable="true"></div>
                <script src="getremark.js"></script>
                <div id="remarkuseroutput" style="user-select: none;">Your remark will appear here</div>
            </article>
        </div>
    </body>
    <foot>
    </foot>
</html>