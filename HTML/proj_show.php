<?php
// File: proj_show.php
// Function: Show projects
// Revision date: 2026-09-16
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "include/login/auth.php";
    require_once "include/debug.php";

    if (!isset($_GET["proj_id"])) {
        header("Location: error.php?id=3");
    }
 // Custom Page Titles
    $pageTitle = _("Show project");
    include("include/head.php");

    echo '<body><div id="wrapper">';
// Header
    include "include/header.php";
// END
// Main menu
    include "include/menu.php";
// END
// Main content
    echo '<div id="content"><h1>' . _("Viewing project") . ' ';
// Show project name
    include "include/mysql_connect.php";
    $project_id = mysqli_real_escape_string($connection,$_GET["proj_id"]);
    $owner = $_SESSION['SESS_MEMBER_ID'];
    $result = mysqli_query($connection,"SELECT project_name FROM projects WHERE project_owner = ".$owner." AND project_id = ".$project_id."");
    while($row = mysqli_fetch_array($result))
        {
        echo "<strong>";
        echo $row['project_name'];
        echo "</strong>";
        }
    echo "</h1>";
// start table, thead and first row
    echo '<table class="globalTables" cellpadding="0" cellspacing="0"><thead><tr>';
// start and end column one, start second column
    echo '<th></th><th>';
    echo '<a href="?proj_id=' . $project_id . '&by=name&order=';
    if(isset($_GET['order'])){
        $order = $_GET['order'];
        if ($order == 'asc'){
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
// end second column, start third column
    echo '</th><th>';
    echo '<a href="?proj_id=' . $project_id . '&by=category&order=';
    if(isset($_GET['order'])){
        $order = $_GET['order'];
        if ($order == 'asc'){
            echo 'desc';
        }
        else {
            echo 'asc';
        }
    }
    else {
        echo 'asc';
    }
    echo '">' . _("Category") . '</a>';
// end third column, start fourth column
    echo '</th><th>';
    echo '<a href="?proj_id=' . $project_id . '&by=manufacturer&order=';
    if(isset($_GET['order'])){
        $order = $_GET['order'];
        if ($order == 'asc'){
            echo 'desc';
        }
        else {
            echo 'asc';
        }
    }
    else {
        echo 'asc';
    }
    echo '">' . _("Manufacturer") . '</a>';
// end fourth column, start fifth column
    echo '</th><th>';
    echo '<a href="?proj_id=' . $project_id . '&by=package&order=';
    if(isset($_GET['order'])){
        $order = $_GET['order'];
        if ($order == 'asc'){
            echo 'desc';
        }
        else {
            echo 'asc';
        }
    }
    else {
        echo 'asc';
        }
    echo '">' . _("Package") . '</a>';
// end gifth column, start sixth column
    echo '</th><th>';
    echo '<a href="?proj_id=' . $project_id . '&by=location&order=';
    if(isset($_GET['order'])){
        if ($order == 'asc'){
            echo 'desc';
        }
        else {
            echo 'asc';
        }
    }
    else {
        echo 'asc';
    }
    echo '">' . _("Location") . '</a>';
// end sixth column, start seventh column
    echo '</th><th>';
    echo '<a href="?proj_id=' . $project_id . '&by=price&order=';
    if(isset($_GET['order'])){
        $order = $_GET['order'];
        if ($order == 'asc'){
            echo 'desc';
        }
        else {
            echo 'asc';
        }
    }
    else {
        echo 'asc';
    }
    echo '">' . _("Price") . '</a>';
// end seventh column, start eight column
    echo '</th><th>';
    echo '<a href="?proj_id=' . $project_id . '&by=quantity&order=';
    if(isset($_GET['order'])){
        $order = $_GET['order'];
        if ($order == 'asc'){
            echo 'desc';
        }
        else {
            echo 'asc';
        }
    }
    else {
        echo 'asc';
    }
    echo '">' . _("Quantity in stock") . '</a>';
// end eight column, start ninth column
    echo '</th><th>';
    echo '<a href="?proj_id=' . $project_id . '&by=quantity&order=';
    if(isset($_GET['order'])){
        $order = $_GET['order'];
        if ($order == 'asc'){
            echo 'desc';
        }
        else {
            echo 'asc';
        }
    }
    else {
        echo 'asc';
    }
    echo '">' . _("Quantity in project") . '</a>';
// end ninth column, end first row, end thead, start tbody
    echo '</th></tr></thead><tbody>';
    include "include/include_proj_show.php";

    $ProjectShowComponents = new ProjectShow;
    $ProjectShowComponents->ProjectShowComponents();
// end tbody, end table
    echo '</tbody></table><div class="totalSumWrapper">';
    include "include/include_proj_show_price.php";

    $ProjectSumTotal = new ProjectShowPrice;
    $ProjectSumTotal->ProjectSumTotal();
    echo '</div></div>';
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo "</div></body></html>";
?>
