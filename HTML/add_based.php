<?php
// File: add_based.php
// Function: Add component based on existing component
// Revision date: 2026-09-18
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
require_once "include/login/auth.php";
include "include/mysql_connect.php";
require_once "include/debug.php";

$owner = $_SESSION['SESS_MEMBER_ID'];
$id    = (int) $_GET['based'];

// Get data from the old component to inherit.
$GetDataComponent = mysqli_query($connection, "SELECT * FROM data WHERE id = " . $id . " AND owner = " . $owner . "");
$executesql       = mysqli_fetch_assoc($GetDataComponent);

// If the owner of component !== $owner. Show error.
if ($executesql['owner'] !== $owner)
    {
    header("Location: error.php?id=2");
    } //$executesql['owner'] !== $owner

// Get the head category ID, based of the sub category, ($executesql['category']).
if ($executesql['category'] < 999)
    {
    $head_cat_id = substr($executesql['category'], -3, 1);
    } //$executesql['category'] < 999
else
    {
    $head_cat_id = substr($executesql['category'], -4, 2);
    }

// Get the head category name, based of the head category ID.
$GetHeadCatName          = mysqli_query($connection, "SELECT * FROM category_head WHERE id = " . $head_cat_id . "");
$executesql_head_catname = mysqli_fetch_assoc($GetHeadCatName);

// Sub category == $sub_cat_id
$sub_cat_id = $executesql['category'];

// Get the sub category name, based of the sub category ID.
$GetSubCatName          = mysqli_query($connection, "SELECT * FROM category_sub WHERE id = " . $sub_cat_id . "");
$executesql_sub_catname = mysqli_fetch_assoc($GetSubCatName);

// Get ALL the sub categories.
$GetDataComponentsAll = "SELECT * FROM category_sub";
$sql_exec             = mysqli_Query($connection, $GetDataComponentsAll);
// Custom Page Titles
$pageTitle = _("Add component");
include "include/head.php";

    echo '<body><div id="wrapper">';
// Header
    include "include/header.php";
// END
// Main menu
    include "include/menu.php";
// END
// Main content
    echo '<div id="content"><h1>' . _("Add new component based on ") . '<a href="component.php?view=';
    echo $executesql['id'] . '">';
    echo $executesql['name'] . '</a></h1>';
    include "include/include.php";
    $Add = new ShowComponents;
    $Add->Add();

    echo '<form class="globalForms noPadding" action="" method="post"><div class="textBoxInput"><label class="keyWord boldText">' . _("Comment") . '</label>';
    echo '<div class="text"><textarea name="comment" rows="4">' . $executesql['comment'] . '</textarea></div></div>';
    echo '<table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0"><tbody>'; // start table
    echo '<tr><td class="boldText">' . _("Name") . '</td>'; // First row, first column
    echo '<td><input name="name" class="medium" type="text" value="' . $executesql['name'] . '" id="name" /></td>'; // second column
    echo '<td class="boldText">' . _("Category") . '</td>'; // third column
    echo '<td><select name="category">'; // start fourth column
//=======================================================================
    $HeadCategoryNameQuery = "SELECT * FROM category_head ORDER by name ASC";
    $sql_exec_headcat      = mysqli_Query($connection, $HeadCategoryNameQuery);

    while ($HeadCategory = mysqli_fetch_array($sql_exec_headcat))
        {
        echo '<option class="main_category" value="';
        echo $HeadCategory['id'];
        echo '" disabled>';
        echo $HeadCategory['name'];
        echo '</option>';

        $subcatfrom = $HeadCategory['id'] * 100;
        $subcatto   = $subcatfrom + 99;

        $SubCategoryNameQuery = "SELECT * FROM category_sub WHERE id BETWEEN " . $subcatfrom . " AND " . $subcatto . " ORDER by name ASC";
        $sql_exec_subcat      = mysqli_Query($connection, $SubCategoryNameQuery);

        while ($SubCategory = mysqli_fetch_array($sql_exec_subcat))
            {
            echo '<option value="';
            echo $SubCategory['id'];
            echo '"';
            if ($executesql_sub_catname['id'] == $SubCategory['id'])
                {
                echo ' selected';
                } // end if - $executesql_sub_catname['id'] == $SubCategory['id']
            echo '>';
            echo $SubCategory['name'];
            echo '</option>';
        } // end while - $SubCategory = mysqli_fetch_array($sql_exec_subcat)
    } // end while - $HeadCategory = mysqli_fetch_array($sql_exec_headcat)

    echo '</select></td>'; // end select, end fourth column
    echo '<td class="boldText">' . _("Quantity") . '</td>'; // fifth column
    echo '<td><input name="quantity" type="text" class="small" value="' . $executesql['quantity'] . '" id="quantity" /></td></tr>'; // sixth column, end first row
    echo '<tr><td class="boldText">' . _("Manufacturer") . '</td>'; // second row, first column
    echo '<td><div class="ui-widget"><input id="manufacturer" name="manufacturer"  type="text" value="' . $executesql['manufacturer'] . '" /></div></td>'; // second column
    echo '<td class="boldText">' . _("Package") . '</td>'; // third column
    echo '<td><div class="ui-widget"><input id="package" name="package"  type="text" value="' . $executesql['package'] . '" /></div></td>'; // fourth column
    echo '<td class="boldText">' . _("Pins") . '</td>'; // fifth column
    echo '<td><input name="pins" type="text" class="small" value="' . $executesql['pins'] . '" /></td></tr>'; // sixth column, end second row
    echo '<tr><td class="boldText">' . _("Location") . '</td>'; // third row, first column
    echo '<td><div class="ui-widget"><input id="location" name="location" type="text"  value="' . $executesql['location'] . '" /></div></td>'; // second column
    echo '<td class="boldText">' . _("Price") . '</td>'; // third column
    echo '<td><input name="price" type="text" class="small" value="' . $executesql['price'] . '" id="price" /></td>'; // fourth column
    echo '<td class="boldText">' . _("To order") . '</td>'; // fifth column
    echo '<td><input name="orderquant" type="text" class="small" value="' . $executesql['order_quantity'] . '" id="orderquant" /></td></tr>'; // sixth column, end third row
    echo '<tr><td class="boldText">' . _("Recycled") . '</td>'; // start fourth row, first column
    echo '<td>'; // start second column
    if ($executesql['scrap'] == 'Yes')
        {
        echo '<input type="radio" name="scrap" value="Yes" checked="checked" /> ' . _("Yes");
        echo ' <input type="radio" name="scrap" value="No" /> ' . _("No");
    } //$executesql['scrap'] == 'Yes'
    else
        {
        echo '<input type="radio" name="scrap" value="Yes" /> ' . _("Yes");
        echo ' <input type="radio" name="scrap" value="No" checked="checked" /> ' . _("No");
        }
    echo '</td>'; // end second column
    echo '<td></td><td></td><td></td><td></td></tr>'; // third, fourt, fifth and sixth column, end fourth row
    echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>'; // fifth row, first to sixth column
    echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>'; // sixth row, first to sixth column
    echo '<tr><td class="boldText">' . _("Datasheet") . '</td>'; // start seventh row, first column
    echo '<td><div class="ui-widget"><input id = "datasheet" name="datasheet" type="text"  value="' . $executesql['datasheet'] . '" /></div></td>'; // second column
    echo '<td class="boldText">' . _("Image") . '</td>'; // third column
    echo '<td><div class="ui-widget"><input id="images" name="cimage" type="text" class="medium" value="' . $executesql['cimage'] . '" /></div></td>'; // fourth column
    echo '<td></td><td></td></tr>'; // fifth and sixth column, end seventh row
    echo '<tr><td class="boldText">' . _("Application Note") . '</td>'; // start eight row, first column
    echo '<td><div class="ui-widget"><input id = "appnote" name="appnote" type="text"  value="' . $executesql['appnote'] . '" /></div></td>'; // second column
    echo '<td></td><td></td><td></td><td></td></tr>'; // third to sixth column, end eight row
// Don't display Add to project if there are no project(s)
    $projects_qry = "SELECT project_id FROM projects WHERE project_owner = $owner";
    $projects_res = mysqli_query($connection,$projects_qry);
    $numrows = mysqli_num_rows($projects_res);
// If there are no projects, skip sektion for project display
    if ($numrows > 0) {
    echo '<tr><td></td>'; // start ninth row, first column
    echo '<td class="boldText">' . _("Add component to project") . '</td>'; // second column
    echo '<td class="boldText">' . _("Quantity") . '</td>'; // third column
    echo '<td></td><td></td><td></td></tr>'; // fourth to sixth column, end row nine
    echo '<tr><td></td>'; // start tenth row, first colum
    echo '<td><select name="project">'; // start second column

    include "include/include_component_add_project.php";
    $MenuProj = new AddMenuProj;
    $MenuProj->MenuProj();

    echo '</select></td>'; // end second column
    echo '<td><input name="projquant" type="text" class="small" value="'; // start third colum
    if (isset($_POST['submit']))
        {
        echo $_POST['projquant'];
        } //isset($_POST['submit'])
    echo '" /></td>'; // end third column
    echo '<td></td><td></td><td></td></tr>'; // fourth to sixth column, end tenth row
    } // end if numrows
    echo '</tbody></table>'; // end table
    echo '<div class="buttons"><div class="input"><button class="button green" name="submit" type="submit"><span class="far fa-save fa-lg"></span> ' . _("Save") . '</button>';
    echo '</div></div></form></div>'; // end divs and form
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo "</div></body></html>";
?>

