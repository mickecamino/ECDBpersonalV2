<?php
// File: include/include_my_settings.php
// Function: Checker for my.php
// Revision date: 2026-09-21
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
class My {
    public function Settings() {

    require_once('include/login/auth.php');
    include('include/mysql_connect.php');

    if(isset($_POST['submit'])) {
        $owner            = $_SESSION['SESS_MEMBER_ID'];
        $GetDataComponent = mysqli_query($connection,"SELECT passwd FROM members WHERE member_id = ".$owner."");
        $executesql       = mysqli_fetch_assoc($GetDataComponent);
        $firstname        = strip_tags(mysqli_real_escape_string($connection,$_POST['firstname']));
        $lastname         = strip_tags(mysqli_real_escape_string($connection,$_POST['lastname']));
        $oldpass          = strip_tags(mysqli_real_escape_string($connection,$_POST['oldpass']));
        $newpass          = strip_tags(mysqli_real_escape_string($connection,$_POST['newpass']));
        $currency         = strip_tags(mysqli_real_escape_string($connection,$_POST['currency']));
        $language         = strip_tags(mysqli_real_escape_string($connection,$_POST['language']));

        if ($firstname == '') {
            echo '<div class="message red">';
            echo _("First name missing");
            echo '</div>';
        }
        elseif (strlen($firstname) <= 2) {
            echo '<div class="message red">';
            echo _("Minimum of 2 chars in first name.");
            echo '</div>';
        }
        elseif ($lastname == '') {
            echo '<div class="message red">';
            echo _("Last name missing");
            echo '</div>';
        }
        elseif (strlen($lastname) <= 2) {
            echo '<div class="message red">';
            echo _("Minimum of 2 chars in last name.");
            echo '</div>';
        }
        elseif (!empty($oldpass) && !empty($newpass) && $owner == 4) {
            echo '<div class="message red">';
            echo _("CHANGE PASSWORD FOR THE DEMO ACCOUNT NOT POSSIBLE!!!!");
            echo '</div>';
        }
        elseif (!empty($oldpass) && !empty($newpass) && $oldpass == '') {
            echo '<div class="message red">';
            echo _("Password missing");
            echo '</div>';
        }
        elseif (!empty($oldpass) && !empty($newpass) && $newpass == '') {
            echo '<div class="message red">';
            echo _("Confirm password missing");
            echo '</div>';
        }
        elseif (!empty($oldpass) && !empty($newpass) && strlen($newpass) <= 5) {
            echo '<div class="message red">';
            echo _("Minimum of 5 chars in password.");
            echo '</div>';
        }
        elseif (!empty($oldpass) && !empty($newpass) && strcmp(md5($oldpass), $executesql['passwd']) != 0 ) {
            echo '<div class="message red">';
            echo _("The password is invalid ");
            echo '</div>';
        }
        else {
            if (!empty($oldpass) && !empty($newpass)) {
                $sql="UPDATE members SET firstname = '$firstname', lastname = '$lastname', passwd = '".md5($newpass)."', currency = '$currency' WHERE member_id = '$owner'";
                $sql_exec = mysqli_query($connection,$sql);
            }
            else {
                $sql="UPDATE members SET firstname = '$firstname', lastname = '$lastname', currency = '$currency', language = '$language' WHERE member_id = '$owner'";
                $sql_exec = mysqli_query($connection,$sql);
            }
            echo '<div class="message green center">';
            echo _("Settings updated!");
            echo '</div>';
            }
        }
    }
}
