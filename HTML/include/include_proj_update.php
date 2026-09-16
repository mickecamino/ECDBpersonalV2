<?php
// File: include/include_proj_update.php
// Function: Renames a project
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
            $owner          =   $_SESSION['SESS_MEMBER_ID'];
            $name           =   mysqli_real_escape_string($connection,$_POST['name']);
            $id             =   (int)$_GET['proj_id'];

            if ($name == '') {
                echo _("You have to specify a name!");
            }
            else {
                $sql = "UPDATE projects SET project_name = '".$name."' WHERE project_id = ".$id." ";
                $sql_exec = mysqli_query($connection,$sql);
                // Go bak to project list
                header("location: /proj_list.php");
            }
        }
    }
}
?>