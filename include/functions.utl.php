<?php

require_once(__DIR__."/header.inc.php");

function makeForumPost($title, $author, $username, $created, $content) {

    $string = '<article>';
    $string .= '<h1>' . $title . '</h1>';
    $string .= '<articlemeta-ul>'
        . '<a> author: </a>'
        . '<a class="am-author" href="include/functions/profile.php?profile='.$username.'">'.$author.'</a>'
        . '<a> creation: </a>'
        . '<a class="am-created-at" href="">'.$created.'</a>'
        . '<div>'.$content.'</div>';
    $string .= '</article>';

    return $string;
}

function curlGetReq($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    $result = curl_exec($curl);
    curl_close($curl);

    return $result;
}

function getRemarkAPI($string) {

    // cURL is much faster than `get_file_contents` so it's used to call remark API
    // This is not the file for remark API but I might make it more accessible so need to add API tokens

    $apitoken = '0xS=&aDm$jx9f`e&Yht?yJ07}g1HTJ3oxo';
    $apitoken = urlencode($apitoken);
    $string = urlencode($string);
    $result = curlGetReq('http://py.libnexus.tech/api/remark?key='.$apitoken.'&string='.$string);

    return $result;
}

// Popup

function remarkString($string): string
{
    $string = str_replace("**", "•", $string);
    $string = str_replace("->", "→", $string);
    $string = str_replace("<-", "←", $string);

    return $string;
}

function rootPath($file) {
    return substr(str_replace('\\', '/', realpath(dirname($file))), strlen(str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']))));
}

function is_rgb($rgb) {

    return count($rgb) == 3 && is_numeric(implode($rgb)) && max($rgb) <= 255;

}

function emptyInputSignup($name, $email, $uname, $passwd, $passwdconfirm, $qegsform) {

    if (empty($name) || empty($email) || empty($uname) || empty($passwd) || empty($passwdconfirm) || empty($qegsform)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUname($uname) {

    if (!preg_match("/^[a-zA-Z0-9_]*$/", $uname)) {
        $result = true;
    }
    elseif (strlen($uname) < 4) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function matchPasswd($p1, $p2) {

    if ($p1 !== $p2) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function insecurePasswd($passwd) {

    if (!(strlen($passwd) > 7 and preg_match("/[A-Z]/", $passwd) and preg_match("/[0-9]/", $passwd) and preg_match("/[!£$%^&*()_+\-={}[\]@~'#:;<>?,.\/|]/", $passwd))) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidForm($form) {
    if (!preg_match("/^([789]|10|11)([QEGSF])|(12|13|14)([ABCDEF])*$/", $form)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function unameExists($uname, $email) {

    global $connection;

    $sql = "select * from tbl_Users where userUsername=? or userEmail=?;";
    // Creating prepared statement to prevent SQL injection
    $statement = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($statement, $sql)) {
        // Handle error
        header("location: ../signup.php?error=randomsqlstmterror");
        exit();
    }
    // Two strings -> ss
    mysqli_stmt_bind_param($statement, "ss", $uname, $email);
    mysqli_stmt_execute($statement);

    $resultData = mysqli_stmt_get_result($statement);

    //Associative array {dict}
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        return false;
    }
}

// Create and establish SQLI statement

function createSQLIStatement ($sql, $paramsequence, ...$args) {

    global $connection;

    $statement = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($statement, $sql)) {

        return false;
    }

    mysqli_stmt_bind_param($statement, $paramsequence, ...$args);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    return true;

}

function createUser ($name, $email, $uname, $passwd, $qegsform) {

    require_once(__DIR__."header.inc.php");

    // TODO: Create own hashing algorithm
    $hashedPasswd = password_hash($passwd, PASSWORD_DEFAULT);

    $createUserResult = createSQLIStatement("insert into tbl_Users (userName, userEmail, userUsername, userPassword, userForm) values (?, ?, ?, ?, ?);", "sssss", $name, $email, $uname, $hashedPasswd, $qegsform);
    if ($createUserResult === false) { header("location: ../signup.php?error=randomsqlstmterror"); exit(); }

    $user = unameExists($uname, $email);
    if ($user === false) { header("location: ../signup.php?errror=unameexistsnoterror"); exit(); }

    if (!isset($user["userID"])) { header("location: ../signup.php?error=usernotsetyet"); exit(); }
    $userID = $user["userID"];

    // Bind user to permissions
    createSQLIStatement("insert into tbl_PermissionSubscriptions (subscriptionOwnerUserID) values (?);", "i", $userID);
    // Get subscription ID
    $permissionSubscriptionID = mysqli_insert_id($connection);

    // Bind user to roles
    createSQLIStatement("insert into tbl_RoleSubscriptions (subscriptionOwnerUserID) values (?);", "i", $userID);
    // Get subscription ID
    $roleSubscriptionID = mysqli_insert_id($connection);

    // Bind user to preferences
    createSQLIStatement("insert into tbl_PreferenceSubscriptions (subscriptionOwnerUserID) values (?);", "i", $userID);
    // Get subscription ID
    $preferenceSubscriptionID = mysqli_insert_id($connection);

    // Bind user to subscription
    createSQLIStatement("insert into tbl_UserSubscriptions (subscriptionOwnerUserID, subscriptionPermissionSubscriptionID, subscriptionRoleSubscriptionID, subscriptionPreferenceSubscriptionID) values (?,?,?,?);", "iiii", $userID, $permissionSubscriptionID, $roleSubscriptionID, $preferenceSubscriptionID);
    // Get subscription ID
    $createdSubscriptionID = mysqli_insert_id($connection);

    // Bind subscription to user
    createSQLIStatement("update tbl_users set userSubscriptionID=? where userID=?", "ii", $userID, $createdSubscriptionID);

    loginUser($uname, $passwd);

    exit();
}

// Login

function emptyInputLogin($uname, $passwd) {

    if (empty($uname) || empty($passwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($login, $passwd) {

    require_once(__DIR__."header.inc.php");

    $unameExists = unameExists($login, $login);
    $user = $unameExists;

    if ($unameExists === false) {
        header("location: ../login.php?error=unamenotexists");
        exit();
    }

    $passwdHashed = $user["userPassword"];
    $checkPasswd = password_verify($passwd, $passwdHashed);

    if ($checkPasswd === false) {
        // Need to make password cooldown & reset
        header("location: ../login.php?error=wrongpasswd");
        exit();
    }
    elseif ($checkPasswd === True) {
        // Session
        session_start();
        $_SESSION["_sessionUser"] = $user;
        $_SESSION["userID"] = $user["userID"];
        $_SESSION["userUsername"] = $user["userUsername"];
        $_SESSION["userName"] = $user["userName"];
        header("location: ../index.php");
        exit();
    }
}

function adminCheck($checkUserID) {

    global $connection;

    $sql = "select * from tbl_Admins where adminUserID=?;";
    $statement = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("location: ".rootPath(__FILE__)."/../signup.php?error=randomsqlstmterror");
        exit();
    }

    mysqli_stmt_bind_param($statement, "i" , $checkUserID);
    mysqli_stmt_execute($statement);

    $resultData = mysqli_stmt_get_result($statement);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        return false;
    }

}
