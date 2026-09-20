<?php
// File: include_component_edit_project_add.php
// Function: Used in Edit component to add the component to a project
// Revision date: 2026-09-20
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
class AddMenuProj {
    public function MenuProj() {

        require_once "include/login/auth.php";
        include "include/mysql_connect.php";

        $owner  =   $_SESSION['SESS_MEMBER_ID'];
        $id     =   (int)$_GET['edit'];

        echo '<option class="main_category" value="">';
        echo _(" - Project - ");
        echo "</option>";

        $GetDataProject = "SELECT * FROM projects WHERE project_owner = '$owner' ORDER by project_name ASC";
        $sql = mysqli_query($connection,$GetDataProject);

        while($row1 = mysqli_fetch_array($sql)){

            $query1 = "SELECT projects_data.projects_data_project_id, projects_data.projects_data_component_id FROM projects_data RIGHT JOIN projects ON projects.project_id = projects_data.projects_data_project_id WHERE projects.project_owner = '$owner'";

            $result1 = mysqli_query($connection,$query1);

            echo '<option value="';
            echo $row1['project_id'];
            echo '"';

            while($row2 = mysqli_fetch_array($result1)){
                if ($row2['projects_data_component_id'] == $id && $row2['projects_data_project_id'] == $row1['project_id']){
                    echo 'disabled="disabled"';
                }
                else {
                    echo '';
                }
            }

            if(isset($_POST['submit'])) {
                if(isset($_POST['project'])) {
                    if($row1['project_id'] == $_POST['project']) {
                        echo ' selected ';
                    }
                }
            }
            echo '>';
            echo $row1['project_name'];
            echo '</option>';
        }
    }
}   
?>
