<?php
// File: include/include_component_edit_project_edit.php
// Function: Show all projects a component is added to
// Revision date: 2026-09-20
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
class EditProj {
    public function MenuProj() {

        require_once "include/login/auth.php";
        include "include/mysql_connect.php";

        $id = (int)$_GET['edit'];

        // Get all project (if any)
        $query = "SELECT projects_data.projects_data_project_id, projects_data.projects_data_quantity, projects_data.projects_data_component_id, projects.project_id, projects.project_name FROM projects_data, projects WHERE projects_data.projects_data_project_id = projects.project_id AND projects_data.projects_data_component_id = '$id'";
        $result = mysqli_query($connection,$query) or die(mysql_error());
        if (mysqli_num_rows($result) != 0) { // If there are any projects with this component, show them
            while($row = mysqli_fetch_array($result)) {
                // When thsi module is called we are on fourth column and eight row
                echo $row['project_name']; // display the project name
                echo '</td>';  // end fourth column
                echo '<td><input name="projquantedit[';  // start fifth column
                echo $row['project_id'];
                echo ']" type="text" class="small" value="';
                echo $row['projects_data_quantity']; // display the quantity
                echo '" /></td>';  // end fifth column
                echo '<td></td>'; // start and end sixth column
                echo '</tr>';     // end eight row
                echo '<tr>';      // start ninth row
                echo '<td></td>'; // start and end column one
                echo '<td></td>'; // start and end column two
                echo '<td></td>'; // start and end column three
                echo '<td>';      // start column four
            } // end while
        } // This component does not belong to any project
        echo '</td>';      // end column four
        echo '<td></td>';  // start and end column five
        echo '<td></td>';  // start and end column six
        echo '</tr>';      // and end row eight
    } // end project 
} // end class
?>