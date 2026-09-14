<?php
// File: proj_list.php
// Function: List prejects
// Revision date: 2026-08-31
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "include/login/auth.php";
    require_once "include/debug.php";
 // Custom Page Titles
     $pageTitle = _("Your Projects");
    include "include/head.php";

    echo '<body><div id="wrapper">';
// Header
    include "include/header.php";
// END
// Main menu
    include "include/menu.php";
// END
// Main content
    echo '<div id="content">';
    include "include/include_proj_add.php";
    $AddProj = new ProjAdd;
    $AddProj->AddProj();
    $proj_query = mysqli_query($connection,"SELECT * FROM projects WHERE project_owner= $owner");
    if(mysqli_num_rows($proj_query) == 0){
        echo '<div class="message orange">' . _("Please create a Project.") . '</div>';
        }

    echo '<form class="globalForms" method="post" action="">';
    echo '<div class="textInput">';
    echo '<label class="keyWord">' . _("Project name") . '</label>';
    echo '<div class="input"><input name="name" id="name" type="text" class="medium" /></div></div>';
    echo '<div class="buttons"><div class="input">';
    echo '<button class="button green" name="submit" type="submit"><span class="fa fa-save fa-lg"></span> ' . _(" Add project") . '</button>';
    echo '</div></div></form><hr>';
    echo '<table class="globalTables" cellpadding="0" cellspacing="0"><thead><tr><th></th>';
    echo '<th><a href="?by=name&order=';
    if(isset($_GET['order'])) {
        $order = $_GET['order'];
        if ($order == 'asc') {
            echo 'desc';
            }
        else {
            echo 'asc';
        }
    }
    else {
        echo 'desc';
        }
    echo '">' . _("Name") . '</a>';
    echo '</th><th>' . _("Number of components") . '</th>';
    echo '<th>' . _("Total cost") . '</th>';
    echo '</tr></thead><tbody>';

    include "include/include_proj_list_projets.php";
    $ProjList = new Proj;
    $ProjList->ProjList();
    echo "</tbody></table></div>";
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo "</div></body></html>";
 ?>
