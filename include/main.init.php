<?php

//Make sure that the database is included
require_once(__DIR__."/dbh.inc.php");

// Create connection
startConnection("localhost", "root", "", "qlee.dbh.01");

$GLOBALS["connection"] = $connection;