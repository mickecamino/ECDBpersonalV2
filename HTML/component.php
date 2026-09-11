<?php
// File: component.php
// Function: Show components
// Revision date: 2026-09-10
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "include/login/auth.php";
    include "include/mysql_connect.php";

    // Determine who is logged in and which parts belong to them
    $owner  =   $_SESSION['SESS_MEMBER_ID'];
    $id     =   (int)$_GET['view'];

    $GetDataComponent = mysqli_query($connection,"SELECT * FROM data WHERE id = ".$id." AND owner = ".$owner."");
    $executesql = mysqli_fetch_assoc($GetDataComponent);

    $GetPersonal = mysqli_query($connection,"SELECT currency FROM members WHERE member_id = ".$owner."");
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
?>
    <body>
        <div id="wrapper">
            <!-- Header -->
                <?php include "include/header.php"; ?>
            <!-- END -->
            <!-- Main menu -->
                <?php include "include/menu.php"; ?>
            <!-- END -->
            <!-- Main content -->
            <div id="content">
                <h2>
                <a href="category.php?cat=
                    <?php
                        echo $executesql_head_catname['id'];
                        echo '"> ';
                        echo gettext($executesql_head_catname['name']);
                        echo '</a> / ';

                        echo '<a href="category.php?subcat=';
                        echo $executesql_sub_catname['id'];
                        echo '"> ';
                        echo gettext($executesql_sub_catname['name']);
                    ?>
                </a>  <?php echo $executesql['name']; ?>
                </h2>

                <div class="aboutComponentHeader">
                    <div class="componentGallery">
                        <div class="bigImage">
                            <?php
                                if ($executesql['cimage'] == "") {
                                    echo '<div class="componentNoImg">';
                                    echo _("No Image");
                                    echo '</div>';
                                }
                                else {
                                    echo '<a href="img/parts/';
                                    echo $executesql['cimage'];
                                    echo '" target="_blank"><img src="img/parts/';
                                    echo $executesql['cimage'];
                                    echo '" alt=""></a>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="componentComment">
                        <?php echo nl2br($executesql['comment']); ?>
                    </div>
                </div>

                <div class="componentInfo">
                    <table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <?php echo '<td class="boldText">' . _("Location") . '</td>';?>
                                <td>
                                    <?php
                                        if ($executesql['location'] == "") {
                                            echo "-";
                                        }
                                        else {
                                            echo $executesql['location'];
                                        }
                                    ?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <?php echo '<td class="boldText">' . _("Quantity") . '</td>';
                                echo '<td>';
                                        if ($executesql['quantity'] == 0) {
                                            echo "-";
                                        }
                                        else {
                                            echo $executesql['quantity'];
                                        }
                                    ?>
                                    <form class="globalForms inLine" method="post" action="">
                                        <button class="button white small" name="quantity_increase" type="submit"><span class="fa fa-plus-square fa-lg"></span></button>
                                        <button class="button white small" name="quantity_decrease" type="submit"><span class="fa fa-minus-square fa-lg"></span></button>
                                    </form>
                                </td>
                                <?php echo '<td class="boldText">' . _("Price") . '</td>';
                                echo '<td>';
                                        if ($executesql['price'] == "") {
                                            echo "-";
                                        }
                                        else {
                                            echo $executesql['price'];
                                            echo ' ';
                                            echo $personal['currency'];
                                        }
                                    ?>
                                </td>
                                <?php echo '<td class="boldText">' . _("Order quantity") . '</td>';
                                echo '<td>';
                                        if ($executesql['order_quantity'] == 0) {
                                            echo "0";
                                        }
                                        else {
                                            echo $executesql['order_quantity'];
                                        }
                                    ?>
                                    <form class="globalForms inLine" method="post" action="">
                                        <button class="button white small" name="orderquant_increase" type="submit"><span class="fa fa-plus-square fa-lg"></span></button>
                                        <button class="button white small" name="orderquant_decrease" type="submit"><span class="fa fa-minus-square fa-lg"></span></button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <?php echo '<td class="boldText">' . _("Manufacturer") . '</td>';
                                echo '<td>';
                                        if ($executesql['manufacturer'] == "") {
                                            echo "-";
                                        }
                                        else {
                                            echo $executesql['manufacturer'];
                                        }
                                echo '</td>';
                                echo '<td class="boldText">' . _("Package") . '</td>';
                                echo '<td>';
                                        if ($executesql['package'] == "") {
                                            echo "-";
                                        }
                                        else {
                                            echo $executesql['package'];
                                        }
                                echo '</td>';
                                echo '<td class="boldText">' . _("Pins") . '</td>';
                                echo '<td>';
                                        if ($executesql['pins'] == 0) {
                                            echo "-";
                                        }
                                        else {
                                            echo $executesql['pins'];
                                        }
                                echo '</td>';
                                echo '</tr><tr>';
                                echo '<td class="boldText">' . _("Recycled") . '</td>';
                                echo '<td>';
                                        if ($executesql['scrap'] == "Yes") {
                                            echo '<span class="fa fa-check-square-o fa-lg"></span>';
                                        }
                                        else {
                                            echo '<span class="fa fa-square-o fa-lg"></span>';
                                        }
                                echo '</td>';
//                              4 Empty blocks
                                echo '<td></td><td></td><td></td><td></td>';
                                echo '</tr><tr>';
                                echo '<td class="boldText">' . _("Datasheet") . '</td>';
                                echo '<td>'; 
                                        if ($executesql['datasheet'] == "") {
                                            echo "-";
                                        }
                                        else {
                                            echo '<a href="sheets/';
                                            echo $executesql['datasheet'];
                                            echo '" target="_blank"><span class="fa fa-file-pdf-o fa-lg"></a>'; 
                                        }
                                echo '</td>';
                                echo '<td class="boldText">' . _("Application Note") . '</td>';
                                echo '<td>';
                                        if ($executesql['appnote'] == "") {
                                            echo "-";
                                        }
                                        else {
                                            echo '<a href="appnotes/';
                                            echo $executesql['appnote'];
                                            echo '" target="_blank"><span class="fa fa-file-pdf-o fa-lg"></a>';
                                        }
                                    ?>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <form class="globalForms noPadding" method="post" action="">
                    <div class="buttons">
                        <div class="input">
                            <?php
                            echo '<button class="button" name="edit" type="submit"><span class=" fa fa-pencil fa-lg"></span> ' . _(" Edit Component") . '</button> ';
                            echo '<button class="button" name="based" type="submit"><span class="fa fa-plus-square fa-lg"></span> ' . _(" New based on this") . '</button> ';
                            echo '<button class="button red" name="delete" type="submit"><span class="fa fa-trash fa-lg"></span> ' . _(" Delete component") . '</button> ';
                            ?>
                        </div>
                    </div>
                </form>

            </div>
            <!-- END -->
            <!-- Text outside the main content -->
                    <?php include "include/footer.php"; ?>
            <!-- END -->
        </div>
    </body>
</html>
