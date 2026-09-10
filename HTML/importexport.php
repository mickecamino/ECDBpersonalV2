<?php
// File: importexport.php
// Function: Export, import, add or delete components from the database
// Revision date: 2026-09-10
// Created by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    require_once "include/login/auth.php";
    include "include/mysql_connect.php";

    // Determine who is logged in and which parts belong to them
    $owner  =   $_SESSION['SESS_MEMBER_ID'];

// Custom Page Titles
    $pageTitle = _("Import / Export");

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

/********************************************************
* This module import entries into the data table.       *
* Three parameters:                                     *
* $owner - make sure that it is the current owner for   *
*          importing into the database                  *
* $connection - the SQL-connection                      *
* $filename   - the chosen file to import               *
* ******************************************************
*/
function import_components($owner, $connection, $filename)
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
            switch ($data["action"]) { // What shall we do? add, edit?
            case "add":
            case "edit": // We are here on add or edit component
                if($data["action"] == "edit") {
                    if (isset($data["id"]) && ctype_digit($data["id"])) { // Do we have a value? Is it an integer?
                        $id = $data["id"]; // id provided in the csv-file, get it and proceed
                        $GetDataComponent = mysqli_query($connection, "SELECT * FROM data WHERE id = " . $id . " AND owner = " . $owner . "");
                        $indatabase       = mysqli_fetch_assoc($GetDataComponent);
                        $sqlquery = "UPDATE `data` SET "; // start of UPDATE query
                    } else {
                        report_error($row, "", "", 2); // report errer #2
                        break;
                    } // end else
                }
                /*****************************************************************
                * We are here on add and edit
                *****************************************************************/
                if (isset($data["name"])) { // Do we have a value?
                    if (strlen($data["name"]) > 64) { // is it larger than whats accepted in the database?
                        report_error($row, "name", "64", 1);
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
                    report_error($row, "", "", 4); // report error #4
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
                        report_error($row, $find, $categoryname["name"], 3); // report errer #3
                        break; // Get next record
                    } else { // On add, if no match found, just add the component
                        $name = $data["name"]; // Everything is OK, save data and continue
                        $sqlquery = " name = " . $data["name"] . ","; // add trailing comma
                        $sqlqueryIsGoodToGo = true;
                    } // end else
                }

                if ($data["manufacturer"] != "") { // Empty string provided?
                    if (strlen($data["manufacturer"]) > 64) {
                        report_error($row, "manufacturer", "64", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
                        if (strcmp($data["manufacturer"], $indatabase["manufacturer"]) <> 0) { // data differs
                            $sqlquery = $sqlquery . " manufacturer = '" . $data["manufacturer"] . "',";
                            $sqlqueryIsGoodToGo = true;
                        } // end if strcmp
                    } // end elseif edit
                        $manufacturer = $data["manufacturer"];
                } else {
                    $manufacturer = "";
                }

                if ($data["package"] != "") { // Empty string provided?
                    if (strlen($data["package"]) > 64) {
                        report_error($row, "package", "64", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
                        if (strcmp($data["package"], $indatabase["package"]) <> 0) { // data differs
                            $sqlquery = $sqlquery . " package = " . $data["package"] . "," ;
                            $sqlqueryIsGoodToGo = true;
                        } // end if strcmp
                    } // end elseif edit
                    $package = $data["package"];
                } else {
                    $package = "";
                }

                if ($data["pins"] != "") { // Empty string provided?
                    if ($data["pins"] > 65535) { // Yes, that is an unsigned smallint
                        report_error($row, "pins", "65535", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
                        if ($data["pins"] <> $indatabase["pins"]) { // data differs
                            $sqlquery = $sqlquery . " pins = " . $data["pins"] . ",";
                            $sqlqueryIsGoodToGo = true;
                        } // end compare
                    } // end elseif edit
                    $pins = $data["pins"];
                } else {
                    $pins = 0;
                }

                if ($data["quantity"] != "") {
                    if ($data["quantity"] > 65535) { // Empty string provided?
                        report_error($row, "quantity", "65535", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
                        if ($data["quantity"] <> $indatabase["quantity"]) { // data differs
                            $sqlquery = $sqlquery . " quantity = " . $data["quantity"] . ",";
                            $sqlqueryIsGoodToGo = true;
                        } // end compare
                    } // end if edit
                    $quantity = $data["quantity"];
                } else {
                    $quantity = 0;
                }

                if ($data["order_quantity"] != "") { // Empty string provided?
                    if ($data["order_quantity"] > 65535) {
                        report_error($row, "order_quantity", "65535", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
                        if ($data["order_quantity"] <> $indatabase["order_quantity"]) { // data differs
                            $sqlquery = $sqlquery . " order_quantity = " . $data["order_quantity"] . ",";
                            $sqlqueryIsGoodToGo = true;
                        } // end compare
                    } // end if edit
                    $order_quantity = $data["order_quantity"];
                } else {
                    $order_quantity = 0;
                }

                if (isset($data["location"])) {
                    if (strlen($data["location"]) > 32) {
                        report_error($row, "location", "32", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
                        if (strcmp($data["location"], $indatabase["location"]) <> 0) { // data differs
                            $sqlquery = $sqlquery . " location = " . $data["location"] . ",";
                            $sqlqueryIsGoodToGo = true;
                        } // end if strcmp
                    } // end if edit
                     $location = $data["location"];
                } else {
                    $location = "";
                }

                if ($data["scrap"] != "") {
                    if ($data["scrap"] == "Yes" || $data["scrap"] == "No") { // Is it Yes or No?
                        if($data["action"] == "edit") { // If edit, then compare with whats in the database
                            if (strcmp($data["scrap"], $indatabase["scrap"]) <> 0) { // data differs
                                $sqlquery = $sqlquery . " scrap = " . $data["scrap"] . ",";
                                $sqlqueryIsGoodToGo = true;
                            } // end if strcmp
                        } // end if edit
                        $scrap = $data["scrap"];
                    } else { // No Yes or No in the supplied field, report it
                        report_error($row, "", "", 5);
                        break;
                    }
                } else {
                    $scrap = "No"; // Yes or No not in import, then set scrap to Np
                }

                if (isset($data["datasheet"])) {
                    if (strlen($data["datasheet"]) > 256) {
                        report_error($row, "datasheet", "256", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
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
                        report_error($row, "comment", "256", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
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
                    if ($data["category"] > 65535) {
                        report_error($row, "category", "65535", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
                        if ($data["category"] <> $indatabase["category"]) { // data differs
                            $sqlquery = $sqlquery . " category = " . $data["category"] . ",";
                            $sqlqueryIsGoodToGo = true;
                        } // end compare
                    } // end if edit
                    $category = $data["category"];
                } else {
                    report_error($row, "", "", 6);
                    break;
                }

                if (isset($data["cimage"])) {
                    if (strlen($data["cimage"]) > 256) {
                        report_error($row, "cimage", "256", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
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
                        report_error($row, "appnote", "256", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
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
                        report_error($row, "price", "11", 1);
                        break;
                    } elseif($data["action"] == "edit") { // If edit, then compare with whats in the database
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
                    $result = mysqli_query($connection,$sql);
                    report_success($row, $name, $categoryname, 1);
                } elseif ($data["action"] == "edit") {
                    $sqlquery = substr($sqlquery, 0, -1); // Get rid of the last comma:
                    $sqlquery = $sqlquery . " WHERE `id` = $id;";
                    if($sqlqueryIsGoodToGo) {
                        $sql_exec = mysqli_query($connection,$sqlquery);
                        report_success($row, $name, "", 2);
                    }
                    if($sqlqueryIsGoodToGo != true) {
                        echo '<span style="color: green">';
                        echo sprintf(_("Update not needed for row %s"), $row);
                        echo '<span>';
                    }
                    $sqlquery = "";  // empty for next row
                } // end elseif
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
            } // end switch
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
    // flush the buffer
    ob_clean();
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

function report_error($row, $field1, $field2, $errorlevel)
{
    if( $errorlevel == 1 ) {
        echo '<span style="color: red">';
        echo sprintf(_("Error on row %s - data in field %s needs to be less than %s characters"), $row, $field1, $size) . "<br>";
        echo '</span>';
        return;
    }
    if( $errorlevel == 2 ) {
        echo '<span style="color: red">';
        echo sprintf(_("ERROR on row %s - id must be supplied for action edit"), $row) . "<br>"; // id is required
        echo '</span>';
        return;
    }
    if ( $errorlevel == 3 ) {
        echo '<span style="color: red">';
        echo sprintf(_("Component with name = '%s' and category %s is already in the database"), $field1, $field2) . "<br>";
        echo '</span>';
        return;
    }
    if ( $errorlevel == 4 ) {
        echo '<span style="color: red">';
        echo sprintf(_("ERROR on row %s - name must be supplied for action add in the csv file"), $row); // name is required
        echo '</span>';
        return;
    }
    if ( $errorlevel == 5 ) {
        echo '<span style="color: red">';
        echo sprintf(_("Error on row %s - field scrap need to be Yes or No"), $row) . "<br>";
        echo '</span>';
        return;
    }
    if ( $errorlevel == 6 ) {
        echo '<span style="color: red">';
        echo sprintf(_("ERROR on row %s - category must be supplied for action add or edit"), $row); // id is required
        echo '</span>';
        return;
    }
}

function report_success($row, $field1, $field2, $successlevel)
{
    if( $successlevel = 1 ) {
        echo '<span style="color: green">';
        echo sprintf(_("Row %s with name %s and category %s imported"), $row, $field1, $field2["name"]) . "<br>";
        echo '<span>';
        return;
    }
    if( $successlevel = 2 ) {
        echo '<span style="color: green">';
        echo sprintf(_("Row %s with name %s imported"), $row, $field1) . "<br>";
        echo '<span>';
        return;
    }
}
?>
