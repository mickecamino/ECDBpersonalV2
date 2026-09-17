<?php
// File: localize.php
// Function: Translate all text for the chosen language
// Revision date: 2026-09-16
// Revised by: Mikael Karlsson
// This file is distributed under the license: 
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
// 
// This file uses gettext functions to translate the text to another language
// It needs one parameter
// the language code, for Swedish it is sv_SE.utf8, this is set with
// a cookie in my.php and used on all pages needed it
// 
// The textdomain is fixed, i.e. "ecdbpersonalv2"
// You also need to translate all the strings in the ecdb.po file
// and compile it with msgfmt
// Read more at https://www.php.net/manual/en/function.gettext.php
//
function SetLanguage(string $lang)
{
    // Clear LANGUAGE as it may have been set, just to be safe
    putenv("LANGUAGE=");

    // Set the current language.
    putenv("LC_ALL=$lang");
    setlocale(LC_ALL, $lang);

    // Path to the .mo files.
    // NOTE: the language code and LC_MESSAGES are added automagically
    // For Swedish this will be:
    // /include/i18n/se_SV/LC_MESSAGES
    bindtextdomain("ecdbpersonalv2", './include/i18n');

    // Bind our textdomain to UTF-8
    bind_textdomain_codeset("ecdbpersonalv2", 'UTF-8');

    // And set it in the textdomain
    textdomain("ecdbpersonalv2");
}
?>
