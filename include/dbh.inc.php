<?php

$GLOBALS["connection"] = null;

function startConnection($serverName="localhost", $dbUsername="php.root", $dbPassword="", $dbName="") {

    $GLOBALS["connection"] = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);
    if (!$GLOBALS["connection"]) {
        die("SQL Connection failed: " . mysqli_connect_error());
    }

}