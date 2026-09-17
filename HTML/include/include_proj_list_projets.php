<?php
// File: include/include_proj_list_project.php
// Function: List all projects, used in proj_list.php
// Revision date: 2026-09-17
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
class Proj {
    public function ProjList() {

        // Funktion för att visa alla projekt, används i proj_list.php
        require_once "login/auth.php";
        include "mysql_connect.php";

        $owner = $_SESSION['SESS_MEMBER_ID'];

        $GetPersonal = mysqli_query($connection,"SELECT currency FROM members WHERE member_id = ".$owner."");
        $personal = mysqli_fetch_assoc($GetPersonal);

        if(isset($_GET['by'])) {

            $by = strip_tags(mysqli_real_escape_string($connection,$_GET["by"]));
            $order_q = strip_tags(mysqli_real_escape_string($connection,$_GET["order"]));

            if($order_q == 'desc' or $order_q == 'asc'){
                $order = $order_q;
            }
            else{
                $order = 'asc';
            }

            if($by == 'name') {
                $GetDataComponentsAll = "SELECT * FROM projects WHERE project_owner = ".$owner." ORDER by project_name ".$order."";
            }
            else {
                $GetDataComponentsAll = "SELECT * FROM projects WHERE project_owner = ".$owner." ORDER by project_name ASC";
            }
        }
        else {
            $GetDataComponentsAll = "SELECT * FROM projects WHERE project_owner = ".$owner." ORDER by project_name ASC";
        }
        $sql_exec = mysqli_Query($connection,$GetDataComponentsAll);

        while($showDetails = mysqli_fetch_array($sql_exec)) {
            echo "<tr>";
            echo '<td class="edit"><a href="proj_edit.php?proj_id=';
            echo $showDetails['project_id'];
            echo '"><span class="fas fa-pencil-alt fa-lg"></span></a></td>';

            echo "<td>";
            echo '<a href="proj_show.php?proj_id=';
            echo $showDetails['project_id'];
            echo '">';
            echo $showDetails['project_name'];
            echo '</a>';
            echo "</td>";

            echo "<td>";
            $components = mysqli_query($connection,"SELECT projects_data_project_id FROM projects_data WHERE projects_data_project_id = ".$showDetails['project_id']."");
            $number_components = mysqli_num_rows($components);
            if ($number_components == 0){
                echo "-";
            }
            else{
                echo $number_components;
            }
            echo "</td>";

            echo "<td>";
            $GetDataPrice = "SELECT SUM(total) FROM (SELECT projects_data_quantity * price AS total FROM projects_data JOIN `data` WHERE data.id = projects_data_component_id AND projects_data_project_id = ".$showDetails['project_id'].") AS project_total";
            $sql_exec_price = mysqli_Query($connection,$GetDataPrice) or die(mysql_error());

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
            } // end while
            echo "</td></tr>";
        }
    }
}
?>
