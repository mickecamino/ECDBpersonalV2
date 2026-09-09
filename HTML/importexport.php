<?php
// File: importexport.php
// Function: Export, import, add or delete components from the database
// Revision date: 2026-09-09
// Created by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "include/login/auth.php";
    include "include/mysql_connect.php";

    // Determine who is logged in and which parts belong to them
    $owner  =   $_SESSION['SESS_MEMBER_ID'];

// Custom Page Titles
    $pageTitle = _("Import/Export");

    include "include/head.php";

    echo '<body><div id="wrapper">';
// Header
    include "include/header.php";
// END
// Main menu
    include "include/menu.php";
// END
// Main content
    echo '<div id="content"><h3>' . _("Import / Export") . '</h3><p>';
    echo '<form class="globalForms noPadding" method="post" action="">';
        echo '<div class="buttons"><div class="input">';
        echo '<button class="button green" name="exportdata" type="submit"><span class="fa fa-file-export"></span> ' . _(" Export components") . '</button> ';
    echo '</div></div></form>';

    echo '<br><h1>' . _("File Import") . '</h1>';
    echo '<form action="importexport.php" method="post" enctype="multipart/form-data">';
    echo '<input type="file" class = "bold" name="file" id="file"><br>';
    echo '<input type="submit" value="Upload" name="submit">';
    echo '<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />';
    echo '</form>';

// END
    if(isset($_POST['exportdata'])) {
        $fname = "ecDBpersonal_components_" .  (string) date("Y-m-d_Hi") . ".csv";  // Note to myself, must use date_default_timezone_set for this towork
        $AllComponents = mysqli_fetch_all(mysqli_Query($connection,"SELECT * FROM `data` WHERE `owner` = " . $owner . " ORDER BY `id`"), MYSQLI_ASSOC);
        export_components( $AllComponents, $fname);
    }

    if(isset($_POST['submit'])) {
        $filename = $_FILES["file"]["tmp_name"];
        // Check if the file is a CSV file
        if (pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION) != "csv") {
            echo _("Please upload a CSV file.");
            exit;
        }
        // Proceed with importing the CSV file
        import_components($owner, $connection, $filename);
    }
// Text outside the main content
// No need for a footer on this page
//    include "include/footer.php";
// END
    echo "</div></div></body></html>";


function import_components($owner, $connection, $filename)
/********************************************************
* This module import entries into the data table.       *
* Three parameters:                                     *
* $owner - make sure that it is the current owner for   *
*          importing into the database                  *
* $connection - the SQL-connection                      *
* $filename   - the chosen file to import               *
* ******************************************************
*/
{
    if (($handle = fopen($filename, "r")) === FALSE)
    {
        echo _("Failed to open file:") . "[$file]\n";
        die;
    }
    $sqlqueryIsGoodToGo = false; // make sure that there are at least one field to update
    $row = 1;
    $headers=fgetcsv($handle, 1400, ";"); // read the header, we use it as key

    while (($csvdata = fgetcsv($handle, 1400, ";")) !== FALSE) // Loop through all records
    {
        if( count($headers) == count($csvdata)) { // If the header and the data contains the same number of ojects, then continue
            $data = array_combine($headers, $csvdata); // combine header with the data
            // Check the action
            switch ($data["action"]) { // What shall we do? add, edit or delete?
            case "add":
            case "edit": // We are here on add or edit component
                if (isset($data["id"]) && ctype_digit($data["id"])) { // Do we have a value? Is it an integer?
                    if (strlen($data["id"]) > 11) { // is it larger than whats accepted in the database?
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "id", "11" ); // Yes, print error, get next record
                        break;
                    } else
                        $id = $data["id"]; // id provided in the csv-file, get it and proceed
                        $GetDataComponent = mysqli_query($connection, "SELECT * FROM data WHERE id = " . $id . " AND owner = " . $owner . "");
                        $indatabase       = mysqli_fetch_assoc($GetDataComponent);
                        $sqlquery = "UPDATE `data` SET "; // start of UPDATE query
                } else {
                    echo sprintf(_("ERROR - %s must be defined"), "id"); // id is required
                    break;
                } // end else

                /*****************************************************************
                * We are here on add and edit
                *****************************************************************/
                if (isset($data["name"])) { // Do we have a value?
                    if (strlen($data["name"]) > 64) { // is it larger than whats accepted in the database?
                    echo sprintf(_("Error, %s to large, needs to be less than %s"), "name", "64" ); // Yes, print error, get next record
                    break;
                    } else {  // data not larger than 64
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["name"], $indatabase["name"]) <> 0) { // data differs
                                $sqlquery = " name = " . $data["name"] . ","; // add trailing comma
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp name
                        } // end if $data["action"] == "edit"
                    } // End else isset($data["name"])
                } else { // name not defined on add, report it
                    echo sprintf(_("ERROR - row %s - %s must be defined in the csv file"), $row, "name"); // name is required
                    break;
                }

                // If add, then compare with whats in the database to detect duplicates
                if($data["action"] == "add") {
                    $find = $data["name"];
                    $componentcategory = $data["category"]; // we must search with category as the same name can be in different categories
                    $SearchQuery = "SELECT name FROM category_sub WHERE id = " . $componentcategory; // get the category name
                    $sql_exec = mysqli_query($connection,$SearchQuery); // execute the search
                    $categoryname = mysqli_fetch_assoc($sql_exec);
                    $SearchQuery = "SELECT name FROM data WHERE name = '" . $find . "'  AND owner = '" . $owner . "' AND category = '" . $componentcategory . "'";
                    $sql_exec = mysqli_query($connection,$SearchQuery); // execute the search
                    $anymatches = mysqli_num_rows($sql_exec); // get number of matches
                    if ($anymatches > 0) { // we found a match
                        echo '<span style="color: red">';
                        echo sprintf(_("Component with name = '%s' and category %s is already in the database"), $find, $categoryname["name"]) . "<br>";
                        echo '</span>';
                        // echo that there is a duplicate
                        break; // Get next record
                    } else { // On add, if no match found, just add the component
                        $name = $data["name"]; // Everything is OK, save data and continue
                        $sqlquery = " name = " . $data["name"] . ","; // add trailing comma
                        $sqlqueryIsGoodToGo = true;
                    } // end else
                }
                if (isset($data["manufacturer"])) {
                    if (strlen($data["manufacturer"]) > 64) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "manufacturer", "64" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["manufacturer"], $indatabase["manufacturer"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " manufacturer = '" . $data["manufacturer"] . "',";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $manufacturer = $data["manufacturer"];
                } else {
                    $manufacturer = "";
                }
                if (isset($data["package"])) {
                    if (strlen($data["package"]) > 64) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "package", "64" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["package"], $indatabase["package"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " package = " . $data["package"] . "," ;
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $package = $data["package"];
                } else {
                    $package = "";
                }
                if (isset($data["pins"])) {
                    if (strlen($data["pins"]) > 11) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "pins", "11" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["pins"], $indatabase["pins"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " pins = " . $data["pins"] . ",";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $pins = $data["pins"];
                } else {
                    $pins = "";
                }
                if (isset($data["quantity"])) {
                    if (strlen($data["quantity"]) > 11) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "quantity", "11" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["quantity"], $indatabase["quantity"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " quantity = " . $data["quantity"] . ",";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $quantity = $data["quantity"];
                } else {
                    $quantity = "0";
                }
                if (isset($data["order_quantity"])) {
                    if (strlen($data["order_quantity"]) > 11) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "order_quantity", "11" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["order_quantity"], $indatabase["order_quantity"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " order_quantity = " . $data["order_quantity"] . ",";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $order_quantity = $data["order_quantity"];
                } else {
                    $order_quantity = "";
                }
                if (isset($data["location"])) {
                    if (strlen($data["location"]) > 32) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "location", "32" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["location"], $indatabase["location"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " location = " . $data["location"] . ",";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                         $location = $data["location"];
                } else {
                    $location = "";
                }
                if (isset($data["scrap"])) {
                    if (strlen($data["scrap"]) > 3) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "scrap", "3" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["scrap"], $indatabase["scrap"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " scrap = " . $data["scrap"] . ",";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $scrap = $data["scrap"];
                } else {
                    $scrap = "No";
                }
                if (isset($data["datasheet"])) {
                    if (strlen($data["datasheet"]) > 256) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "datasheetp", "256" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["datasheet"], $indatabase["datasheet"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " datasheet = " . $data["datasheet"] . ",";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $datasheet = $data["datasheet"];
                } else {
                    $datasheet = "";
                }
                if (isset($data["comment"])) {
                    if (strlen($data["comment"]) > 256) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "comment", "256" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["comment"], $indatabase["comment"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " comment = '" . $data["comment"] . "',";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $comment = $data["comment"];
                } else {
                    $comment = "";
                }
                if (isset($data["category"])) {
                    if (strlen($data["category"]) > 11) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "category", "11" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["category"], $indatabase["category"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " category = " . $data["category"] . ",";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $category = $data["category"];
                } else {
                    echo sprintf(_("ERROR - %s must be defined"), "category"); // name is required
                    break;
                }
                if (isset($data["cimage"])) {
                    if (strlen($data["cimage"]) > 256) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "cimage", "256" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["cimage"], $indatabase["cimage"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " cimage = " . $data["cimage"] . ",";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $cimage = $data["cimage"];
                } else {
                    $cimage = "";
                }
                if (isset($data["appnote"])) {
                    if (strlen($data["appnote"]) > 256) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "appnote", "256" ); // Yes, print error, get next record
                        echo "Error, appnote must be 256 characters or less";
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["appnote"], $indatabase["appnote"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " appnote = " . $data["appnote"] .",";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $appnote = $data["appnote"];
                } else {
                    $appnote = "";
                }
                if (isset($data["price"])) {
                    if (strlen($data["price"]) > 11) {
                        echo sprintf(_("Error, %s to large, needs to be less than %s"), "price", "11" ); // Yes, print error, get next record
                        break;
                    } else
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["price"], $indatabase["price"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . ", price = " . $data["price"] . ",";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $price = $data["price"];
                } else {
                    $price = "";
                }
                if ($data["action"] == "add") {
                    $sql="INSERT into data (owner, name, manufacturer, package, pins, quantity, location, scrap, datasheet, comment, category, cimage, appnote, price, order_quantity) VALUES   ('$owner', '$name', '$manufacturer', '$package', '$pins', '$quantity', '$location', '$scrap', '$datasheet', '$comment', '$category', '$cimage', '$appnote' ,'$price',     '$order_quantity')";
                    $result = @mysqli_query($connection,$sql);
                    echo '<span style="color: green">';
                    echo sprintf(_("Row %s with name %s and category %s imported"), $row, $name, $categoryname["name"]) . "<br>";
                    echo '<span>';
                }
                elseif ($data["action"] == "edit") {
                    $sqlquery = substr($sqlquery, 0, -1); // Get rid of the last comma:
                    $sqlquery = $sqlquery . " WHERE `id` = $id;";
                    if($sqlqueryIsGoodToGo) {
                        $sql_exec = mysqli_query($connection,$sqlquery);
                        echo '<span style="color: green">';
                        echo sprintf(_("Row %s with name %s imported"), $row, $name) . "<br>";
                        echo '<span>';
                    }
                    if($sqlqueryIsGoodToGo != true) {
                        echo '<span style="color: green">';
                        echo sprintf(_("Update not needed for row %s"), $row);
                        echo '<span>';
                    }
                    $sqlquery = "";  // empty for next row
                }
                break;
            case "delete":
                if (isset($data["id"]) && ctype_digit($data["id"])) { // Do we have a value? Is it an integer?
                    $sqlDeleteComponent = "DELETE FROM data WHERE id = ".$data["id"]." ";
                    $deleteresult = mysqli_query($connection,$sqlDeleteComponent);
                    if (mysqli_affected_rows($connection) > 0) { // 
                        echo '<span style="color: green">';
                        echo sprintf(_("Row %s - Deleted component with id %s"), $row, $data["id"]) . "<br>";
                        echo "</span>";
                    } else {
                        echo '<span style="color: red">';
                        echo sprintf(_("Row %s - Component with id %s is not in the database"), $row, $data["id"]) . "<br>";
                        echo "</span>";
                    }
                    break;
                } else {
                    echo '<span style="color: red">';
                    echo sprintf(_("Row %s - id is not an integer"), $row) . "<br>";
                    echo '</span>';
                }
            case "default":
                break;
            }
        } else { // header and csvdata differs in fields
            echo '<span style="color: red">';
            echo sprintf(_("Row, %s - The number of header fields differs against the number of data fields"), $row) . "<br>";
            echo '</span>';
            exit();
        } // end header and csvdata differs in fields
    $row++;
    } // end while
} // end function

function export_components($array, $filename, $delimiter=";")
{
    header("Pragma: public"); // required
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false); // required for certain browsers
    header("Content-Transfer-Encoding: binary");
    header("Content-Type: application/csv; charset=UTF-8");
//    header("Content-Length: " . $filesize);
    header("Content-Disposition: attachment; filename=\"" . $filename. "\";" );

    $handle = fopen( 'php://output', 'w' );

    // We use the keys as column titles
    fputcsv( $handle, array_keys( $array['0'] ), $delimiter );

    foreach ( $array as $value ) {
        fputcsv( $handle, $value, $delimiter );
    }
    // Close the file
    fclose( $handle );

    // Make sure that nothing else is sent to the browser
    exit();
}
?>
