<?php require_once("include/header.inc.php"); ?>

<html lang="en">
    <head>
        <title>Site with login (signup)</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="css/reset.css"/>
        <link rel="stylesheet" href="css/signup-form.css"/>
    </head>
    <body>
    <?php require_once("include/navigation.php"); ?>
    <div class="submit-form">
        <h2> Sign Up </h2>
        <form action="include/signup.inc.php" method="post">
            <label> Full Name
                <input type="text" name="name" placeholder="Full Name..">
            </label>
            <label> Email
                <input type="text" name="email" placeholder="Email..">
            </label>
            <label> Username
                <input type="text" name="uname" placeholder="Username..">
            </label>
            <label> Password
                <input type="password" name="passwd" placeholder="Password..">
            </label>
            <label> Confirm Password
                <input type="password" name="passwdconfirm" placeholder="Confirm Password..">
            </label>
            <label>
                <select name="qegsform">
                    <?php
                    for ($i=7;$i<=11;$i++) {
                        foreach (["Q", "E", "G", "S", "F"] as $f):?>
                            <option value=<?php echo "'", $i, $f, "'";?>><?php echo $i, $f;?></option>
                        <?php endforeach; } ?>
                    <?php
                    for ($i=12;$i<=13;$i++) {
                        foreach (["A", "B", "C", "D", "E", "F"] as $f):?>
                            <option value=<?php echo "'", $i, $f, "'" ;?>><?php echo $i, $f;?></option>
                        <?php endforeach; } ?>
                </select>
            </label>
            <input class="submit-form-input" type="submit" name="submit" value="Sign Up!">
        </form>
    </div>
    <?php
    require_once("include/aesth/popup.php");

    if (isset($_GET["error"])) {
        $error = $_GET["error"];
        if ($error == "emptyinput") {
            q_error_popup("Please fill in all fields");
        }
        elseif ($error == "invalidemail") {
            q_error_popup("Please use a valid email");
        }
        elseif ($error == "invaliduname") {
            q_error_popup("Please choose a username that follows the correct rules");
            q_info_popup("A good username can only have letters and numbers in it");
        }
        elseif ($error == "nonmatchingpasswd") {
            q_error_popup("Please make sure that both passwords match");
        }
        elseif ($error == "insecurepasswd") {
            q_error_popup("Please choose a password that follows the correct rules ");
            q_info_popup("A good password has at least 1 number, 1 special character, 1 capital letter and is at least 7 characters long; Try not to have your name in it");
        }
        elseif ($error == "invalidqegsform") {
            q_error_popup("That isn't a valid form, please use the selection box to help");
        }
        elseif ($error == "unameemailexists") {
            q_error_popup("Either the email or username you entered are already taken");
        }
        elseif ($error == "thereisnobackdoor") {
            q_warn_popup("To process sign up submission, request must come from pressing sign up");
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