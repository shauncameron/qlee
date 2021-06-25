<?php include_once "include/header.php"?>
<html lang="en">
<head>
    <title>Site with login (signup)</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="css/reset.css"/>
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="stylesheet" href="css/login-form.css"/>
    <script src="js/siteutils.js"></script>
</head>
<body>
<?php include_once "./include/navigation.php"?>
<div class="submit-form">
    <h2> Log In </h2>
    <form action="include/login.inc.php" method="post">
        <label> Username/ Email
            <input type="text" name="login" placeholder="Userame/Email..">
        </label>
        <label> Password
            <input type="password" name="passwd" placeholder="Password..">
        </label>
        <input class="submit-form-input" type="submit" name="submit" value="Log In!">
    </form>
</div>
<?php
include_once "include/popup.php";

if (isset($_GET["error"])) {
    $error = $_GET["error"];
    if ($error == "emptyinput") {
        q_error_popup("Please fill in all fields");
    }
    elseif ($error == "unamenotexists") {
        q_error_popup("User with that email/username doesn't exist");
    }
    elseif ($error == "wrongpasswd") {
        q_error_popup("Password doesn't match with that username/email");
    }
    elseif ($error == "mustbeloggedin") {
        q_warn_popup("Oops, to enter that page you must be logged in");
    }
    elseif ($error == "thereisnobackdoor") {
        q_warn_popup("To process login submission, request must come from pressing log in");
    }
}
if (isset($_GET["alert_error"])) {
    q_error_popup($_GET["alert_error"]);
}
if (isset($_GET["alert_info"])) {
    q_info_popup($_GET["alert_info"]);
}
if (isset($_GET["alert_warn"])) {
    q_warn_popup($_GET["alert_warn"]);
}
if (isset($_GET["alert_success"])) {
    q_success_popup($_GET["alert_success"]);
}
?>
</body>
</html>
