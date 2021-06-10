<?php

require_once("../header.inc.php");

// Check user got here via submit form
// "$_" is a super global
if (isset($_POST["submit"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $uname = $_POST["uname"];
    $passwd = $_POST["passwd"];
    $passwdconfirm = $_POST["passwdconfirm"];
    $qegsform = $_POST["qegsform"];

    // Catch empty inputs
    if (emptyInputSignup($name, $email, $uname, $passwd, $passwdconfirm, $qegsform) !== false) {
        // Throw error -> Error message -> include info in url header
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if (invalidUname($uname) !== false) {
        header("location: ../signup.php?error=invaliduname");
        exit();
    }
    if (matchPasswd($passwd, $passwdconfirm) !== false) {
        header("location: ../signup.php?error=nonmatchingpasswd");
        exit();
    }
    if (insecurePasswd($passwd) !== false) {
        header("location: ../signup.php?error=insecurepasswd");
        exit();
    }
    if (invalidForm($qegsform) !== false) {
        header("location: ../signup.php?error=invalidqegsform");
        exit();
    }
    if (unameExists($connection, $uname, $email) !== false) {
        header("location: ../signup.php?error=unameemailexists");
        exit();
    }
    createUser($connection, $name, $email, $uname, $passwd, $qegsform);
    header("location: ../index.php");
    exit();
}
else {
    header("location: ../signup.php?error=thereisnobackdoor");
    exit();
}
