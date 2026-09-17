<!DOCTYPE html >
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
        <meta name="keywords" content="electronics, components, database, project, inventory">
        <link rel="shortcut icon" href="favicon.ico" >
        <link rel="stylesheet" href="css/all.css">
        <!-- Primarily for Autocomplete -->
        <link href = "css/jquery-ui-1.9.2.custom.css" rel = "stylesheet">
        <script src = "js/jquery-1.8.3.js"></script>
        <script src = "js/jquery-ui-1.9.2.custom.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
        <title><?php echo $pageTitle ?></title>
<script>
$(function() {
    $( "#appnote" ).autocomplete({
      source: 'autocomplete_appnote.php',
      min_length:2
    });
  });

$(function() {
    $( "#datasheet" ).autocomplete({
      source: 'autocomplete_datasheet.php',
      min_length:2
    });
  });

$(function() {
    $( "#images" ).autocomplete({
      source: 'autocomplete_images.php'
    });
  });

$(function() {
    $( "#location" ).autocomplete({
      source: 'autocomplete_location.php'
    });
  });

$(function() {
    $( "#manufacturer" ).autocomplete({
      source: 'autocomplete_manufacturer.php'
    });
  });

$(function() {
    $( "#package" ).autocomplete({
      source: 'autocomplete_package.php',
      min_length:2
    });
  });

  $(function() {
    $( "#name" ).autocomplete({
      source: 'autocomplete_name.php',
      min_length:2
    });
  });
</script>
    </head>
