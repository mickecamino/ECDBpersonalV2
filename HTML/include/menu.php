<?php
// File: include/menu.php
// Function: Display the menu tabs
// Revision date: 2026-09-10
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//

echo '<div id="menu"><ul><li><a href="." class="';
    if ($_SERVER["REQUEST_URI"] == '/' or
        $_SERVER["REQUEST_URI"] == '/index.php'or isset($_GET['view']) or
        isset($_GET['cat'])or isset($_GET['subcat']) or isset($_GET['edit']) or
        isset($_GET['based'])){echo 'selected';}

    echo '"><span class="fa fa-archive fa-lg"></span> ' . _("My components") .'</a></li>';

    echo '<li><a href="add.php" class="';
    if ($_SERVER["REQUEST_URI"] == '/add.php'){echo 'selected';}
    echo '"><span class="fa fa-plus-square fa-lg"></span> ' . _("Add component") . '</a></li>';
    
    echo '<li><a href="shoplist.php" class="<';
    if ($_SERVER["REQUEST_URI"] == '/shoplist.php'){echo 'selected';}
    echo '"><span class="fa fa-shopping-basket fa-lg"></span> ' . _("Shopping list") . '</a></li>';

    echo '<li><a href="proj_list.php" class="';
    if ($_SERVER["REQUEST_URI"] == '/proj_list.php' or isset($_GET['proj_id'])){echo 'selected';}
    echo '"><span class="fa fa-rocket fa-lg"></span> ' . _("Projects") . '</a></li>';

    echo '<li><a href="my.php" class="';
    if ($_SERVER["REQUEST_URI"] == '/my.php'){echo 'selected';}
    echo '"><span class="fa fa-user fa-lg"></span> ' . _("My settings") . '</a></li>';
 
    echo '<li><a href="maintenance.php" class="';
    if ($_SERVER["REQUEST_URI"] == '/maintenance.php'){echo 'selected';}
    echo '"><span class="fa fa-cog fa-lg"></span> ' . _("Reference items") . '</a></li>';

    echo '<li><a href="importexport.php" class="';
    if ($_SERVER["REQUEST_URI"] == '/importexport.php'){echo 'selected';}
    echo '"><span class="fa fa-cog fa-lg"></span> ' . _("Import/Export");

    echo '</a></li></ul></div>';
