<?php

if (isset($_POST["submit"])) {

    $login = $_POST["login"];
    $passwd = $_POST["passwd"];

    require_once "dbh.inc.php";
    require_once "functions.inc.php";

    if (emptyInputLogin($login, $passwd) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($connection, $login, $passwd);
}
else {
    header("location: ../login.php?error=thereisnobackdoor");
    exit();
}
