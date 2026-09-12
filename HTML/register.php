<?php
// File: register.php
// Function: Register a new user
// Revision date: 2026-09-12
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    session_start();
    require_once "include/debug.php";
    // Custom Page Titles
    $pageTitle = _("Register");
    include "include/head.php";
// Call the language translator
    require_once "include/localize.php";
    if(isset($_COOKIE["language"])) { // for localization
    $language = $_COOKIE["language"];
    }
    else { // Not set, set to en_US.utf8
        $language = "en_US.utf8";
    }
    SetLanguage($language);
// END
    echo '<body><div id="wrapper">';
// Header -->
    echo '<div><img src="img/logov2.png" alt="ECDB personal V2" style="width:175px;height:75px;"></div>';
// END
// Main menu
    echo '<div id="menu"><ul>';
    echo '<li><a href="."><span class="fa fa-key fa-lg"></span> ' . _("Login") . '</a></li>';
    echo '<li><a href="register.php"><span class="fa fa-user fa-lg"></span> ' . _("Register") . '</a></li>';
    echo '</ul></div>';
// END
// Main content
    echo '<div id="content">';
    if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
        echo '<div class="message red">';
        echo '<ul class="error">';
            foreach($_SESSION['ERRMSG_ARR'] as $msg) {
                echo '<li>',$msg,'</li>'; 
            }
        echo '</ul>';
        echo '</div>';
        unset($_SESSION['ERRMSG_ARR']);
    }
    echo '<div class="loginWrapper"><div class="left">';
    echo _("Fill in this form to create your a user for the database.") . '<br>';
    echo '<form class="globalForms" name="loginForm" method="post" action="register-exec.php"><div class="textInput">';
    echo '<label class="keyWord">' . _("First name") . '</label><div class="input"><input name="fname" type="text" class="medium" id="fname" /></div></div>';
    echo '<div class="textInput"><label class="keyWord">' . _("Last name") . '</label><div class="input"><input name="lname" type="text" class="medium" id="lname" /></div></div>';
    echo '<div class="textInput"><label class="keyWord">' . _("Username") . '</label><div class="input"><input name="login" type="text" class="medium" id="login" /></div></div>';
    echo '<div class="textInput"><label class="keyWord">' . _("Password") . '</label><div class="input"><input name="password" type="password" class="medium" id="password" /></div></div>';
    echo '<div class="textInput"><label class="keyWord">' . _("Repeat password") . '</label><div class="input"><input name="cpassword" type="password" class="medium" id="cpassword" onpaste="return false;" /></div></div>';
    echo '<div class="buttons"><div class="input"><button class="button green" name="Submit" type="submit">' . _("Register") . '</button></div></div></form></div>';
    echo '<div class="right"></div></div></div>';
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo "</div></body></html>";
?>
