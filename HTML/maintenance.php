<?php
// File: maintenance.php
// Function: Allow Image files and PDF files to be uploaded
// Author: Pete Willard
// Date: August 2017
// Revision date: 2026-09-14
// Revised by: Mikael Karlsson
// This file is distributed under the license:
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
//
// Custom Page Title
$pageTitle = _("Maintenance");
include ("include/head.php");
// Reference Material - Maintenance Methods
// Here we can upload new IMAGES and PDF files for use
// in the database.
//
    echo '<body><div id="wrapper">';
// Header
    include 'include/header.php';
// END
// Main menu
    include 'include/menu.php';
// END
// Main content
    echo '<div id="content"><h3>' . _("Reference Materials") . '</h3><p>';
    echo _("Images and PDF files are uploaded to the server to be used as references for components.");
    echo '</p><div class="message orange">';
    echo _("PDF files are uploaded as Datasheets unless specified as Application Notes.");
    echo '</div><h1>' . _("File Upload") . '</h1>';
    echo '<form action="maintenance.php" method="post" enctype="multipart/form-data">';
    echo '<input type="checkbox" name="appnote" value="Yes" /> ' . _("Upload as an Application Note?") . '<br>';
    echo '<input type="file" class = "bold" name="file" id="file"><br>';
    echo '<button class="button green" name="submit" type="submit"><span class="fas fa-upload"></span> ' . _("Upload") . '</button> ';
    echo '<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />';
    echo '</form>';

// Automation methods:
// This method DOES allow for files to be manually added to the folder
// without the use this menu item.

if (isset($_POST['submit'])) {
    $name = $_FILES['file']['name'];

    $temp_name = $_FILES['file']['tmp_name'];
    if (isset($_POST['appnote'])) {
    $appnote = $_POST['appnote'];
    } else {
     $appnote = _("No");
    }

    // Not empty
    if (isset($name)) {
        if (!empty($name)) {
            $imglocation = 'img/parts/';
            if ($appnote == _("Yes")){
                $pdflocation = 'appnotes/';
            } else {
            $pdflocation = 'sheets/';
            }
            // Determine uploaded file extension
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $ext = strtolower($ext);

            // Route PDF's to sheets folder
            if ($ext == 'pdf') {
                echo _("    PDFfile    ");
                $location = $pdflocation;
                // Move the uploaded file from the temp folder to the PDF folder
                moveIt($location);
            }

            // IMAGE handler
            if ($ext == 'jpg' || $ext == 'gif' || $ext == 'png') {
                // route images to img/parts folder
                $location = $imglocation;
                moveIt($location); // Move the uploaded file from the temp folder to the img/parts folder
            }
        // Any other file type... we do nothing
        }
    }
}

// Should be clear what this does...
// it is used to move the file to the final location based on file extension

function moveIt($finalLocation) {
// If the file exists... make note of it and don't perform a move step
$delay=5;
    if (file_exists($finalLocation . $_FILES["file"]["name"])) {
        echo $_FILES["file"]["name"] . _(" already exists.") . "<br>";
        } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], $finalLocation . $_FILES["file"]["name"]);

        $message = _(" - File Uploaded");
        echo $_FILES["file"]["name"] . $message . "<br>";
        //echo "<script type='text/javascript'>alert('$message');</script>";

        // make all the files in the current folder lower case
        lcFolder($finalLocation);
        }
        //header('Refresh: $delay; url=maintenance.php');
   }

// This is only compatible with LINUX and WINDOWS - Sorry
// This will rename all the files in the reference folders to
// Lowercase

function lcFolder($folderlocation){

    $CWD = getcwd();
    chdir($folderlocation);

    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
        // A very "Windosy thing to"
        $syscommand = system(`for /f "Tokens=*" %f in ('dir /l/b/a-d') do (rename "%f" "%f")`, $retval);
    } else {
        // Assume linux default
        $syscommand = shell_exec("rename 'y/A-Z/a-z/' *");
    }

    chdir($CWD);
}

    echo "</div>";
// END
// Text outside the main content
    include "include/footer.php";
// END
    echo "</div></body></html>";
?>