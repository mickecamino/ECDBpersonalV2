<?php
// File: include_shoplist_sum.php
// Function: Sums the cost for a shopping lists
// Revision date: 2026-09-16
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//

class ShoplistPrice {
    public function ShoplistPriceSum() {

    require_once "login/auth.php";
    include "mysql_connect.php";

    $owner = $_SESSION['SESS_MEMBER_ID'];
    $GetPersonal = mysqli_query($connection,"SELECT currency FROM members WHERE member_id = ".$owner."");
    $personal = mysqli_fetch_assoc($GetPersonal);

    $GetDataComponentsAll = "SELECT price,order_quantity FROM data WHERE owner = ".$owner." AND order_quantity > 0 ORDER by name ASC";

    $sql_exec = mysqli_Query($connection,$GetDataComponentsAll);
        while($showDetails = mysqli_fetch_array($sql_exec)) {
            $price = $showDetails['price'];
            (int)$quantity = $showDetails['order_quantity']; // quantity is now an integer

            $product =  (float)$price * $quantity; // so we have to casr $price as a float
            $sum[] = $product;

        }
        if (isset($sum)) {
            if($personal['currency'] == "£" || $personal['currency'] == "$") {
                echo $personal['currency'];
            }
            echo number_format(array_sum($sum), 2, ',', ' ');
            if($personal['currency'] == "kr" || $personal['currency'] == "€") {
                echo ' ';
                echo $personal['currency'];
            }
        }
        else {
            if($personal['currency'] == "£" || $personal['currency'] == "$") {
                echo '0';
            }
            if($personal['currency'] == "kr" || $personal['currency'] == "€") {
                echo '0 ';
                echo $personal['currency'];
            }
        }
    }
}
?>
