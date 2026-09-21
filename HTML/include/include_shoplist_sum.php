<?php
// File: include_shoplist_sum.php
// Function: Sums the cost for a shopping lists
// Revision date: 2026-09-21
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//

class ShoplistPrice {
    public function ShoplistPriceSum() {

    require_once "login/auth.php";
    include "mysql_connect.php";

    $owner = $_SESSION['SESS_MEMBER_ID'];
    $GetPersonal = mysqli_query($connection,"SELECT currency, language FROM members WHERE member_id = ".$owner."");
    $personal = mysqli_fetch_assoc($GetPersonal);

    $GetDataComponentsAll = "SELECT price,order_quantity FROM data WHERE owner = ".$owner." AND order_quantity > 0 ORDER by name ASC";

    $sql_exec = mysqli_Query($connection,$GetDataComponentsAll);
        while($showDetails = mysqli_fetch_array($sql_exec)) {
            $price = $showDetails['price'];
            (int)$quantity = $showDetails['order_quantity']; // quantity is now an integer

            $product =  (float)$price * $quantity; // so we have to cast $price as a float
            $sum[] = $product;

        }
        $total = array_sum($sum); // Get the total
        if( $total == "" || $total == "0") {
            $price = "0";
        } else {
            $price = $total;
        }
        echo _("Total cost") . ": ";
        echo format_currency($personal['language'],$personal['currency'], $price) ;
    }
}
?>
