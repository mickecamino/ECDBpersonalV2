<?php
// File: include/include_proj_add.php
// Function: Add project
// Revision date: 2026-09-16
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
class ProjAdd {
    public function AddProj () {

    require_once "include/login/auth.php";
    include "include/mysql_connect.php";

    if(isset($_POST['submit'])) {
        $owner = $_SESSION['SESS_MEMBER_ID'];
        $name  = mysqli_real_escape_string($connection,$_POST['name']);

        if ($name == '') {
            echo '<div class="message red">';
            echo _("You have to specify a name!");
            echo '</div>';
            }
            else {
                $sql="INSERT into projects (project_owner, project_name) VALUES ('$owner', '$name')";
                $sql_exec = mysqli_query($connection,$sql);
                $proj_id = mysqli_insert_id($connection);

                echo '<div class="message green center">';
                echo _("Project added!");
                echo "</div>";
            } // end else
        } // end if isset
    } // end public function
}
?>
