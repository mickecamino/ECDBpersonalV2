<?php
// File: component_edit.php
// Function: Edit components
// Revision date: 2026-09-02
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "include/login/auth.php";
    include "include/mysql_connect.php";

    $owner  =   $_SESSION['SESS_MEMBER_ID'];
    $id     =   (int)$_GET['edit'];
    // Select all details for id
    $GetDataComponent = mysqli_query($connection,"SELECT * FROM data WHERE id = ".$id." AND owner = ".$owner."");
    $executesql = mysqli_fetch_assoc($GetDataComponent);

    $GetPersonal = mysqli_query($connection,"SELECT currency FROM members WHERE member_id = ".$owner."");
    $personal = mysqli_fetch_assoc($GetPersonal);

    if ($executesql['owner'] !== $owner) {
        header("Location: error.php?id=2");
    }

    if ($executesql['category'] < 999) {
        $head_cat_id = substr($executesql['category'], -3, 1);
    }
    else {
        $head_cat_id = substr($executesql['category'], -4, 2);
    }

    $GetHeadCatName = mysqli_query($connection,"SELECT * FROM category_head WHERE id = ".$head_cat_id."");
    $executesql_head_catname = mysqli_fetch_assoc($GetHeadCatName);


    $sub_cat_id = $executesql['category'];

    $GetSubCatName = mysqli_query($connection,"SELECT * FROM category_sub WHERE id = ".$sub_cat_id."");
    $executesql_sub_catname = mysqli_fetch_assoc($GetSubCatName);

    $GetDataComponentsAll = "SELECT * FROM category_sub";
    $sql_exec = mysqli_query($connection,$GetDataComponentsAll);

    if(isset($_POST['delete'])) {
        $sqlDeleteComponent = "DELETE FROM data WHERE id = ".$id." ";
        $sql_exec_component_delete = mysqli_query($connection,$sqlDeleteComponent);

        $sqlDeleteProject = "DELETE FROM projects_data WHERE projects_data_component_id = '$id'";
        $sql_exec_project_delete = mysqli_query($connection,$sqlDeleteProject);

        header("Location: .");
    }

    if(isset($_POST['based'])) {
        header("Location: add_based.php?based=$id");
    }

    if (isset($_POST['quantity_increase'])) {
        $quantity_before    =   $_POST['quantity'];
        $quantity_after     =   $quantity_before + 1;

        $sql = "UPDATE data SET quantity = '".$quantity_after."' WHERE id = ".$id." ";
        $sql_exec = mysqli_query($connection,$sql);
        header("location: " . $_SERVER['REQUEST_URI']);
    }

    if (isset($_POST['quantity_decrease'])) {
        $quantity_before    =   $_POST['quantity'];
        $quantity_after     =   $quantity_before - 1;

        $sql = "UPDATE data SET quantity = '".$quantity_after."' WHERE id = ".$id." ";
        $sql_exec = mysqli_query($connection,$sql);
        header("location: " . $_SERVER['REQUEST_URI']);
    }

    if (isset($_POST['orderquant_increase'])) {
        $quantity_before    =   $_POST['orderquant'];
        $quantity_after     =   $quantity_before + 1;

        $sql = "UPDATE data SET order_quantity = '".$quantity_after."' WHERE id = ".$id." ";
        $sql_exec = mysqli_query($connection,$sql);
        header("location: " . $_SERVER['REQUEST_URI']);
    }

    if (isset($_POST['orderquant_decrease'])) {
        $quantity_before    =   $_POST['orderquant'];
        $quantity_after     =   $quantity_before - 1;

        $sql = "UPDATE data SET order_quantity = '".$quantity_after."' WHERE id = ".$id." ";
        $sql_exec = mysqli_query($connection,$sql);
        header("location: " . $_SERVER['REQUEST_URI']);
    }

// Custom Page Titles
    $pageTitle = _("Edit component");
    include "include/head.php";

    echo '<body><div id="wrapper">';
// Header
    include "include/header.php";
// END
// Main menu
    include "include/menu.php";
// END
// Main content
    echo '<div id="content"><h2><a href="category.php?cat=';
    echo $executesql_head_catname['id'] . '"> ';
    echo gettext($executesql_head_catname['name']) . '</a> / ';

    echo '<a href="category.php?subcat=';
    echo $executesql_sub_catname['id'] . '"> ';
    echo gettext($executesql_sub_catname['name']) . '</a> ';

    echo  '<a href="component.php?view=';
    echo $executesql['id'] . '">';
    echo $executesql['name'] . '</a></h2>';

    include "include/include.php";
    $Add = new ShowComponents;
    $Add->Add();

// start form
    echo '<form class="globalForms noPadding" action="" method="post"><div class="textBoxInput"><label class="keyWord boldText">' . _("Comment") . '</label>';
    echo '<div class="text"><textarea name="comment" rows="4" cols="104">' . $executesql['comment'] . '</textarea></div></div>';
// start table and tbody and first row
    echo '<table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0"><tbody><tr>';
// start and end first column
    echo '<td class="boldText">' . _("Name") . '</td>';
//  start and end second column
    echo '<td><input name="name" type="text" class="medium" value="' . $executesql['name'] . '" id="name" ></td>';
// start end end third column
    echo '<td class="boldText">' . _("Category") . '</td>';
// start and end fourth column
    echo '<td><select name="category">';
    $HeadCategoryNameQuery = "SELECT * FROM category_head ORDER by name ASC";
    $sql_exec_headcat = mysqli_Query($connection,$HeadCategoryNameQuery);

    while ($HeadCategory = mysqli_fetch_array($sql_exec_headcat)) {
        echo '<option class="main_category" value="';
        echo $HeadCategory['id'];
        echo '" disabled>';
        echo $HeadCategory['name'];
        echo '</option>';
        $subcatfrom = $HeadCategory['id'] * 100;
        $subcatto = $subcatfrom + 99;

        $SubCategoryNameQuery = "SELECT * FROM category_sub WHERE id BETWEEN ".$subcatfrom." AND ".$subcatto." ORDER by name ASC";
        $sql_exec_subcat = mysqli_Query($connection,$SubCategoryNameQuery);

        while ($SubCategory = mysqli_fetch_array($sql_exec_subcat)) {
            echo '<option value="';
            echo $SubCategory['id'];
            echo '"';
            if ($executesql_sub_catname['id'] == $SubCategory['id']) {
                echo ' selected';
            }
            echo '>';
            echo $SubCategory['name'];
            echo '</option>';
        } // second while
    } // first while
    echo '</select></td>';
// start and end fifth column
    echo '<td class="boldText">' . _("Quantity") . '</td>';
// start and end sixth column
    echo '<td><input name="quantity" type="text" class="small" value="' . $executesql['quantity'] . '" id="quantity">';
    echo '<button class="button white small" name="quantity_increase" type="submit"><span class="fa  fa-plus-square fa-lg"></span></button>';
    echo '<button class="button white small" name="quantity_decrease" type="submit"><span class="fa  fa-minus-square fa-lg"></span></button></td>';
// end first row, start second row
    echo '</tr><tr>';
// start and end first column
    echo '<td class="boldText">' . _("Manufacturer") . '</td>';
// start and end second column
    echo '<td><div class="ui-widget"><input id="manufacturer" name="manufacturer" type="text" value="' . $executesql['manufacturer'] . '" ></div></td>';
// start and end third column
    echo '<td class="boldText">' . _("Package") . '</td>';
// start and end fourth column
    echo '<td><div class="ui-widget"><input id="package" name="package" type="text" value="' . $executesql['package'] . '" ></div></td>';
// start and end fifth column
    echo'<td class="boldText">' . _("Pins") . '</td>';
// start and end sixth column
    echo '<td><input name="pins" type="text" class="small" value="' . $executesql['pins'] . '" ></td>';
// end second row, start third row
    echo '</tr><tr>';
// start and end first column
    echo '<td class="boldText">' . _("Location") . '</td>';
// start and end second column
    echo '<td><div class="ui-widget"><input id="location" type="text" name="location"  value="' . $executesql['location'] . '" ></div></td>';
// start and end third column
    echo '<td class="boldText">' . _("Price") . '</td>';
// start and end fourth column
    echo '<td><input name="price" type="text" class="small" value="' . $executesql['price'] . '" id="price" > ' . $personal['currency'] . '</td>';
// start and end fifth column
    echo '<td class="boldText">' . _("To order") . '</td>';
// start and end sixth column
    echo '<td><input name="orderquant" type="text" class="small" value="' . $executesql['order_quantity'] . '" id="orderquant">';
    echo '<button class="button white small" name="orderquant_increase" type="submit"><span class="fa  fa-plus-square fa-lg"></span></button>';
    echo '<button class="button white small" name="orderquant_decrease" type="submit"><span class="fa  fa-minus-square fa-lg"></span></button></td>';
// end third row, start fourth row
    echo '</tr><tr>';
// start and end first column
    echo '<td class="boldText">' . _("Recycled") . '</td>';
// start and end second column
    echo '<td>';
    if($executesql['scrap'] == 'Yes'){
        echo '<input type="radio" name="scrap" value="Yes" checked="checked" > ' . _("Yes") . ' ';
        echo '<input type="radio" name="scrap" value="No" > ' . _("No");
    }
    else{
        echo '<input type="radio" name="scrap" value="Yes" > ' . _("Yes") .' ';
        echo '<input type="radio" name="scrap" value="No" checked="checked" > ' . _("No");
    }
    echo '</td>';
// start and end third to sixth columns, end fourth row
    echo '<td></td><td></td><td></td><td></td></tr>';
// start fifth rows, start and end first column
    echo '<tr><td class="boldText">' . _("Datasheet") . '</td>';
// start and end second column
    echo '<td><div class="ui-widget"><input id="datasheet" name="datasheet" type="text" value="' . $executesql['datasheet'] . '" ></div></td>';
// start and end third column
    echo '<td class="boldText">' . _("Image") . '</td>';
// start and end fourth column
    echo '<td><div class="ui-widget"><input id="images" name="cimage" type="text" value="' . $executesql['cimage'] . '" ></div></td>';
// start and end fifth and sixth columns, end fifth row
    echo '<td></td><td></td></tr>';
// start sixth row, start and end first column
    echo '<tr><td class="boldText">' . _("Application Note") . '</td>';
// start and end second column
    echo '<td><div class="ui-widget"><input id="appnote" name="appnote" type="text" value="' . $executesql['appnote'] . '" ></div></td>';
// start and end third to sixth columns. end sixth row
    echo '<td></td><td></td><td></td><td></td></tr>';
// start seventh row, start and first column
    echo '<tr><td></td>';
// start and end second column
    echo '<td class="boldText">' . _("Add to project") . '</td>';
// start and end third column
    echo '<td class="boldText">' . _("Quantity") . '</td>';

    $Echo = "SELECT projects_data_component_id FROM projects_data WHERE projects_data_component_id = ".(int)$_GET['edit']." ";
    $sql_echo = mysqli_query($connection,$Echo);
// If there are no projects, start and end fourth to sixth columns
    if (mysqli_num_rows($sql_echo) == 0) {
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
    }
// There are projects
    else {
        echo '<td class="boldText">' . _("Project") . '</td>';
        echo '<td class="boldText">' . _("Quantity") . '</td>';
        echo '<td></td>';
    }
// end seventh row
    echo '</tr>';
// start eigth row, start and end first column
    echo '<tr><td></td>';
// start second column
    echo '<td><select name="project">';
    include "include/include_component_edit_project_add.php";
    $MenuProj = new AddMenuProj;
    $MenuProj->MenuProj();
// end select, end second column
    echo '</select></td>';
// start and end third column
    echo '<td><input name="projquant" type="text" class="small" value="';
    if(isset($_POST['submit'])) { 
        echo $_POST['projquant']; 
    }
    echo '" ></td>';
// start and end fourth column
    echo '<td>';
    include "include/include_component_edit_project_edit.php";
    $MenuProj = new EditProj;
    $MenuProj->MenuProj();
// NOTE!!!! In the include above there are <tr> and </tr> as well as <td> and </td>
// so this should not be added here! Took me a while to detect this
//start and end fifth to sixth columns. end eight row
//  echo '<td></td><td></td></tr>';
// end tbody and table
    echo '</tbody></table>';

    echo '<div class="buttons"><div class="input"><button class="button green" name="update" type="submit"><span class="fa  fa-save fa-lg"></span> ' . _("Update") . '</button> ';
    echo '<button class="button" name="based" type="submit"><span class="fa  fa-plus-square fa-lg"></span> ' . _("New based on this") . '</button> ';
    echo '<button class="button red" name="delete" type="submit"><span class="fa  fa-trash fa-lg"></span> ' . _("Delete") . '</button>';
    echo '</div></div></form></div>';
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo '</div></body></html>';
?>
