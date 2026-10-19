<?php
// File: add.php
// Function: sadd component
// Revision date: 2026-10-19
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
// start first row, start and end first column
    echo '<tr><td class="boldText">'. _("Name") . '</td>';
//start second column
    echo '<td><input name="name" id="name" type="text" class="medium" value="';
    if(isset($_POST['submit'])) { echo $_POST['name']; }
// end second column
    echo '" autofocus tabindex="0"></td>';
// start and end third column
    echo '<td class="boldText">' . _("Category") . '</td>';
// start fourth column
    echo '<td><select name="category">';
// Include the category selector menu.
    include "include/include_component_add_category_menu.php";
    $MenuCat = new AddMenuCat;
    $MenuCat->MenuCat();
// end fourth column
    echo '</select></td>';
// start and end fifth column
    echo '<td class="boldText">' . _("Quantity") . '</td>';
// start sixth column
    echo '<td><input name="quantity" class="small" type="numeric" pattern="[0-9]*" title="' ._("Numbers only") .'" value="';
    if(isset($_POST['submit'])) { echo $_POST['quantity']; }
// end sixth column, end first row
    echo '"></td></tr>';
// start second row, start and end first column
    echo '<tr><td class="boldText">' . _("Manufacturer") . '</td>';
// start second column
    echo '<td><div class="ui-widget"><input name="manufacturer" id="manufacturer" type="text"  value="';
    if(isset($_POST['submit'])) { echo $_POST['manufacturer']; }
// end second column
    echo '"></div></td>';
// start and end third column
    echo '<td class="boldText">' . _("Package") . '</td>';
// start fourth column
    echo '<td><div class="ui-widget"><input name="package" id="package" type="text"  value="';
    if(isset($_POST['submit'])) { echo $_POST['package']; }
// end fourth column
    echo '" ></div></td>';
// start and end fifth column
    echo '<td class="boldText">' . _("Pins") . '</td>';
// start sixth column
    echo '<td><input name="pins" class="small" type="numeric" pattern="[0-9]*" title="' ._("Numbers only") .'" value="';
    if(isset($_POST['submit'])) { echo $_POST['pins']; }
// end sixth column, end second row
    echo '"></td></tr>';
// start third row, start and edn first column
    echo '<tr><td class="boldText">' . _("Location") . '</td>';
// start second column
    echo '<td><div class="ui-widget"><input name="location" id="location" type="text" value="';
    if(isset($_POST['submit'])) { echo $_POST['location']; }
// end second column
    echo '"></div></td>'; 
// start and end third column
    echo '<td class="boldText">' . _("Price") . '</td>';
// start fourth column
    echo '<td><input name="price" type="text" pattern="^\d+(?:[.]\d{1,2}|$)$" class="price" title="' ._("Positive value only, up to two decimals") .'" value="';
    if(isset($_POST['submit'])) { echo $_POST['price']; }
// end fourth column
    echo '"></td>';
// start and end fifth column
    echo '<td class="boldText">' . _("To order") . '</td>';
// start sixth column
    echo '<td><input name="orderquant" class="small" type="numeric" pattern="[0-9]*" title="' ._("Numbers only") .'" value="';
    if(isset($_POST['submit'])) { echo $_POST['orderquant']; }
// end sixth column, end third row
    echo '"></td></tr>';
// start fourth row start and end first column
    echo '<tr><td class="boldText"> ' . _("Recycled") . '</td>';
// start second column
    echo '<td>';
    if(isset($_POST['submit']) && $_POST['scrap'] == 'Yes'){
        echo '<input type="radio" name="scrap" value="Yes" checked="checked" > ' . _("Yes") . ' ';
        echo '<input type="radio" name="scrap" value="No" > ' . _("No");
        }
    else{
        echo '<input type="radio" name="scrap" value="Yes" > ' . _("Yes") . ' ';
        echo '<input type="radio" name="scrap" value="No" checked="checked" > ' . _("No");
        }
// end second column
    echo '</td>';
// end third to sixth columns, end fourth row
    echo '<td></td><td></td><td></td><td></td></tr>'; 
// start fifth row, start and end first column
    echo '<tr><td class="boldText">' . _("Datasheet") . '</td>';
// start second column
    echo '<td><div class = "ui-widget"><input id="datasheet" name="datasheet" type="text" value="';
    if(isset($_POST['submit'])) { echo $_POST['datasheet']; }
// end second column
    echo '"></div></td>';
// start and end third column
    echo '<td class="boldText">' . _("Application Note") . '</td>';
// start fourth column
    echo '<td><div class = "ui-widget"><input id="appnote" name="appnote" type="text" value="';
    if(isset($_POST['submit'])) { echo $_POST['appnote']; }
// end fourth column
    echo '"></div></td>';
// start and end fifth column
    echo '<td class="boldText">' . _("Image") . '</td>';
// start sixth column
    echo '<td><div class = "ui-widget"><input id="images" name="cimage" type="text"  value="';
    if(isset($_POST['submit'])) { echo $_POST['cimage']; }
// end sixth column, end fifth row
    echo '"></div></td></tr>'; 
// Don't display Add to project if there are no project(s)
    $projects_qry = "SELECT project_id FROM projects WHERE project_owner = $owner";
    $projects_res = mysqli_query($connection,$projects_qry);
    $numrows = mysqli_num_rows($projects_res);
// If there are no projects, skip section for project display
    if ($numrows > 0) {
// start sixth row, start and end first column
    echo '<tr><td></td>';
// start and end second column
    echo '<td  class="boldText">' . _("Add component to project") . '</td>';
// start and end third column
    echo '<td  class="boldText">' . _("Quantity") . '</td>';
// start and end fourth to sixth column, end sixth row
    echo '<td></td><td></td><td></td></tr>';
// start seventh row, start and end first column 
    echo '<tr><td></td>';
// start second column
    echo '<td><select name="project">';
    include "include/include_component_add_project.php";
    $MenuProj = new AddMenuProj;
    $MenuProj->MenuProj();
// end second column
    echo '</select></td>';
// start third column
    echo '<td><input name="projquant" class="small" type="numeric" pattern="[0-9]*" title="' ._("Numbers only") .'" value="';
    if(isset($_POST['submit'])) { echo $_POST['projquant']; }
// end third column
    echo '"></td>'; 
// start and end fourth to sixth column, end seventh row
    echo '<td></td><td></td><td></td></tr>'; 
    } // end if numrows

    echo '</tbody></table>'; // end table
    echo '<div class="buttons"><div class="input"><button class="button green" name="submit" type="submit"><span class="far fa-save fa-lg"></span> ' . _("Save") . '</button>';
    echo '</div></div></form></div>'; // end divs and form
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo "</div></body></html>";
