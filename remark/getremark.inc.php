<?php

require_once("../include/functions.utl.php");

$toRemark = $_GET["toremark"];

echo getRemarkAPI($toRemark);