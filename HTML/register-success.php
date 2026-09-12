<?php
// File: register-success.php
// Function: After successful registration this file is called
// Revision date: 2026-09-12
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
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
// Header
    echo '<div><img src="img/logov2.png" alt="ECDB personalV2" style="width:175px;height:75px;"></div>';
// END
// Main menu
    echo '<div id="menu"><ul>';
    echo '<li><a href="."><span class="fa fa-key fa-lg"></span> ' . _("Login") . '</a></li>';
    echo '<li><a href="register.php"><span class="fa user fa-lg"></span> ' . _("Register") . '</a></li>';
    echo '<li><a href="about.php" class="selected"><span class="fa fa-document fa-lg"></span> ' . _("About") . '</a></li>';
    echo '</ul></div>';
// END
// Main content
    echo '<div id="content">';
    echo '<h1>' . _("Registration success") . '</h1>';
    echo '<b>' . _("Please login") . '</b><br><br>';

    echo '<form id="loginForm" name="loginForm" method="post" action="login-exec.php">';
    echo '<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">';
    echo '<tr><td width="112">' . _("Login") . '</td>';
    echo '<td width="188"><input name="login" type="text" class="textfield" id="login" /></td>';
    echo '</tr><tr><td>' . _("Password") . '</td>';
    echo '<td><input name="password" type="password" class="textfield" id="password" /></td>';
    echo '</tr><tr><td>&nbsp;</td>';
    echo '<td><input type="submit" name="Submit" value="' . _("Login") . '"></td>';
    echo '</tr></table></form></div>';
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo '</div></body></html>';
?>
