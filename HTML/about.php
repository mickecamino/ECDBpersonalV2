<?php
// File: about.php
// Function: Show info about ecBDpersonal
// Revision date: 2026-08-31
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
    echo '<div><img src="img/logov2.png" alt="ECDB personalV2" style="width:175px;height:75px;"></div>';
// END
// Main menu
    echo '<div id="menu"><ul>';
    echo '<li><a href="."><span class="fa fa-key fa-lg"></span>' . _("Login") . '</a></li>';
    echo '<li><a href="register.php"><span class="fa fa-user fa-lg"></span> ' . _("Register") . '</a></li>';
    echo '<li><a href="about.php"><span class="fa fa-info-circle fa-lg"></span> ' . _("About") . '</a></li></ul></div>';
// END
// Main content
    echo '<div id="content"><div class="loginWrapper"><div class="left">';
    echo "<h1>" . _("What is ecDBpersonal?") . "</h1>";
    echo _("ecDB (Personal) is a program where you, as an electronics hobbyist can add your own components to your personal database to keep track of what components you own, where they are, how many you own.");
    echo "<br>";
    echo _("ecDB was created by ") . '<a target="_blank" href="http://nilsf.se">Nils Fredriksson</a>. <br /><br';
    echo _("This is ecDB Personal by Pete Willard, modified by Mikael Karlsson.") .  '<br>';
    echo _("You can find the original version of ecDB ") . '<a target="_blank" href="https://github.com/jwr/ecDB">' . _("on Github") . '</a><br>';
    echo _("The personal edition is also ") . '<a target="_blank" href="https://github.com/pwillard/ECDBpersonal">' . _("on Github") . '</a><br>';
    echo _("The modified version by Mikael Karlsson can also be found ") . '<a target="_blank" href="https://github.com/mickecamino/ECDBpersonal">' . _("on Github") . '</a><br><br>';
    echo _("ecDB is completely free! and is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.") . '<br><br>';
    echo _("The ecDB code is not allowed for public use.") . '<br><br>';
    echo _("You are allowed to set up a private ecDB database for yourself, or whithin an organisation.") . '<br><br>';
    echo "</div></div></div>";
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo "</div></body></html>";

