<?php
// File: include/include_proj_show.php
// Function: Show projects
// Revision date: 2026-09-14
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
class ProjectShow { 
    public function ProjectShowComponents() {

        require_once "login/auth.php";
        include "mysql_connect.php";

        $owner = $_SESSION['SESS_MEMBER_ID'];
        $project_id = (int)mysqli_real_escape_string($connection,$_GET["proj_id"]);

        if(isset($_GET['by'])) {
            $by      = strip_tags(mysqli_real_escape_string($connection,$_GET["by"]));
            $order_q = strip_tags(mysqli_real_escape_string($connection,$_GET["order"]));

            if($order_q == 'desc' or $order_q == 'asc'){
                $order = $order_q;
            }
            else{
                $order = 'asc';
            }

            if($by == 'price' or $by == 'quantity') {
                $GetDataComponentsAll = "SELECT * FROM projects_data, data WHERE owner = ".$owner." AND projects_data.projects_data_component_id = data.id AND projects_data.projects_data_project_id = ".$project_id." ORDER by ".$by." +0 ".$order."";
            }
            elseif($by == 'name' or $by == 'category' or $by == 'manufacturer' or $by =='package' or $by =='smd') {
                $GetDataComponentsAll = "SELECT * FROM projects_data, data WHERE owner = ".$owner." AND projects_data.projects_data_component_id = data.id AND projects_data.projects_data_project_id = ".$project_id." ORDER by ".$by." ".$order."";
            }
            else {
                $GetDataComponentsAll = "SELECT * FROM projects_data, data WHERE owner = ".$owner." AND projects_data.projects_data_component_id = data.id AND projects_data.projects_data_project_id = ".$project_id." ORDER by name ASC";
            }
        }
        else {
            $GetDataComponentsAll = "SELECT * FROM projects_data, data WHERE owner = ".$owner." AND projects_data.projects_data_component_id = data.id AND projects_data.projects_data_project_id = ".$project_id." ORDER by name ASC";
        }

        $sql_exec = mysqli_Query($connection,$GetDataComponentsAll);
        while($showDetails = mysqli_fetch_array($sql_exec)) {
            echo "<tr>";

            echo '<td class="edit"><a href="component_edit.php?edit=';
            echo $showDetails['id'];
            echo '"><span class="fa fa-pencil fa-lg"></span></a></td>';

            echo '<td><a href="component.php?view=';
            echo $showDetails['id'];
            echo '">';

            echo $showDetails['name'];
            echo "</a></td>";

            echo "<td>";

            if ($showDetails['category'] < 999) {
                $head_cat_id = substr($showDetails['category'], -3, 1);
            }
            else {
                $head_cat_id = substr($showDetails['category'], -4, 2);
            }
            $subcatid = $showDetails['category'];

            $CategoryName = "SELECT * FROM category_head WHERE id = ".$head_cat_id."";
            $sql_exec_catname = mysqli_Query($connection,$CategoryName);

            while($showDetailsCat = mysqli_fetch_array($sql_exec_catname)) {
                $catname = $showDetailsCat['name'];
            }
            echo gettext($catname);
            echo "</td>";

            echo "<td>";
            $manufacturer = $showDetails['manufacturer'];
                if ($manufacturer == ""){
                    echo "-";
                }
                else{
                    echo $manufacturer;
                }
            echo "</td>";

            echo "<td>";
            $package = $showDetails['package'];
                if ($package == ""){
                    echo "-";
                }
                else{
                    echo $package;
                }
            echo "</td>";

            echo "<td>";
            $location = $showDetails['location'];
                if ($location == ""){
                    echo "-";
                }
                else{
                    echo $location;
                }
            echo "</td>";

            echo "<td>";
            $price = $showDetails['price'];
                if ($price == ""){
                    echo "-";
                }
                else{
                    echo $price;
                }
            echo "</td>";

            echo "<td>";
            $quantity = $showDetails['quantity'];
                if ($quantity == ""){
                    echo "-";
                }
                else{
                    echo $quantity;
                }
            echo "</td>";
            
            echo "<td>";

            $comp_id = $showDetails['id'];
            $ShowQuant = mysqli_query($connection,"SELECT projects_data_quantity FROM projects_data WHERE projects_data_component_id = '$comp_id' AND projects_data_project_id = '$project_id'");
            $quant = mysqli_fetch_assoc($ShowQuant);

            $quantity = $quant['projects_data_quantity'];
                if ($quantity == ""){
                    echo "-";
                }
                else{
                    echo $quantity;
                }
            echo "</td>";
            echo "</tr>";
        }
    }
}
?>
