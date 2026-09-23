<?php
// File: include/include_proj_list_project.php
// Function: List all projects, used in proj_list.php
// Revision date: 2026-09-23
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
class Proj {
    public function ProjList() {

        require_once "login/auth.php";
        include "mysql_connect.php";
        include "include/include_format_currency.php"; // Currency formatter"

        $owner = $_SESSION['SESS_MEMBER_ID'];

        $GetPersonal = mysqli_query($connection,"SELECT currency, language FROM members WHERE member_id = ".$owner."");
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
            // First row
            echo '<tr>';
            // First column
            echo '<td class="edit"><a href="proj_edit.php?proj_id=';
            echo $showDetails['project_id'];
            echo '"><span class="fas fa-pencil-alt fa-lg"></span></a>';
            echo '</td>'; //end first column
            // Second column
            echo '<td>';
            echo '<a href="proj_show.php?proj_id=';
            echo $showDetails['project_id'];
            echo '">';
            echo $showDetails['project_name'];
            echo '</a>';
            echo '</td>'; // end second column
            // third column
            echo '<td>';
            $components = mysqli_query($connection,"SELECT projects_data_project_id, projects_data_quantity FROM projects_data WHERE projects_data_project_id = ".$showDetails['project_id']."");
            $number_components = mysqli_num_rows($components);
            if ($number_components == 0){
                echo "0";
            }
            else{
                echo $number_components;
            }
            echo '</td>'; // end third column
            // fourth column
            echo '<td>';
            if( $number_components > 0 ) { // if there are components in the project
                $NoOfComponents = mysqli_fetch_assoc($components); // get the component quantity
                if ( $NoOfComponents['projects_data_quantity'] == "" ) { // empty?
                    echo "0"; // yes, display a zero
                } else {
                    echo $NoOfComponents['projects_data_quantity']; // display the unit count
                }
            } else {
                echo "0"; // No components in the project
            }
            // end fourth column
            echo '</td>';

            echo '<td>'; // start fifth column
            $GetDataPrice = "SELECT SUM(total) FROM (SELECT projects_data_quantity * price AS total FROM projects_data JOIN `data` WHERE data.id = projects_data_component_id AND projects_data_project_id = ".$showDetails['project_id'].") AS project_total";
            $sql_exec_price = mysqli_Query($connection,$GetDataPrice) or die(mysql_error());
            $showPrice = mysqli_fetch_array($sql_exec_price);
            $sum = $showPrice['SUM(total)'];
                if ($sum == "" || $sum == "0"){
                    $price = "0";
                }
                else{
                    $price = $sum;
                }
                    echo format_currency($personal['language'],$personal['currency'], $price) ;
            echo '</td></tr>'; // end fifth column, end row
        }
    }
}
?>
