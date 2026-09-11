<?php
// File: about.php
// Function: Show info about ecBDpersonal
// Revision date: 2026-09-11
// Revised by: Mikael Karlsson
// This file is distributed under the license: 
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
// 
require_once "include/debug.php";
 // Custom Page Titles
 $pageTitle = _("About");
 include "include/head.php";
// Call the language translator
    if(isset($_COOKIE["language"])) { // for localization
    $language = $_COOKIE["language"];
    }
    else { // Not set, set to en_US.utf8
        $language = "en_US.utf8";
    }
    require_once "include/localize.php";
    SetLanguage($language);
// END
    echo '<body><div id="wrapper">';
// Header
    echo '<div><img src="img/logov2.png" alt="ECDB personal V2" style="width:175px;height:75px;"></div>';
// END
// Main menu
    echo '<div id="menu"><ul>';
    echo '<li><a href="."><span class="fa fa-key fa-lg"></span>' . _("Login") . '</a></li>';
    echo '<li><a href="register.php"><span class="fa fa-user fa-lg"></span> ' . _("Register") . '</a></li>';
    echo '<li><a href="about.php"><span class="fa fa-info-circle fa-lg"></span> ' . _("About") . '</a></li></ul></div>';
// END
// Main content
    echo '<div id="content"><div class="loginWrapper"><div class="left">';
    echo "<h1>" . _("What is ecDB personal V2?") . "</h1>";
    echo _("ecDB personal V2 is a program where you, as an electronics hobbyist can add your own components to your personal database to keep track of what components you own, where they are, how many you own.");
    echo "<br><br>";
    echo _("The original ecDB was created by Nils Fredriksson") . ' - ';
    echo _("You can find the original version of ecDB ") . '<a target="_blank" href="https://github.com/jwr/ecDB">' . _("on Github") . '</a><br>';
    echo _("ecDB Personal was created by Pete Willard.") .  ' - ';
    echo _("His version is also ") . '<a target="_blank" href="https://github.com/pwillard/ECDBpersonal">' . _("on Github") . '</a><br><br>';
    echo _("ecDB personal V2 was created by Mikael Karlsson by forking ecDB personal. It is ") . '<a target="_blank" href="https://github.com/mickecamino/ECDBpersonal">' . _("on Github") . '</a><br><br>';
    echo _("ecDB personal V2 is completely free! and is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.") . '<br><br>';
    echo _("The ecDB personal V2 code is not allowed for public use.") . '<br><br>';
    echo _("You are allowed to set up a private ecDB personal V2 database for yourself, or whithin an organisation.") . '<br><br>';
    echo "</div></div></div>";
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo "</div></body></html>";

