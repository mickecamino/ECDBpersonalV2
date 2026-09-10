<?php
// File: my.php
// Function: Personal setting for a user
// Revision date: 2026-09-10
// Revised by: Mikael Karlsson
// This file is distributed under the license: 
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
// 
    require_once "include/login/auth.php";
    require_once "include/debug.php";
    include "include/mysql_connect.php";

    $owner  =   $_SESSION['SESS_MEMBER_ID'];

    $GetDataComponent = mysqli_query($connection,"SELECT * FROM members WHERE member_id = ".$owner."");
    $executesql = mysqli_fetch_assoc($GetDataComponent);
// Set or update the language cookie
    setcookie("language", $executesql['language'], time() + (86400 * 30), "/"); // 86400 * 30 = 30 days

 // Custom Page Titles
 $pageTitle = _("Profile");
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
    echo '<h1>' . _("Settings") . '</h1>';
    include "include/include_my_settings.php";
    $Settings = new My;
    $Settings->Settings();
        echo '<form class="globalForms noPadding" action="" method="post">';
            echo '<table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0">';
            echo '<tbody><tr>'; // start row one
            echo '<td class="boldText">' . _("First Name") . '</td>'; // first column
            echo '<td><input name="firstname" type="text" class="medium" value="'; // second column
            if(isset($_POST['submit'])) { echo $_POST['firstname']; } else { echo $executesql['firstname']; };
            echo '" /></td>'; // end second column
            echo '<td class="boldText">' . _("Last Name") . '</td>'; // third column
            echo '<td><input name="lastname" type="text" class="medium" value="'; // fourth column
            if(isset($_POST['submit'])) { echo $_POST['lastname']; } else { echo $executesql['lastname']; };
            echo '" /></td>'; // end fourth column
            echo '</tr><tr>'; // end first row, start second row
            echo '</tr><tr>'; // end second row, start third row
            echo '<td class="boldText">' . _("Password") . '</td>'; // first column
            echo '<td><input name="oldpass" class="medium" type="password" value="" /></td>'; // second column
            echo '<td class="boldText">' . _("New password") . '</td>'; // third column
            echo '<td><input name="newpass" class="medium" type="password" value="" onpaste="return false;" /></td>'; // fourth column
            echo '</tr><tr>'; // end second row, start third row
            echo '<td class="boldText">' . _("Currency") . '</td>'; // first column
            echo '<td><select name="currency"><option value="kr" '; // start second column
                if(!isset($_POST['submit']) && $executesql['currency'] == 'kr') { echo ' selected';}
                if(isset($_POST['submit']) && $_POST['currency'] == 'kr') { echo ' selected';}
                echo '>SEK</option>';
                echo '<option value="$"';
                if(!isset($_POST['submit']) && $executesql['currency'] == '$') { echo ' selected';}
                if(isset($_POST['submit']) && $_POST['currency'] == '$') { echo ' selected';}
                echo '>USD</option>';
                echo '<option value="€"';
                if(!isset($_POST['submit']) && $executesql['currency'] == '€') { echo ' selected';}
                if(isset($_POST['submit']) && $_POST['currency'] == '€') { echo ' selected';}
                echo '>EUR</option>';
                echo '<option value="£"';
                if(!isset($_POST['submit']) && $executesql['currency'] == '£') { echo ' selected';}
                if(isset($_POST['submit']) && $_POST['currency'] == '£') { echo ' selected';}
                echo '>GBP</option>';
            echo '</select></td>'; // end second column
            echo '<td class="boldText">' . _("Language") . '</td>'; // third column
                echo '<td><select name="language"><option value="sv_SE.utf8" '; // start fourth column
                if(!isset($_POST['submit']) && $executesql['language'] == 'sv_SE.utf8') { echo 'selected';}
                if(isset($_POST['submit']) && $_POST['language'] == 'sv_SE.utf8') { echo 'selected';}
                echo '>' . _("Swedish") . '</option>';
                echo '<option value="en_US.utf8"';
                if(!isset($_POST['submit']) && $executesql['language'] == 'en_US.utf8') { echo 'selected';}
                if(isset($_POST['submit']) && $_POST['language'] == 'en_US.utf8') { echo 'selected';}
                echo '>' . _("English") . '</option>';
                echo '<option value="fr_FR.utf8"';
                if(!isset($_POST['submit']) && $executesql['language'] == 'fr_FR.utf8') { echo 'selected';}
                if(isset($_POST['submit']) && $_POST['language'] == 'fr_FR.utf8') { echo 'selected';}
                echo '>' . _("French") . '</option>';
                echo '<option value="it_IT.utf8"';
                if(!isset($_POST['submit']) && $executesql['language'] == 'it_IT.utf8') { echo 'selected';}
                if(isset($_POST['submit']) && $_POST['language'] == 'it_IT.utf8') { echo 'selected';}
                echo '>' . _("Italian") . '</option>';
                echo '<option value="es_ES.utf8"';
                if(!isset($_POST['submit']) && $executesql['language'] == 'es_ES.utf8') { echo 'selected';}
                if(isset($_POST['submit']) && $_POST['language'] == 'es_ES.utf8') { echo 'selected';}
                echo '>' . _("Spanish") . '</option>';
                echo '</select></td>'; // end fourth column
                echo '</tr></tbody></table>';
            echo '<div class="buttons"><div class="input">';
            echo '<button class="button green" name="submit" type="submit"><span class="fa fa-save fa-lg"></span> ' . _("Save") . '</button>';
            echo '</div></div></form></div>';
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo "</div></body></html>";
?>
