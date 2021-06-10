<?php require_once("include/header.inc.php"); ?>
<html lang="en">
    <head>
        <title> Qlee -> Home </title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="css/reset.css"/>
        <link rel="stylesheet" href="css/~debug.css"/>
        <link rel="stylesheet" href="css/forum-main.css"/>
        <?php require_once("include/navigation.php"); ?>
    </head>
    <body>
        <?php
            require_once("include/functions.utl.php");

            echo makeForumPost("Welcome to Qlee", "Shaun", "Shaun", "13:07/07/06/2021", getRemarkAPI(file_get_contents(__DIR__.'/rmk/indexwelcome.rmk')));
        ?>
    </body>
</html>