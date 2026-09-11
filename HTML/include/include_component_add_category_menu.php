<?php
// File: include/include_component_add_category_menu.php
// Function: show categories in add component
// Revision date: 2026-08-31
// Revised by: Mikael Karlsson
// This file is distributed under the license: 
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
// 
class AddMenuCat {
    public function MenuCat() {

        require_once('include/login/auth.php');
        include('include/mysql_connect.php');

        $HeadCategoryNameQuery = "SELECT * FROM category_head ORDER by name ASC";
        $sql_exec_headcat = mysqli_Query($connection,$HeadCategoryNameQuery);

        echo '<option class="main_category" value="">';
        echo _(" - Category - ");
        echo '</option>';

        while ($HeadCategory = mysqli_fetch_array($sql_exec_headcat)) {
            echo '<option class="main_category" value="';
            echo $HeadCategory['id'];
            echo '" disabled="disabled">';
            echo gettext($HeadCategory['name']);
            echo '</option>';

            $subcatfrom = $HeadCategory['id'] * 100;
            $subcatto = $subcatfrom + 99;

            $SubCategoryNameQuery = "SELECT * FROM category_sub WHERE id BETWEEN ".$subcatfrom." AND ".$subcatto." ORDER by name ASC";
            $sql_exec_subcat = mysqli_Query($connection,$SubCategoryNameQuery);

            while ($SubCategory = mysqli_fetch_array($sql_exec_subcat)) {
                echo '<option value="';
                echo $SubCategory['id'];
                echo '"';
                if(isset($_POST['submit'])) {
                    if(isset($_POST['category'])) {
                        if($SubCategory['id'] == $_POST['category']) {
                            echo ' selected ';
                        }
                    }
                }
                echo '>';
                echo gettext($SubCategory['name']);
                echo '</option>';
            }
        }
    }
}
?>
