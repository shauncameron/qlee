<?php

require_once("../include/header.inc.php");
// Make sure access is admin
require_once("admin.asrt.php");

// Send to home page
header("location: home.php?redirect=fromindex");
