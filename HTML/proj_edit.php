<?php
// File: proj_edit.php
// Function: Edit projecs
// Revision date: 2026-09-16
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "include/login/auth.php";
    include "include/mysql_connect.php";
    require_once "include/debug.php";

    $owner  =   $_SESSION['SESS_MEMBER_ID'];
    $id     =   (int)$_GET['proj_id'];

    $GetDataProjectName = mysqli_query($connection,"SELECT * FROM projects WHERE project_id = ".$id." AND project_owner = ".$owner."");
    $executesql = mysqli_fetch_assoc($GetDataProjectName);

    if(isset($_POST['delete'])) {
        $sqlDeleteProject = "DELETE FROM projects WHERE project_id = ".$id." ";
        $sql_exec_component_delete = mysqli_query($connection,$sqlDeleteProject);

        $sqlDeleteProject = "DELETE FROM projects_data WHERE projects_data_project_id = ".$id." ";
        $sql_exec_project_delete = mysqli_query($connection,$sqlDeleteProject);

        header("Location:  proj_list.php");
    }
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
    echo '<div id="content"><h1>' . _("Edit Project") . '</h1>';
    include "include/include_proj_update.php";
    $AddProj = new ProjAdd;
    $AddProj->AddProj();

    echo '<form class="globalForms" method="post" action=""><div class="textInput">';
    echo '<label class="keyWord">' . _("Project name") . '</label>';
    echo '<div class="input"><input name="name" type="text" class="medium" value="' . $executesql['project_name'] . '" /></div>';
    echo '</div><div class="buttons"><div class="input">';
    echo '<button class="button green" name="submit" type="submit"><span class=" far fa-save fa-lg"></span> ' . _("Save") . '</button> ';
    echo '<button class="button red" name="delete" type="submit"><span class="far fa-trash-alt fa-lg"></span> ' . _("Delete") . ' </button>';
    echo '</div></div></form></div>';
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo '</div></body></html>';
?>
