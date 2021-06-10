<?php
/*
 *  The header should be included in every php file since it ensures that we have a connection global we can use
 *      - "header.inc.php" -requires-> "main.init.php" -requires-> "dbh.inc.php"
 *      - This makes sure that we have a session and a connection, none of them require the other so no recursion
 */

// Require main
require_once(__DIR__."/main.init.php");
// Require functions
require_once(__DIR__."/functions.utl.php");

// If there is no session, make one
if (!isset($_SESSION)) {
    session_start();
}

$GLOBALS["connection"] = $connection;