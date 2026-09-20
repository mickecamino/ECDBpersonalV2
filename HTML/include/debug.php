<?php
// File: debug.php
// Function: This sets PHP errors on or off.
// Revision date: 2026-09-20
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
$debug = 1; // 1 = debug

if ($debug == 1){
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', '1');
}
?>
