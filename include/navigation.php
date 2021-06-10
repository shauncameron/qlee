<?php
require_once(__DIR__."/header.inc.php");
require_once(__DIR__."/functions.utl.php");
echo '<link rel="stylesheet" href="'.rootPath(__FILE__).'/../css/navigation.css"/>'
?>
<nav>
    <ul>
        <?php
            require_once(__DIR__."/aesth/popup.php");

            echo '<li><a href="'.rootPath(__FILE__).'/../contact.php"> Contact </a></li>';

            if (isset($_SESSION["userID"])) {
                echo '<li><a href="'.rootPath(__FILE__).'/req/logout.inc.php"> Log Out </a></li>';
                echo '<li><a href="'.rootPath(__FILE__).'/../profile.php"> Profile </a></li>';
                echo '<li><a href="'.rootPath(__FILE__).'/../discover.php"> Discover </a></li>';
            }
            else {
                echo '<li><a href="'.rootPath(__FILE__).'/../login.php"> Log In </a></li>';
                echo '<li><a href="'.rootPath(__FILE__).'/../signup.php"> Sign Up </a></li>';
            }

            echo '<li><a href="'.rootPath(__FILE__).'/../home.php"> Home </a></li>';

            if (isset($_SESSION["userID"]) and $row = adminCheck($_SESSION["userID"])) {
                echo '<li><a href="'.rootPath(__FILE__).'/../admin.php"> Admin Portal </a></li>';
            }
            if(isset($_SESSION["userID"])) {
                echo '<li><a href="'.rootPath(__FILE__).'/../profile.php"> Welcome back ', $_SESSION["userName"], '! </a></li>';
            }
        ?>
        <p class="nav-title"> Qlee </p>
    </ul>
</nav>