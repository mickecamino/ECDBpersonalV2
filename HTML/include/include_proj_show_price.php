<?php
// File: include/include_proj_show_price.php
// Function: Show price summary on projects
// Revision date: 2026-09-17
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
class ProjectShowPrice {
    public function ProjectSumTotal() {

        include "mysql_connect.php";

        $project_id = (int)$_GET["proj_id"];
        $owner = $_SESSION['SESS_MEMBER_ID'];

        $GetPersonal = mysqli_query($connection,"SELECT currency FROM members WHERE member_id = ".$owner."");
        $personal = mysqli_fetch_assoc($GetPersonal);

        $GetDataPrice = "SELECT SUM(total) FROM (SELECT projects_data_quantity * price AS total FROM projects_data JOIN `data` WHERE data.id = projects_data_component_id AND projects_data_project_id = ".$project_id.") AS project_total";
        $sql_exec_price = mysqli_Query($connection,$GetDataPrice) or die(mysqli_error());

        while($showPrice = mysqli_fetch_array($sql_exec_price)) {
            if ($showPrice['SUM(total)'] == 0) {
                if($personal['currency'] == "£" || $personal['currency'] == "$") {
                    echo $personal['currency'];
                    echo "0 ";    
                } elseif($personal['currency'] == "kr" || $personal['currency'] == "€") {
                echo ' ';
                echo "0";
                }
            } // end if sum == 0
            else {
                if($personal['currency'] == "£" || $personal['currency'] == "$") {
                    echo $personal['currency'];
                    echo sprintf("%.2f",$showPrice['SUM(total)']);
                } elseif ($personal['currency'] == "kr" || $personal['currency'] == "€") {
                    echo sprintf("%.2f",$showPrice['SUM(total)']);
                    echo ' ';
                    echo $personal['currency'];
                }
            } // end if sum > 0
        }
    } // end while
}
?>
