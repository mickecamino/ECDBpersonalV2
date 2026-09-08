<?php
// File: looout.php
// Function: Log out from ecDBpersonal
// Revision date: 2026-08-31
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    //Start session
    session_start();
    //Unset the variables stored in session
    unset($_SESSION['SESS_MEMBER_ID']);
    unset($_SESSION['SESS_FIRST_NAME']);
    unset($_SESSION['SESS_LAST_NAME']);
    require_once "include/debug.php";
 // Custom Page Titles
 $pageTitle = _("Logout");
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
// Header
    echo '<div><img src="img/logov2.png" alt="ECDB personalV2" style="width:175px;height:75px;"></div>';
// END
// Main menu
    echo '<div id="menu"><ul>';
    echo '<li><a href="."><span class="fa fa-key fa-lg"></span> ' . _("Login") . '</a></li>';
    echo '<li><a href="register.php"><span class="fa fa-user fa-lg"></span> ' . _("Register") . '</a></li>';
    echo '<li><a href="about.php"><span class="fa fa-info-circle fa-lg"></span> ' . _("About") . '</a></li>';
    echo '</ul></div>';
// END
// Main content
    echo '<div id="content"><div class="message green center">' . _("You have successfully signed out of your account.") . '</div>';
    echo '<div class="loginWrapper"><div class="left">';
    echo '<form class="globalForms" name="loginForm" method="post" action="login-exec.php">';
    echo '<div class="textInput"><label class="keyWord">' . _("Username") . '</label>';
    echo '<div class="input"><input name="login" class="medium" type="text" id="login"/></div></div>';
    echo '<div class="textInput"><label class="keyWord">' . _("Password") . '</label>';
    echo '<div class="input"><input name="password" class="medium" type="password" id="password"/></div></div>';
    echo '<div class="buttons"><div class="input">';
    echo '<button class="button green" name="Submit" type="submit"><span class="fa fa-key fa-lg"></span> ' . _("Login") . '</button></div></div></form></div>';
    echo '<div class="right"></div></div></div>';
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo "</div></body></html>"
?>