<?php
// File: register-exec.php
// Function: Add new user, called after register.php
// Calls register-success.php on successful completion
// Revision date: 2026-09-22
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//

// Enable or disable register
    include "include/include_disable_register.php";
    if( $disable_register == true ) {  header("location: login.php"); } 

    //Start session
    session_start();

//Include database connection details
require_once "include/login/config.php";
include "include/mysql_connect.php";

 // Call the language translator
require_once "include/localize.php";
if(isset($_COOKIE["language"])) { // for localization
    $language = $_COOKIE["language"];
}
else { // Not set, set to en_US.utf8
    $language = "en_US.utf8";
 }
    SetLanguage($language);
// END

    //Array to store validation errors
    $errmsg_arr = array();

    //Validation error flag
    $errflag = false;

    //Sanitize the POST values
    $fname = mysqli_real_escape_string($connection,$_POST['fname']);
    $lname = mysqli_real_escape_string($connection,$_POST['lname']);
    $login = mysqli_real_escape_string($connection,$_POST['login']);
    $password = mysqli_real_escape_string($connection,$_POST['password']);
    $cpassword = mysqli_real_escape_string($connection,$_POST['cpassword']);

    //Input Validations
    if($fname == '') {
        $errmsg_arr[] = _("First name missing");
        $errflag = true;
    }
    if (strlen($fname) <= 2){
        $errmsg_arr[] = _("Minimum of 2 chars in first name.");
        $errflag = true;
    }
    if($lname == '') {
        $errmsg_arr[] = _("Last name missing");
        $errflag = true;
    }
    if (strlen($lname) <= 2){
        $errmsg_arr[] = _("Minimum of 2 chars in last name.");
        $errflag = true;
    }
    if($login == '') {
        $errmsg_arr[] = _("Username missing");
        $errflag = true;
    }
    if (strlen($login) <= 2){
        $errmsg_arr[] = _("Minimum of 2 chars in username.");
        $errflag = true;
    }
    if($password == '') {
        $errmsg_arr[] = _("Password missing");
        $errflag = true;
    }
    if($cpassword == '') {
        $errmsg_arr[] = _("Confirm password missing");
        $errflag = true;
    }
    if (strlen($password) <= 5){
        $errmsg_arr[] = _("Minimum of 5 chars in password.");
        $errflag = true;
    }
    if( strcmp($password, $cpassword) != 0 ) {
        $errmsg_arr[] = _("Passwords do not match");
        $errflag = true;
    }

    //Check for duplicate login ID
    if($login != '') {
        $qry = "SELECT * FROM members WHERE login='$login'";
        $result = mysqli_query($connection,$qry);
        if($result) {
            if(mysqli_num_rows($result) > 0) {
                $errmsg_arr[] = _("Username already in use");
                $errflag = true;
            }
            @mysqli_free_result($result);
        }
        else {
            die("Query failed");
        }
    }

    //If there are input validations, redirect back to the registration form
    if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: register.php");
        exit();
    }

    //Create INSERT query
    $qry = "INSERT INTO members(firstname, lastname, login, passwd) VALUES('$fname','$lname','$login','".md5($_POST['password'])."')";
    $result = @mysqli_query($connection,$qry);

    //Check whether the query was successful or not
    if($result) {
        header("location: register-success.php");
        exit();
    }else {
        die("Query failed");
    }
?>
