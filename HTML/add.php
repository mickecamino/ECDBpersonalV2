<?php
// File: add.php
// Function: sadd component
// Revision date: 2026-09-11
// Revised by: Mikael Karlsson
// This file is distributed under the license: 
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
// 
    require_once "include/login/auth.php";
    include "include/mysql_connect.php";

    // Get some personal data. ID, currency
    $owner  =   $_SESSION['SESS_MEMBER_ID'];
    $GetPersonal = mysqli_query($connection,"SELECT currency FROM members WHERE member_id = ".$owner."");
    $personal = mysqli_fetch_assoc($GetPersonal);
     // Custom Page Titles
    $pageTitle = _("Add Component");
    include "include/head.php";
    echo '<body  onLoad="document.forms.add.name.focus()"><div id="wrapper">';
// Header
    include "include/header.php";
// END
// Main menu
    include "include/menu.php";
// END
// Main content
    echo '<div id="content">';
    echo "<h1>" . _("Add new component") . "</h1>";
    include "include/include.php";
    $Add = new ShowComponents;
    $Add->Add();
    echo '<form class="globalForms noPadding" action="" method="post" id="add">';
    echo '<div class="textBoxInput"><label class="keyWord boldText">' . _("Comment") . '</label>';
    echo '<div class="text"><textarea name="comment" rows="4">';
    if(isset($_POST['submit'])) { echo $_POST['comment']; }
    echo '</textarea></div></div>';
// Table start
    echo '<table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0"><tbody>';
// First row
    echo '<tr><td class="boldText">'. _("Name") . '</td>'; //first column
    echo '<td><input name="name" id="name" type="text" class="medium" value="'; //start second column
    if(isset($_POST['submit'])) { echo $_POST['name']; }
    echo '" autofocus tabindex="0"></td>'; // end second column
    echo '<td class="boldText">' . _("Category") . '</td>'; // third column
    echo '<td><select name="category">'; // start fourth column
    // Include the category selector menu.
    include "include/include_component_add_category_menu.php";
    $MenuCat = new AddMenuCat;
    $MenuCat->MenuCat();
    echo '</select></td>'; // end fourth column
    echo '<td class="boldText">' . _("Quantity") . '</td>'; // fifth column
    echo '<td><input name="quantity" type="text" class="small" value="'; // start sixth column
    if(isset($_POST['submit'])) { echo $_POST['quantity']; }
    echo '"></td></tr>'; // end input name, end sixth columnt, end first row
// Second row
    echo '<tr><td class="boldText">' . _("Manufacturer") . '</td>'; // first column
    echo '<td><div class="ui-widget"><input name="manufacturer" id="manufacturer" type="text"  value="'; // start second column
    if(isset($_POST['submit'])) { echo $_POST['manufacturer']; }
    echo '"></div></td>'; // end value, end second column
    echo '<td class="boldText">' . _("Package") . '</td>'; // third column
    echo '<td><div class="ui-widget"><input name="package" id="package" type="text"  value="'; // start fourth column
    if(isset($_POST['submit'])) { echo $_POST['package']; }
    echo '" ></div></td>'; // end value, end fourth column
    echo '<td class="boldText">' . _("Pins") . '</td>'; // fifth column
    echo '<td><input name="pins" type="text" class="small" value="'; // start sixth column
    if(isset($_POST['submit'])) { echo $_POST['pins']; }
    echo '"></td></tr>'; // end sixth column
// Third row
    echo '<tr><td class="boldText">' . _("Location") . '</td>'; // first column
    echo '<td><div class="ui-widget"><input name="location" id="location" type="text" value="'; // start second column
    if(isset($_POST['submit'])) { echo $_POST['location']; }
    echo '"></div></td>'; // end value, end second column
    echo '<td class="boldText">' . _("Price") . '</td>'; // third column
    echo '<td><input name="price" type="text" class="small" value="'; // start fourth column 
    if(isset($_POST['submit'])) { echo $_POST['price']; }
    echo '">' . $personal['currency'] . '</td>'; // end value, end fourth column
    echo '<td class="boldText">' . _("To order") . '</td>'; // start sixth column
    echo '<td><input name="orderquant" type="text" class="small" value="';
    if(isset($_POST['submit'])) { echo $_POST['orderquant']; }
    echo '"></td></tr>'; // end value, end sixth column, end third row
// Fourth row, six columns
    echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
// Fifth row
    echo '<tr><td class="boldText"> ' . _("Recycled") . '</td>'; // first column
    echo '<td>'; // start second column
    if(isset($_POST['submit']) && $_POST['scrap'] == 'Yes'){
        echo '<input type="radio" name="scrap" value="Yes" checked="checked" > ' . _("Yes") . ' ';
        echo '<input type="radio" name="scrap" value="No" > ' . _("No");
        }
    else{
        echo '<input type="radio" name="scrap" value="Yes" > ' . _("Yes") . ' ';
        echo '<input type="radio" name="scrap" value="No" checked="checked" > ' . _("No");
        }
    echo '</td>'; // end second column
    echo '<td></td><td></td><td></td><td></td><td></td></tr>'; // end third, fourth, fifth, sixth columns, end fifth row
// Sixth  row, six columns
    echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
// Seventh row
    echo '<tr><td class="boldText">' . _("Datasheet") . '</td>'; // first column
    echo '<td><div class = "ui-widget"><input id="datasheet" name="datasheet" type="text" value="'; // start second column
    if(isset($_POST['submit'])) { echo $_POST['datasheet']; }
    echo '"></div></td>'; // end second column
    echo '<td class="boldText">' . _("Image") . '</td>'; //third column
    echo '<td><div class = "ui-widget"><input id="images" name="cimage" type="text"  value="';
    if(isset($_POST['submit'])) { echo $_POST['cimage']; }
    echo '"></div></td>'; // fourth column
    echo '<td></td><td></td></tr>'; // fifth and sixth column, end seventh row
// Eight row
    echo '<tr><td class="boldText">' . _("Application Note") . '</td>'; // first column
    echo '<td><div class = "ui-widget"><input id="appnote" name="appnote" type="text" value="'; // start second column
    if(isset($_POST['submit'])) { echo $_POST['appnote']; }
    echo '"></div></td>'; // end second column
    echo '<td></td><td></td><td></td><td></td></tr>'; // third, fourth, fifth and sixth column, end eight row
// Ninth row
    echo '<tr><td></td>'; // start ninth row, first column
    echo '<td  class="boldText">' . _("Add component to project") . '</td>'; // second column
    echo '<td  class="boldText">' . _("Quantity") . '</td>'; // third column
    echo '<td></td><td></td><td></td></tr>'; // fourth, fifth and sixth column, end ninth row
// Tenth row
    echo '<tr class="bordered"></tr>';
// Eleventh row
    echo '<tr><td></td>'; // start eleventh row, first column
    echo '<td><select name="project">'; // second column, start select
    include "include/include_component_add_project.php";
    $MenuProj = new AddMenuProj;
    $MenuProj->MenuProj();
    echo '</select></td>'; // end select, end second column
    echo '<td><input name="projquant" type="text" class="small" value="'; // third column
    if(isset($_POST['submit'])) { echo $_POST['projquant']; }
    echo '"></td>'; // end value, end third column
    echo '<td></td><td></td><td></td></tr>'; // fourth, fifth and sixth column, end eleventh row
    echo '</tbody></table>'; // end table
    echo '<div class="buttons"><div class="input"><button class="button green" name="submit" type="submit"><span class="fa fa-save fa-lg"></span> ' . _("Save") . '</button>';
    echo '</div></div></form></div>'; // end divs and form
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo "</div></body></html>";
