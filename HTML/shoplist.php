<?php
// File: shoplist.php
// Function: Show the shopping list
// Revision date: 2026-09-14
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "include/login/auth.php";
    require_once "include/debug.php";
    include "include/mysql_connect.php";

 // Custom Page Titles
 $pageTitle = _("Shopping List");
 include "include/head.php";
    echo '<body>';
    echo '<div id="wrapper">';
// Header
    include "include/header.php";
// END
// Main menu
    include "include/menu.php";
// END
// Main content


    $GetShoppingList = "SELECT order_quantity FROM data WHERE owner = ".$owner." AND order_quantity > 0";
    $sql_exec = mysqli_Query($connection,$GetShoppingList);
    $numrows = mysqli_num_rows($sql_exec);

    if( $numrows != 0 ) {
        echo '<div id="content">';
        echo '<table class="globalTables" cellpadding="0" cellspacing="0">';
        echo '<thead>';
        echo '<tr><th></th>';
        echo '<th><a href="?by=name&order=';
                if(isset($_GET['order']))
                    {
                    $order = $_GET['order'];
                    if ($order == 'asc'){
                        echo 'desc';
                        }
                    else {
                        echo 'asc';
                        }
                    }
                    else {
                        echo 'desc';
                        }
                echo '">';
                echo _("Name") . '</a>';
        echo '</th>';
        echo '<th><a href="?by=manufacturer&order=';
                if(isset($_GET['order']))
                    {
                    $order = $_GET['order'];
                    if ($order == 'asc'){
                        echo 'desc';
                        }
                    else {
                        echo 'asc';
                        }
                    }
                    else {
                        echo 'asc';
                        }
                    echo '">';
                    echo _("Manufacturer") . '</a>';
        echo '</th><th><a href="?by=package&order=';
                if(isset($_GET['order']))
                    {
                    $order = $_GET['order'];
                    if ($order == 'asc'){
                        echo 'desc';
                        }
                    else {
                        echo 'asc';
                        }
                    }
                    else {
                        echo 'asc';
                        }
                    echo '">';
                    echo _("Package") . '</a>';
        echo '</th><th><a href="?by=price&order=';
                if(isset($_GET['order']))
                    {
                    $order = $_GET['order'];
                    if ($order == 'asc'){
                        echo 'desc';
                        }
                    else {
                        echo 'asc';
                        }
                    }
                    else {
                        echo 'asc';
                        }
                    echo '">';
                    echo _("Price") . '</a>';
        echo '</th><th><a href="?by=quantity&order=';
                if(isset($_GET['order']))
                    {
                    $order = $_GET['order'];
                    if ($order == 'asc'){
                        echo 'desc';
                        }
                    else {
                        echo 'asc';
                        }
                    }
                    else {
                        echo 'asc';
                        }
                    echo '">';
                    echo _("Quantity") . '</a>';
        echo '</th><th><a href="?by=quantity_order&order=';
                if(isset($_GET['quantity_order']))
                    {
                    $quantity_order = $_GET['quantity_order'];
                    if ($quantity_order == 'asc'){
                        echo 'desc';
                        }
                    else {
                        echo 'asc';
                        }
                    }
                    else {
                        echo 'asc';
                        }
                    echo '">';
                    echo _("Quantity to order") . '</a>';
        echo '</th><th>';
                    echo _("Comment");
        echo '</th></tr></thead>';
        echo '<tbody>';
        include "include/include_shoplist.php";
        $ShoplistList = new Shoplist;
        $ShoplistList->ShoplistList();
        echo '</tbody></table><div class="totalSumWrapper">';
        include "include/include_shoplist_sum.php";
        $ShoplistPriceSum = new ShoplistPrice;
        $ShoplistPriceSum->ShoplistPriceSum();
        echo "</div></div>";
    } else {
        echo '<div id="content">';
        echo _("No shopping list created") . "<br>";
        echo "</div>";
    }
        // END
        // Text outside the main content
        include "include/footer.php";
        // END
        echo "</div></body></html>";
?>
