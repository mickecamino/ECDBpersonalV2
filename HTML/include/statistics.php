<?php
// File: inlcude/statistics.php
// Function: Show component and project count
// Revision date: 2026-09-11
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "login/auth.php";
    include "mysql_connect.php";
    $owner = $_SESSION['SESS_MEMBER_ID'];
// Get the number of components from the data table
    $DataCount = mysqli_num_rows(mysqli_query($connection,"SELECT `id` FROM `data` WHERE `owner` = " . $owner . ""));
    echo '<h1>' . _("You have") . " " . $DataCount;
    if($DataCount == 1 ) {
        echo " " .  _("component and");
    } else {
        echo " " .  _("components and");
    }
    echo " ";
// Get the number of project from the projects table
    $ProjectCount = mysqli_num_rows(mysqli_query($connection,"SELECT `project_id` FROM `projects` WHERE `project_owner` = ". $owner . ""));
    echo $ProjectCount;
    if($ProjectCount == 1 ) {
        echo " " .  _("project");
    } else {
        echo " " .  _("projects");
    }
    echo " ";
    echo _("in the database") . '</h1>';
// Get all categories in the category head table
    if($DataCount > 0) { // There are 0 components in the database, no need to display the category count
        $Categories = mysqli_fetch_all(mysqli_Query($connection,"SELECT `id`, `name` FROM `category_head` ORDER BY `name`"), MYSQLI_ASSOC);
        echo '<h1>' . _("You have the following component count in each category") . '</h1>';
// Build a table
        echo '<table class="globalTables leftAlign" cellpadding="0" cellspacing="0">';
        echo '<thead><tr>';
        echo '<th>' . _("Category") . '</th><th>' . _("Component count") . '</th>';
        echo '</tr></thead><tbody>';
// Loop through all categories
        foreach ($Categories as $Category) {
            $cat = (int)$Category["id"]; // get the id number
            $subcatfrom = $cat*100;      // multiply with 100 to get the sub category
            $subcatto = $subcatfrom+99;  // and add 99 to get the last sub category
// Get the component count from each head category
            $ComponentCount = mysqli_num_rows(mysqli_query($connection,"SELECT `id` FROM `data` WHERE `category` BETWEEN " . $subcatfrom . " AND " . $subcatto . " AND owner = " . $owner . ""));
            echo sprintf("<tr><td>%s</td><td>%s</td></tr>", gettext($Category["name"]), $ComponentCount);
        }
        echo '</tbody></table>'; // end the table
    }
?>
