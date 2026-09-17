<?php
// File: error.php
// Function: Show errors based on $id
// Revision date: 2026-09-16
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "include/login/auth.php";
    require_once "include/debug.php";

    // Custom Page Titles
    $pageTitle = _("Error");
    include "include/head.php";
    echo '<body><div id="wrapper">';
// Header
    include "include/header.php";
// END
// Main menu
    include "include/menu.php";
// END

    if(isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        if ($id == 1) {
            $message = _("You don't have permission to view this component.");
        }
        elseif ($id == 2) {
            $message = _("You don't have permission to edit this component.");
        }
        elseif ($id == 3) {
            $message = _("Oh crap! Something broke...");
        }
        else {
            $message = "";
        }
    }
    if (empty($_GET['id'])) {
        $message = 'Error!';
    }

// Main content
    echo '<div id="content"><div class="message red">' . $message . '</div></div>';
// END
// Text outside the main content
    include "include/footer.php";
    echo "</div></body></html>";
?>
