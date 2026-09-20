<?php
// File: include/include_all_proj_show_price.php
// Function: Show price summary for all projects
//           Used in proj_list.php
// Revision date: 2026-09-20
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
class AllProjectShowPrice {
    public function AllProjectSumTotal() {

        include "mysql_connect.php";

        $owner = $_SESSION['SESS_MEMBER_ID'];
        $total = 0;
        $GetPersonal = mysqli_query($connection,"SELECT currency, language FROM members WHERE member_id = ".$owner."");
        $personal = mysqli_fetch_assoc($GetPersonal);

        // Get all project, if any, for the current user
        $projects = mysqli_query($connection,"SELECT project_id FROM projects WHERE project_owner = ".$owner." ORDER by project_id");
        $numrows = mysqli_num_rows($projects);
        while($result = mysqli_fetch_assoc($projects)) {
            $GetDataPrice = "SELECT SUM(total) FROM (SELECT projects_data_quantity * price AS total FROM projects_data JOIN `data` WHERE data.id = projects_data_component_id AND projects_data_project_id = " . $result['project_id'] . ") AS project_total";
            $sql_exec_price = mysqli_Query($connection,$GetDataPrice) or die(mysqli_error());

            $showPrice = mysqli_fetch_array($sql_exec_price);
            $sum = $showPrice['SUM(total)'];
            $total = $total + $sum;
        }
            if ($total == "" || $total == "0"){
                $price = "0";
            }
            else{
                $price = $total;
            }
        echo _("Total cost") . ": ";
        echo format_currency($personal['language'],$personal['currency'], $price) ;
    }
}
?>
