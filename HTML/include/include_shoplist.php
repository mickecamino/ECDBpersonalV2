<?php
// File: include/include_shoplist.php
// Function: print out the shoppinglist
// Revision date: 2026-09-16
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
class Shoplist {
    public function ShoplistList() {

        require_once "login/auth.php";
        include "mysql_connect.php";
        include "include/include_format_currency.php";

        $owner = $_SESSION['SESS_MEMBER_ID'];
        $GetPersonal = mysqli_query($connection,"SELECT currency, language FROM members WHERE member_id = ".$owner."");
        $personal = mysqli_fetch_assoc($GetPersonal);

        if(isset($_GET['by'])) {

            $by = $_GET["by"];
            $order = $_GET["order"];

            $bysql = mysqli_real_escape_string($connection,$by);
            $ordersql = mysqli_real_escape_string($connection,$order);

            if($by == 'price' or $by == 'quantity') {

                $GetDataComponentsAll = "SELECT id, name, manufacturer, package, price, quantity, order_quantity, comment FROM data WHERE owner = ".$owner." AND order_quantity > 0 ORDER by ".$bysql." +0 ".$ordersql."";
            }
            else {

                $GetDataComponentsAll = "SELECT id, name, manufacturer, package, price, quantity, order_quantity, comment FROM data WHERE owner = ".$owner." AND order_quantity > 0 ORDER by ".$bysql." ".$ordersql."";
            }
        }
        else {
            $GetDataComponentsAll = "SELECT id, name, manufacturer, package, price, quantity, order_quantity, comment FROM data WHERE owner = ".$owner." AND order_quantity > 0 ORDER by name ASC";
        }
        $sql_exec = mysqli_Query($connection,$GetDataComponentsAll);
        $numrows = mysqli_num_rows($sql_exec);
        if ($numrows != 0) {
            while($showDetails = mysqli_fetch_array($sql_exec)) {
                echo "<tr>";

                echo '<td class="edit"><a href="component_edit.php?edit=';
                echo $showDetails['id'];
                echo '"><span class="fas fa-pencil-alt fa-lg"></span></a></td>';

                echo '<td><a href="component.php?view=';
                echo $showDetails['id'];
                echo '">';

                echo $showDetails['name'];
                echo "</a></td>";

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
                if ($showDetails['price'] == "" || $showDetails['price'] == "0") {
                    $price = "0";
                } else {
                    $price = $showDetails['price'];
                }
                echo format_currency($personal['language'],$personal['currency'], $price) ;
                echo "</td>";

                echo "<td>";
                $quantity = $showDetails['quantity'];
                    if ($quantity == 0){
                        echo "-";
                    }
                    else{
                        echo $quantity;
                    }
                echo "</td>";

                echo "<td>";
                $order_quantity = $showDetails['order_quantity'];
                    if ($order_quantity == 0){
                        echo "-";
                    }
                    else{
                        echo $order_quantity;
                    }
                echo "</td>";

                $comment = $showDetails['comment'];
                if ($comment==""){
                    echo '<td class="comment"><div>';
                    echo "-";
                    echo '</div></td>';
                }
                else{
                    echo '<td class="comment"><div><span class="far fa-comment-dots fa-lg"></span><span class="comment">';
                    echo $showDetails['comment'];
                    echo '</span></div></td>';
                }
            } // end while
        } else {
            echo _("No shopping list created") . "<br>";
        }
    }
}
?>
