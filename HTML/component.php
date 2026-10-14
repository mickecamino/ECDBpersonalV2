<?php
// File: component.php
// Function: Show components
// Revision date: 2026-10-14
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "include/login/auth.php";
    include "include/mysql_connect.php";
    include "include/include_format_currency.php"; // Currency formatter

    // Determine who is logged in and which parts belong to them
    $owner  =   $_SESSION['SESS_MEMBER_ID'];
    $id     =   (int)$_GET['view'];

    $GetDataComponent = mysqli_query($connection,"SELECT * FROM data WHERE id = ".$id." AND owner = ".$owner."");
    $executesql = mysqli_fetch_assoc($GetDataComponent);

// Search if the component has a project connected to it
    $SqlQuery = "SELECT project_name, project_id, projects_data_quantity FROM projects_data, projects WHERE project_id = projects_data_project_id AND projects_data_component_id = ".$id." AND project_owner = ".$owner." GROUP BY projects_data_project_id";

    $GetProjects = mysqli_query($connection,$SqlQuery); // Execute
    $numrows = mysqli_num_rows($GetProjects); // Get number of rows, if any

// Get users currency
    $GetPersonal = mysqli_query($connection,"SELECT currency, language FROM members WHERE member_id = ".$owner."");
    $personal = mysqli_fetch_assoc($GetPersonal);

    if ($executesql['owner'] !== $owner) {
        header("Location: error.php?id=1");
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

    if(isset($_POST['edit'])) {
        header("Location: component_edit.php?edit=$id");
    }

    if(isset($_POST['delete'])) {
        $sqlDeleteComponent = "DELETE FROM data WHERE id = ".$id." ";
        $sql_exec_component_delete = mysqli_query($connection,$sqlDeleteComponent);

        $sqlDeleteProject = "DELETE FROM projects_data WHERE projects_data_component_id = '$id'";
        $sql_exec_project_delete = mysqli_query($connection,$sqlDeleteProject);

        header("Location: .");
    }

    if (isset($_POST['based'])) {
        header("Location: add_based.php?based=$id");
    }

    if (isset($_POST['quantity_increase'])) {
        $quantity_before    =   $executesql['quantity'];
        $quantity_after     =   $quantity_before + 1;

        $sql = "UPDATE data SET quantity = '".$quantity_after."' WHERE id = ".$id." ";
        $sql_exec = mysqli_query($connection,$sql);
        header("location: " . $_SERVER['REQUEST_URI']);
    }

    if (isset($_POST['quantity_decrease'])) {
        $quantity_before    =   $executesql['quantity'];
        $quantity_after     =   $quantity_before - 1;

        $sql = "UPDATE data SET quantity = '".$quantity_after."' WHERE id = ".$id." ";
        $sql_exec = mysqli_query($connection,$sql);
        header("location: " . $_SERVER['REQUEST_URI']);
    }

    if (isset($_POST['orderquant_increase'])) {
        $quantity_before    =   $executesql['order_quantity'];
        $quantity_after     =   $quantity_before + 1;

        $sql = "UPDATE data SET order_quantity = '".$quantity_after."' WHERE id = ".$id." ";
        $sql_exec = mysqli_query($connection,$sql);
        header("location: " . $_SERVER['REQUEST_URI']);
    }

    if (isset($_POST['orderquant_decrease'])) {
        $quantity_before    =   $executesql['order_quantity'];
        $quantity_after     =   $quantity_before - 1;

        $sql = "UPDATE data SET order_quantity = '".$quantity_after."' WHERE id = ".$id." ";
        $sql_exec = mysqli_query($connection,$sql);
        header("location: " . $_SERVER['REQUEST_URI']);
    }

    // Custom Page Titles
    $pageTitle = _("View component");
    // Hidden Search title for search dialogue
    // pageTitle did not work when localized, see header.php
    $searchTitle = "View component";

    include "include/head.php";

    echo '<body><div id="wrapper">';
    // Header
    include "include/header.php";
    // END
    // Main menu
    include "include/menu.php";
    // END
    // Main content
    echo '<div id="content">';
    echo '<h2>';
    echo '<a href="category.php?cat=';
    echo $executesql_head_catname['id'];
    echo '"> ';
    echo gettext($executesql_head_catname['name']);
    echo '</a> / ';

    echo '<a href="category.php?subcat=';
    echo $executesql_sub_catname['id'];
    echo '"> ';
    echo gettext($executesql_sub_catname['name']);
    echo '</a>';
    echo $executesql['name'];
    echo '</h2>';

    echo '<div class="aboutComponentHeader">';
    echo '<div class="componentGallery">';
    echo '<div class="bigImage">';
    if ($executesql['cimage'] == "") {
        echo '<div class="componentNoImg">';
        echo _("No Image");
        echo '</div>';
    } else {
        echo '<a href="img/parts/';
        echo $executesql['cimage'];
        echo '" target="_blank"><img src="img/parts/';
        echo $executesql['cimage'];
        echo '" alt=""></a>';
    }
    echo '</div></div>';
    echo '<div class="componentComment">';
    echo nl2br($executesql['comment']);
    echo '</div></div>';
    echo '<div class="componentInfo">';
    echo '<table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0">';
    echo '<tbody>';
        echo '<tr>'; // First row
        echo '<td class="boldText">' . _("Name") . '</td>'; // start and end first column
        echo '<td>'; // start second column
        echo $executesql['name'];
        echo '</td>'; // end second column
        echo '<td class="boldText">' . _("Category") . '</td>'; // start and end third column
        echo '<td>'; // start fourth column
        echo gettext($executesql_sub_catname['name']);
        echo '</td>'; // end fourth column
        echo '<td class="boldText">' . _("Quantity") . '</td>'; // start and end fifth column
        echo '<td>'; // start sixth column
        if ($executesql['quantity'] == 0) {
            echo "0";
        } else {
            echo $executesql['quantity'];
        }
        echo '&nbsp;';
        echo '<form class="globalForms inLine" method="post" action=""> ';
        echo '<button class="button green small" name="quantity_increase" type="submit"><span class="far fa-plus-square fa-lg"></span></button>';
        echo '<button class="button red small" name="quantity_decrease" type="submit"><span class="far fa-minus-square fa-lg"></span></button>';
        echo '</form></td>'; // end sixth column
        echo '</tr>'; // end first row
        echo '<tr>'; // Second row
        echo '<td class="boldText">' . _("Manufacturer") . '</td>'; // start and end first column
        echo '<td>'; // start second column
        if ($executesql['manufacturer'] == "") {
            echo "-";
        } else {
            echo $executesql['manufacturer'];
        }
        echo '</td>'; // end second column
        echo '<td class="boldText">' . _("Package") . '</td>'; // start and end third column
        echo '<td>'; // start fourth column
        if ($executesql['package'] == "") {
            echo "-";
        } else {
            echo $executesql['package'];
        }
        echo '</td>'; // end fourth column
        echo '<td class="boldText">' . _("Pins") . '</td>'; // start and end fifth column
        echo '<td>'; // start sixth column
        if ($executesql['pins'] == 0) {
            echo "-";
        } else {
            echo $executesql['pins'];
        }
        echo '</td>'; // end sixth column
        echo '</tr>'; // end second row
        echo '<tr>';  // start third row
        echo '<td class="boldText">' . _("Location") . '</td>'; // start and end first column
        echo '<td>'; // start second column
        if ($executesql['location'] == "") {
            echo "-";
        } else {
            echo $executesql['location'];
        }
        echo '</td>'; // end second column
        echo '<td class="boldText">' . _("Price") . '</td>'; // start and end third column
        echo '<td>'; // start fourth column
        if ($executesql['price'] == "" || $executesql['price'] == "0") {
            $price = 0; 
        } else {
            $price = $executesql['price'];
        }
        echo format_currency($personal['language'],$personal['currency'], $price);
        echo '</td>'; // end fourth column
        echo '<td class="boldText">' . _("Order quantity") . '</td>'; // start and end fifth column
        echo '<td>'; // start sixth column
        if ($executesql['order_quantity'] == 0) {
            echo "0";
        } else {
            echo $executesql['order_quantity'];
        }
        echo '&nbsp;';
        echo '<form class="globalForms inLine" method="post" action="">';
        echo '<button class="button green small" name="orderquant_increase" type="submit"><span class="far fa-plus-square fa-lg"></span></button>';
        echo '<button class="button red small" name="orderquant_decrease" type="submit"><span class="far fa-minus-square fa-lg"></span></button>';
        echo '</form></td>'; // end sixth column
        echo '</tr><tr>'; // end third row, start fourth row
        echo '<td class="boldText">' . _("Recycled") . '</td>'; // start and end first column
        echo '<td>'; // start second column
        if ($executesql['scrap'] == "Yes") {
            echo '<span class="far fa-check-square fa-lg"></span>';
        } else {
            echo '<span class="far fa-square fa-lg"></span>';
        }
        echo '</td>'; // end second column
        echo '<td></td><td></td><td></td><td></td>'; // start and end third to sixth column
        echo '</tr><tr>'; // end fourth row, start fifth row
        echo '<td class="boldText">' . _("Datasheet") . '</td>'; // start and end first column
        echo '<td>'; // start second column
        if ($executesql['datasheet'] == "") {
            echo "-";
        } else {
            echo '<a href="sheets/';
            echo $executesql['datasheet'];
            echo '" target="_blank"><span class="far fa-file-pdf fa-lg"></a>';
        }
        echo '</td>'; // end second column
        echo '<td class="boldText">' . _("Application Note") . '</td>'; // start and end third column
        echo '<td>'; // start fourth column
        if ($executesql['appnote'] == "") {
            echo "-";
        } else {
            echo '<a href="appnotes/';
            echo $executesql['appnote'];
            echo '" target="_blank"><span class="far fa-file-pdf fa-lg"></a>';
        }
        echo '</td>'; // end fourth column

// Show all projects where the component is added to, with hyperlink
        if( $numrows > 0 ) {
            echo '<td class="boldText">' . _("Included in project") . '</td>'; // start and end fifth column
            echo '<td class="boldText">' ._("Quantity") . '</td>'; // start and end sixth column
            while ($projectsql = mysqli_fetch_assoc($GetProjects)) {
                echo '<tr>'; // start sixth row
                echo '<td></td><td></td><td></td><td></td>'; // start and end first to fourth column
                echo '<td>'; // start fifth column
                echo '<a href="proj_show.php?proj_id=';
                echo $projectsql['project_id'];
                echo '">';
                echo $projectsql['project_name'];
                echo '</a>';
                echo '</td><td>'; // end fifth column start sixth column
                echo $projectsql['projects_data_quantity'];
                echo '</td></tr>'; // end sixth column end sixth row, and so on
            }
        } else {
            echo '<td></td>'; // start and end fifth column
            echo '<td></td>'; // start and end sixth column
            echo '</tr>'; // end fifth row
        }

    echo '</tbody></table></div>';
    echo '<form class="globalForms noPadding" method="post" action="">';
    echo '<div class="buttons">';
    echo '<div class="input">';
        echo '<button class="button" name="edit" type="submit"><span class=" fas fa-pencil-alt fa-lg"></span> ' . _(" Edit Component") . '</button> ';
        echo '<button class="button" name="based" type="submit"><span class="fas fa-plus-square fa-lg"></span> ' . _(" New based on this") . '</button> ';
        echo '<button class="button red" name="delete" type="submit"><span class="far fa-trash-alt fa-lg"></span> ' . _(" Delete component") . '</button> ';
    echo '</div></div></form></div>';
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo '</div></body></html>';
?>
