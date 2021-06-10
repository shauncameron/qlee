<?php

require_once("../include/header.inc.php");

if (!isset($_SESSION["userID"]) or adminCheck($_SESSION["userID"]) === false) {
    header("location: ../home.php?error=unauthaccessnotadmin");
    exit();
}