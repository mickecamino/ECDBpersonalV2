<?php
// File: header.php
// Function: show the generic shared header
// Revision date: 2026-09-01
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
//  Localize
    require_once "include/localize.php";
    if(isset($_COOKIE["language"])) { // for localization
    $language = $_COOKIE["language"];
    }
    else { // Not set, set to en_US.utf8
        $language = "en_US.utf8";
    }
    SetLanguage($language);
// END
    echo '<div id="header">';
// Draw Logo
    echo '<div><a href="index.php"><img src="img/logov2.png" alt="ECDB personalV2" style="width:200px;height:75px;"></a></div>';
    // Current User logged in/ log out
    echo '<span class="userInfo">' . _("Logged in as") . ' <a href="my.php">';
    require_once "include/login/auth.php";
    include "include/mysql_connect.php";

    $owner = $_SESSION['SESS_MEMBER_ID'];
    $GetName = mysqli_query($connection,"SELECT firstname, lastname FROM members WHERE member_id = ".$owner."");
    $headername = mysqli_fetch_assoc($GetName);
// Get Current User Name
    if(isset($_POST['submit']) && $_SERVER["REQUEST_URI"] == 'my.php') { echo $_POST['firstname']; } else { echo $headername['firstname']; }
    echo ' ';
    if(isset($_POST['submit']) && $_SERVER["REQUEST_URI"] == 'my.php') { echo $_POST['lastname']; } else { echo $headername['lastname']; }
    echo '</a> - <a href="logout.php"> ' . _("Sign out") . '</a>';
    echo "</span>";
// Search Function
// We don't need a search form on anything but what is defined below
// They cant be localized, thats why we need a hidden variable $searchTitle to get this to work
    if(isset($searchTitle)) {
        if ($searchTitle == "Home" ||
            $searchTitle == "Categories" ||
            $searchTitle == "View component" ||
            $searchTitle == "Search")
        {
            echo '<div class="searchContent">';
            echo _("Search") . ' <span class="fa fa-search"></span>';
            echo '<form class="search" action="search.php" method="get">';
            echo '  <input type="text" name="q" autofocus/>';
            echo '</form>';
            echo '</div>';
        } // end if searchtitle
    } // end if isset
    else {
        echo '<div class="searchContent">';
        echo gettext($pageTitle);
        echo '</div>';
    }
echo "</div>";
// end of generic shared header
?>
