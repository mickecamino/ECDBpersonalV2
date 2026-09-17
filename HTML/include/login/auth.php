<?php
// File: include/login/fauth.php
// Function: Set session and cookie
// Revision date: 2026-09-16
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
    //Start session
    session_start(['cookie_lifetime' => 86400,]);
    if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
        header("location: login.php");
        exit();
    }
?>
