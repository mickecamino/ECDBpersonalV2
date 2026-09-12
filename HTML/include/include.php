<?php
// File: include/include.php
// Function: Add functions: Index, Category, Seacrh and Add
// Revision date: 2026-09-12
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
class ShowComponents {
    public function Index() {

        require_once "login/auth.php";
        include "mysql_connect.php";

        $owner = $_SESSION['SESS_MEMBER_ID'];

        if(isset($_GET['by'])) {
            $by      = strip_tags(mysqli_real_escape_string($connection,$_GET["by"]));
            $order_q = strip_tags(mysqli_real_escape_string($connection,$_GET["order"]));

            if($order_q == 'desc' or $order_q == 'asc'){
                $order = $order_q;
            }
            else{
                $order = 'asc';
            }

            if($by == 'location' or $by == 'pins' or $by == 'quantity') {
                $GetDataComponentsAll = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE owner = ".$owner." ORDER by ".$by." ".$order.    "";
            }
            elseif($by == 'name' or $by == 'category' or $by =='package') {
                $GetDataComponentsAll = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE owner = ".$owner." ORDER by ".$by." ".$order."";
            }
            else {
                $GetDataComponentsAll = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE owner = ".$owner." ORDER by name ASC";
            }
        } // end if isset
        else {
                $GetDataComponentsAll = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE owner = ".$owner." ORDER by name ASC";
        }
        $sql_exec = mysqli_Query($connection,$GetDataComponentsAll);
        while($showDetails = mysqli_fetch_array($sql_exec)) {
// first row
            echo "<tr>";
// first column
            echo '<td class="edit"><a href="component_edit.php?edit=';
            echo $showDetails['id'];
            echo '"><span class="fa fa-pencil fa-lg"></span></a></td>';
// second column
            echo '<td><a href="component.php?view=';
            echo $showDetails['id'];
            echo '">';

            echo $showDetails['name'];
            echo "</a></td>";
// third column
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
            echo '<a href="category.php?cat=$head_cat_id">' . gettext($catname) . '</a>';
            echo "</td>";
// Fourth column
            echo "<td>";
            $package = $showDetails['package'];
            if ($package == ""){
                echo "-";
            }
            else{
                echo $package;
            }
            echo "</td>";
// fifth column
            echo "<td>";
            $pins = $showDetails['pins'];
            if ($pins == 0){
                echo "-";
            }
            else{
                echo $pins;
            }
            echo "</td>";
// sixth column
            echo "<td>";
            $image = $showDetails['cimage'];
            if ($image==""){
                echo "-";
            }
            else{
                echo '<a class="thumbnail" href="img/parts/';
                echo $image;
                echo '"><span class="fa fa-file-image-o fa-lg"></span><span class="imgB"><img src="img/parts/';
                echo $image;
                echo '" /></span></a></td>';
            }
// seventh column
            echo "<td>";
            $datasheet = $showDetails['datasheet'];
            if ($datasheet==""){
                echo "-";
            }
            else{
                echo '<a href="sheets/';
                echo $datasheet;
                echo '"  target="_blank"><span class="fa fa-file-pdf-o fa-lg"></span></a></td>';
            }
// eigth column
            echo "<td>";
            $location = $showDetails['location'];
            if ($location == ""){
                echo "-";
            }
            else{
                echo $location;
            }
            echo "</td>";
// ninth column
            echo "<td>";
            $quantity = $showDetails['quantity'];
            if ($quantity == ""){
                echo "-";
            }
            else{
                echo $quantity;
            }
            echo "</td>";
// tenth column
            $comment = $showDetails['comment'];
            if ($comment==""){
                echo '<td class="comment"><div>';
                echo "-";
                echo '</div></td>';
            }
            else{
                echo '<td class="comment"><div><span class="fa fa-comment fa-lg"></span><span class="comment">';
                echo nl2br($showDetails['comment']);
                echo '</span></div></td>';
            }
            echo "</tr>";
        } // end while
    } // end public function Index()

    public function Category() {

        require_once "include/login/auth.php";
        include "include/mysql_connect.php";

        $owner = $_SESSION['SESS_MEMBER_ID'];

        if(isset($_GET['cat'])) {
            $cat = (int)$_GET['cat'];
            $subcatfrom = $cat*100;
            $subcatto = $subcatfrom+99;
            $CategoryName = "SELECT * FROM category_sub WHERE id = ".$cat."";
            $sql_exec_catname = mysqli_Query($connection,$CategoryName);

            if(isset($_GET['by'])) {
                $by      = strip_tags(mysqli_real_escape_string($connection,$_GET["by"]));
                $order_q = strip_tags(mysqli_real_escape_string($connection,$_GET["order"]));

                if($order_q == 'desc' or $order_q == 'asc') {
                    $order = $order_q;
                }
                else {
                    $order = 'asc';
                }
                if($by == 'location' or $by == 'pins' or $by == 'quantity') {
                    $ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto." AND owner = ".$owner." ORDER by ".$by." +0 ".$order."";
                }
                elseif($by == 'name' or $by == 'category' or $by =='package') {
                    $ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto." AND owner = ".$owner." ORDER by ".$by." ".$order."";
                }
                else {
                    $ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto." AND owner = ".$owner." ORDER by name ASC";
                }
            } // end second if isset
            else {
                $ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto."     AND owner = ".$owner." ORDER by name ASC";
            }

            $sql_exec_component = mysqli_Query($connection,$ComponentsCategory);

            while ($showDetails = mysqli_fetch_array($sql_exec_component)) {
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
                $subcatid = $showDetails['category'];
                $CategoryName = "SELECT * FROM category_sub WHERE id = ".$subcatid."";
                $sql_exec_catname = mysqli_Query($connection,$CategoryName);
                while($showDetailsCat = mysqli_fetch_array($sql_exec_catname)) {
                    $catname = $showDetailsCat['name'];
                }
                echo "<a href='category.php?subcat=$subcatid'>". gettext($catname) . "</a>";
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
                $pins = $showDetails['pins'];
                if ($pins == 0){ // Pin is zero in the database
                    echo "-";
                }
                else{
                    echo $pins;
                    }
                echo "</td>";

                echo "<td>";
                $image = $showDetails['cimage'];
                if ($image==""){
                    echo "-";
                }
                else{
                    echo '<a class="thumbnail" href="img/parts/';
                    echo $image;
                    echo '"><span class="fa fa-file-image-o fa-lg"></span><span class="imgB"><img src="img/parts/';
                    echo $image;
                    echo '" /></span></a>';
                }
                echo "</td>";

                echo "<td>";
                $datasheet = $showDetails['datasheet'];
                if ($datasheet==""){
                    echo "-";
                }
                else{
                    echo '<a href="sheets/';
                    echo $datasheet;
                    echo '" target="_blank"><span class="fa fa-file-pdf-o fa-lg"> </span></a>';
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
                $quantity = $showDetails['quantity'];
                if ($quantity == ""){
                    echo "-";
                }
                else{
                    echo $quantity;
                    }
                echo "</td>";

                $comment = $showDetails['comment'];
                if ($comment == ""){
                    echo '<td class="comment"><div>';
                    echo "-";
                    echo '</div></td>';
                }
                else{
                    echo '<td class="comment"><div><span class="fa fa-comment fa-lg"></span><span class="comment">';
                    echo $showDetails['comment'];
                    echo '</span></div></td>';
                    }
                echo "</tr>";
            } // end while
        } // end first if isset

        if(isset($_GET['subcat'])) {
            $subcat = (int)$_GET['subcat'];
            $CategoryName = "SELECT * FROM category_sub WHERE id = ".$subcat."";
            $sql_exec_catname = mysqli_Query($connection,$CategoryName);
            if(isset($_GET['by'])) {
                $by      = strip_tags(mysqli_real_escape_string($connection,$_GET["by"]));
                $order_q = strip_tags(mysqli_real_escape_string($connection,$_GET["order"]));
                if($order_q == 'desc' or $order_q == 'asc') {
                    $order = $order_q;
                }
                else {
                    $order = 'asc';
                }
                if($by == 'location' or $by == 'pins' or $by == 'quantity') {
                    $ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner."     ORDER by ".$by." +0 ".$order."";
                }
                elseif($by == 'name' or $by == 'category' or $by =='package') {
                    $ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner."     ORDER by ".$by." ".$order."";
                }
                else {
                    $ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner."     ORDER by name ASC";
                }
            } // end second if isset
            else{
                $ComponentsCategory = "SELECT id, name, category, package, pins, datasheet, cimage, location, quantity, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner."     ORDER by name ASC";
            }
            $sql_exec_component = mysqli_Query($connection,$ComponentsCategory);
            while ($showDetails = mysqli_fetch_array($sql_exec_component)) {
                echo "<tr>";
                echo '<td class="edit"><a href="component_edit.php?edit=';
                echo $showDetails['id'];
                echo '"><span class="fa fa-pencil fa-lg"> </span></a></td>';

                echo '<td><a href="component.php?view=';
                echo $showDetails['id'];
                echo '">';
                echo $showDetails['name'];
                echo "</a></td>";

                echo "<td>";
                while($showDetailsCat = mysqli_fetch_array($sql_exec_catname)) {
                    $catname = $showDetailsCat['name'];
                }
                echo gettext($catname);
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
                $pins = $showDetails['pins'];
                if ($pins == 0){
                    echo "-";
                }
                else{
                    echo $pins;
                }
                echo "</td>";

                echo "<td>";
                $image = $showDetails['cimage'];
                if ($image==""){
                    echo "-";
                }
                else{
                    echo '<a class="thumbnail" href="img/parts/';
                    echo $image;
                    echo '"><img src="img/picture.png" /><span class="imgB"><img src="img/parts/';
                    echo $image;
                    echo '" /></span></a></td>';
                }

                echo "<td>";
                $datasheet = $showDetails['datasheet'];
                if ($datasheet==""){
                    echo "-";
                }
                else{
                    echo '<a href="sheets/';
                    echo $datasheet;
                    echo '" target="_blank"><span class="fa fa-file-pdf-o fa-lg"> </span></a></td>';
                }

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
                $quantity = $showDetails['quantity'];
                if ($quantity == ""){
                    echo "-";
                    }
                else{
                    echo $quantity;
                }
                echo "</td>";

                $comment = $showDetails['comment'];
                if ($comment == ""){
                    echo '<td class="comment"><div>';
                    echo "-";
                    echo '</div></td>';
                }
                else{
                    echo '<td class="comment"><div><span class="fa fa-comment fa-lg"></span><span class="comment">';
                    echo $showDetails['comment'];
                    echo '</span></div></td>';
                }
                echo "</tr>";
            } // end first while
        } // end if isset
    } // end public function Category()


    public function Search() {

        if(isset($_GET['q'])) {
            require_once "include/login/auth.php";
            include "include/mysql_connect.php";
            $owner = $_SESSION['SESS_MEMBER_ID'];
            $query = mysqli_real_escape_string($connection,$_GET['q']);
            $query1 = strtoupper($query);
            $query2 = strip_tags($query1);
            $find = trim($query2);
            if ($find == "") {
                echo '<div class="message red">';
                echo _("You forgot to enter a search term.");
                echo '</div>';
            }
            else {
                if (isset($_GET['by'])) { // start second if isset
                    $by      = strip_tags(mysqli_real_escape_string($connection,$_GET["by"]));
                    $order_q = strip_tags(mysqli_real_escape_string($connection,$_GET["order"]));
                    if($order_q == 'desc' or $order_q == 'asc') {
                        $order = $order_q;
                        }
                    else {
                        $order = 'asc';
                    }
                    if($by == 'location' or $by == 'pins' or $by == 'quantity') {
                        $SearchQuery = "SELECT * FROM data WHERE (name LIKE'%$find%' OR package LIKE'%$find%' OR manufacturer LIKE'%$find%' OR pins LIKE'%$find%' OR location LIKE'%$find%' OR comment     LIKE'%$find%') AND owner = $owner ORDER by $by +0 $order";
                    }
                    elseif($by == 'name' or $by == 'category' or $by =='package' or $by =='manufacturer') {
                        $SearchQuery = "SELECT * FROM data WHERE (name LIKE'%$find%' OR package LIKE'%$find%' OR manufacturer LIKE'%$find%' OR pins LIKE'%$find%' OR location LIKE'%$find%' OR comment     LIKE'%$find%') AND owner = $owner ORDER by $by $order";
                    }
                    else {
                        $SearchQuery = "SELECT * FROM data WHERE (name LIKE'%$find%' OR package LIKE'%$find%' OR manufacturer LIKE'%$find%' OR pins LIKE'%$find%' OR location LIKE'%$find%' OR comment     LIKE'%$find%') AND owner = $owner ORDER by name ASC";
                    }
                } // end second if isset
                else {
                $SearchQuery = "SELECT * FROM data WHERE (name LIKE'%$find%' OR package LIKE'%$find%' OR manufacturer LIKE'%$find%' OR pins LIKE'%$find%' OR location LIKE'%$find%' OR comment LIKE'%$    find%') AND owner = $owner ORDER by name ASC";
                }
                $sql_exec = mysqli_query($connection,$SearchQuery);
                $anymatches = mysqli_num_rows($sql_exec);
                if ($anymatches == 0) {
                    echo '<div class="message red">';
                    echo _("Sorry, but we can not find an entry to match your query.");
                    echo '</div>';
                }

                while($showDetails = mysqli_fetch_array($sql_exec)) {
                    echo "<tr>";
                    echo '<td class="edit"><a href="component_edit.php?edit=';
                    echo $showDetails['id'];
                    echo '"><span class="fa fa-pencil fa-lg"> </span></a></td>';

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
                    echo $catname;
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
                    $pins = $showDetails['pins'];
                    if ($pins == 0){
                        echo "-";
                    }
                    else{
                        echo $pins;
                    }
                    echo "</td>";

                    echo "<td>";
                    $image = $showDetails['cimage'];
                    if ($image==""){
                        echo "-";
                    }
                    else{
                        echo '<a class="thumbnail" href="img/parts/';
                        echo $image;
                        echo '"><span class="fa fa-file-image-o fa-lg"></span><span class="imgB"><img src="img/parts/';
                        echo $image;
                        echo '" /></span></a></td>';
                    }

                    echo "<td>";
                    $datasheet = $showDetails['datasheet'];
                    if ($datasheet==""){
                        echo "-";
                    }
                    else{
                        echo '<a href="sheets/';
                        echo $datasheet;
                        echo '" target="_blank"><span class="fa fa-file-pdf-o fa-lg"> </span></a></td>';
                    }

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
                    echo $showDetails['quantity'];
                    echo "</td>";

                    $comment = $showDetails['comment'];
                    if ($comment == ""){
                        echo '<td class="comment"><div>';
                        echo "-";
                        echo '</div></td>';
                    }
                    else{
                        echo '<td class="comment"><div><span class="fa fa-comment fa-lg"></span><span class="comment">';
                        echo $showDetails['comment'];
                        echo '</span></div></td>';
                    }
                    echo "</tr>";
                } // end while
            } // end else
        } // end if(isset($_GET['q']))
    } // end public function Search()

    public function Add() {

        require_once "include/login/auth.php";
        include "include/mysql_connect.php";

        if(isset($_POST['submit']) or isset($_POST['update'])) {
            $owner = $_SESSION['SESS_MEMBER_ID'];

            if (empty($_GET['edit'])) {
                $id = '';
            }
            else{
                $id = (int)$_GET['edit'];
            }

            if (empty($_POST['name'])) {
                $name = '';
            }
            else{
                $name = strip_tags(mysqli_real_escape_string($connection,$_POST['name']));
            }

            if (empty($_POST['quantity'])) {
                $quantity = 0;
            }
            else{
//                $quantity = str_replace(',', '.', strip_tags(mysqli_real_escape_string($connection,$_POST['quantity'])));
            $quantity = (int)$_POST['quantity'];
            }

            if (empty($_POST['category'])) {
                $category = '';
            }
            else{
//                $category = strip_tags(mysqli_real_escape_string($connection,$_POST['category']));
                $category = (int)$_POST['category'];
            }

            if (empty($_POST['project'])) {
                $project = '';
            }
            else{
                $project = (int)$_POST['project'];
//                $project = strip_tags(mysqli_real_escape_string($connection,$_POST['project']));
            }

            $comment          = strip_tags(mysqli_real_escape_string($connection,$_POST['comment']));
            $order_quantity   = (int)$_POST['orderquant'];
            $project_quantity = (int)$_POST['projquant'];
            $price            = str_replace(',', '.', strip_tags(mysqli_real_escape_string($connection,$_POST['price'])));
            $location         = strip_tags(mysqli_real_escape_string($connection,$_POST['location']));
            $manufacturer     = strip_tags(mysqli_real_escape_string($connection,$_POST['manufacturer']));
            $package          = strip_tags(mysqli_real_escape_string($connection,$_POST['package']));
            $pins             = (int)$_POST['pins'];
            $scrap            = strip_tags(mysqli_real_escape_string($connection,$_POST['scrap']));
            $datasheet        = strip_tags(mysqli_real_escape_string($connection,$_POST['datasheet']));
            $cimage           = strip_tags(mysqli_real_escape_string($connection,$_POST['cimage']));
            $appnote          = strip_tags(mysqli_real_escape_string($connection,$_POST['appnote']));

            if ($name == '') {
                echo '<div class="message red">';
                echo _("You have to specify a name!");
                echo '</div>';
            }
            elseif ($category == '') {
                echo '<div class="message red">';
                echo _("You have to choose a category!");
                echo '</div>';
            }
            elseif (!empty($project_quantity) && empty($project)) {
                echo '<div class="message red">';
                echo _("You have to choose a project!");
                echo '</div>';
            }
            elseif (!empty($project) && empty($project_quantity)) {
                echo '<div class="message red">';
                echo _("You have to specify a quantity for this component to add to the project!");
                echo '</div>';
            }
            elseif (strlen($comment) >= 255) {
                echo '<div class="message red">';
                echo _("Max 255 characters in the comment!");
                echo '</div>';
            }
            elseif (!empty($_POST['quantity']) && !is_numeric($quantity)) {
                echo '<div class="message red">';
                echo _("The quantity must only be a number!");
                echo '</div>';
            }
            elseif (!empty($_POST['pins']) && !is_numeric($pins)) {
                echo '<div class="message red">';
                echo _("The pin-count must only be a number!");
                echo '</div>';
            }
            elseif (!empty($_POST['price']) && !is_numeric($price)) {
                echo '<div class="message red">';
                echo _("The price must only be a number!");
                echo '</div>';
            }
            elseif (!empty($_POST['orderquant']) && !is_numeric($order_quantity)) {
                echo '<div class="message red">';
                echo _("The order quantity must only be a number!");
                echo '</div>';
            }
            else {
                if(isset($_POST['submit'])) {
                    $sql="INSERT into data (owner, name, manufacturer, package, pins, quantity, location, scrap, datasheet, comment, category, cimage,appnote, price, order_quantity) VALUES ('$owner', '$name', '$manufacturer', '$package', '$pins', '$quantity', '$location', '$scrap', '$datasheet', '$comment', '$category', '$cimage', '$appnote' ,'$price', '$order_quantity')";

                    $sql_exec = mysqli_query($connection,$sql) or die(mysqli_error());
                    $component_id = mysqli_insert_id($connection);

                    if (!empty($project) && !empty($project_quantity)) {
                        $proj_add="INSERT into projects_data (projects_data_owner_id, projects_data_project_id, projects_data_component_id, projects_data_quantity) VALUES ('$owner', '$project', '$component_id', '$project_quantity')";
                        $sql_exec = mysqli_query($connection,$proj_add);
                    } // end if (!empty($project)

                    echo '<div class="message green center">';
                    echo _("Component added!") . ' - <a href="component.php?view=';
                    echo $component_id;
                    echo '">' . _("View component") . ' (';
                    $result = mysqli_query($connection,"SELECT name FROM data WHERE id = '$component_id'");
                    $name = mysqli_fetch_array($result);
                    echo $name['name'];
                    echo ')</a>';
                    echo '</div>';
                } // end if(isset($_POST['submit']))

                if(isset($_POST['update'])) {
                    $sql = "UPDATE data SET name = '$name', manufacturer = '$manufacturer', package = '$package', pins = '$pins', quantity = '$quantity', location = '$location', scrap = '$scrap', datasheet = '$datasheet', comment = '$comment', category = '$category', cimage = '$cimage', price = '$price', order_quantity = '$order_quantity' ,appnote = '$appnote' WHERE id = '$id'";

                    $sql_exec = mysqli_query($connection,$sql);

                    if (!empty($project) && !empty($project_quantity)) {
                        $proj_add="INSERT into projects_data (projects_data_owner_id, projects_data_project_id, projects_data_component_id, projects_data_quantity) VALUES ('$owner', '$project', '$id', '$project_quantity')";

                        $sql_exec = mysqli_query($connection,$proj_add) or die(mysqli_error());
                        echo $project;
                        echo ' Owner ';
                        echo $owner;
                        echo ' id ';
                        echo $id;
                        echo ' projquant ';
                        echo $project_quantity;
                    } // end if (!empty($project)

                    if (isset($_POST['projquantedit'])) {
                        $proj = $_POST['projquantedit'];

                        foreach ($proj as $quantity_proj_add){
                            $projects = array_search($quantity_proj_add, $proj);
                            $sqlDeleteProject = "DELETE FROM projects_data WHERE projects_data_component_id = '$id' AND projects_data_project_id = '$projects'";
                            $sql_exec_project_delete = mysqli_query($connection,$sqlDeleteProject);

                            if ($quantity_proj_add == 0){
                                echo 'None';
                            }
                            else{
                                $proj_edit="INSERT into projects_data (projects_data_owner_id, projects_data_project_id, projects_data_component_id, projects_data_quantity) VALUES ('$owner', '$projects', '$id', '$quantity_proj_add')";

                                $sql_exec = mysqli_query($connection,$proj_edit);
                            }
                        }
                    } // end if (isset($_POST['projquantedit']))
                    header("location: " . $_SERVER['REQUEST_URI']);
                } // end if(isset($_POST['update']))
            } // end else
        } // emd if(isset($_POST['submit'])
    } // end public function Add()
}
?>
