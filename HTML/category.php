<?php
// File: category.php
// Function: Show and sort categories
// Revision date: 2026-09-21
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "include/login/auth.php";
    require_once "include/debug.php";
    // Custom Page Titles
    $pageTitle = _("Categories");
    // Hidden Search title for search dialogue
    // pageTitle did not work when localized, see header.php
    $searchTitle = "Categories";

    include "include/head.php";

    echo '<body><div id="wrapper">';
    // Header
    include "include/header.php";
    // END
    // Main menu
    include "include/menu.php";
    // END
    // Main content
    echo '<div id="content"><div class="subMenu"><ul>';
    include "include/include_category_head.php";
    $Head = new NameHead;
    $Head->Head();
    echo '</ul></div><div class="subSubMenu"><ul>';

    include "include/include_category_sub.php";
    $Sub = new NameSub;
    $Sub->Sub();
// start table
    echo '</ul></div><table class="globalTables" cellpadding="0" cellspacing="0">';
// start head, start first row, start and end first column, start second column
    echo "<thead><tr><th></th><th>";

    echo '<a href="?';
    if(isset($_GET['subcat'])) { echo 'subcat'; } else { echo 'cat'; } echo "=";
    if(isset($_GET['cat'])) { echo $_GET['cat']; } 
    if(isset($_GET['subcat'])) { echo $_GET['subcat'];}
    echo "&by=name&order=";
    if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') { echo 'desc'; } else { echo 'asc'; }} else { echo 'desc'; }
    echo '">' . _("Name") . "</a></th>";
// end second column, start third column
    echo '<th><a href="?';
    if(isset($_GET['subcat'])) { echo 'subcat'; } else { echo 'cat'; } echo "=";
    if(isset($_GET['cat'])) { echo $_GET['cat'];}
    if(isset($_GET['subcat'])) { echo $_GET['subcat'];} echo "&by=category&order="; 
    if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') { echo 'desc';} else { echo 'asc';}} else { echo 'desc'; }
    echo '">' . _("Category") . "</a></th>";
// end third column, start fourth column
    echo '<th><a href="?';
    if(isset($_GET['subcat'])) { echo 'subcat';} else { echo 'cat';} echo "=";
    if(isset($_GET['cat'])){ echo $_GET['cat'];} 
    if(isset($_GET['subcat'])){ echo $_GET['subcat'];} echo "&by=package&order=";
    if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') { echo 'desc'; } else { echo 'asc'; } } else { echo 'desc'; };
    echo '">' . _("Package") . "</a></th>";
// end fourth column, start fifth column
    echo '<th><a href="?';
    if(isset($_GET['subcat'])) { echo 'subcat';} else { echo 'cat';} echo "=";
    if(isset($_GET['cat'])){ echo $_GET['cat'];} 
    if(isset($_GET['subcat'])){ echo $_GET['subcat'];} echo "&by=pins&order=";
    if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') { echo 'desc'; } else { echo 'asc'; } } else { echo 'desc'; }
    echo '">' . _("Pins") . "</a></th>";
// end fifth column, start and end sixth and seventh column
    echo "<th>" . _("Image") . "</th>";
    echo "<th>" . _("Datasheet") . "</th>";
// start eight column
    echo '<th><a href="?';
    if(isset($_GET['subcat'])) { echo 'subcat';} else { echo 'cat';} echo "=";
    if(isset($_GET['cat'])){ echo $_GET['cat'];}
    if(isset($_GET['subcat'])){ echo $_GET['subcat'];} echo "&by=location&order=";
    if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') {   echo 'desc'; } else { echo 'asc'; } } else { echo 'desc'; } 
    echo '">' . _("Location") . "</a></th>";
// end eight column, start ninth column
    echo '<th><a href="?';
    if(isset($_GET['subcat'])) { echo 'subcat';} else { echo 'cat';} echo "=";
    if(isset($_GET['cat'])){ echo $_GET['cat'];} 
    if(isset($_GET['subcat'])){ echo $_GET['subcat'];} echo "&by=quantity&order=";
    if(isset($_GET['order'])) { $order = $_GET['order']; if ($order == 'asc') { echo 'desc'; } else { echo 'asc'; } } else { echo 'desc'; }
    echo '">' . _("Quantity") . "</a></th>";
// end ninth column, start and end tenth column, end row one
    echo "<th>" . _("Comment") . "</th></tr>";
// end thead, start tbody
    echo "</thead><tbody>";

    include "include/include.php";
    $Category = new ShowComponents;
    $Category->Category();

    echo "</tbody></table></div>";
// end tbody and table
// Text outside the main content
    include "include/footer.php";
    // END
    echo "</div></body></html>";
?>