<?php
// File: include/include_format_currency.php
// Function: Currency formatting depending on chosen language and chosen currency
// Revision date: 2026-09-17
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
/*********************************************************
 * Input: $price - the price for a component
 *        $language - Language set in my.php
 *        $currency - Currency set in my.php
 * Output
**********************************************************/
function format_currency($language,$currency , $price) {
    $fmt = numfmt_create( $language, NumberFormatter::CURRENCY );
    return numfmt_format_currency($fmt, $price, $currency);
}
?>
