<?
# Name: read.php
# Purpose: extract ISSR_DATA_ARCHIVES cookie and display all listed citations
# Usage: called from the web
# Steps:
#   - read ISSR_DATA_ARCHIVE cookie and give error if it doesn't exist
#   - split it into list, based on blankspace delimiter
#   - use list of values as keys to either database or filenames, and display them all
#
# Update: 02-23-05 mike and Marty - working with real citation/files and displays them
#                  and delimiting by semicolon
# Update: 01-21-05 mike and Marty - starting this as test of citation shopping cart
#
# Status: WRITING

  if (empty($_COOKIE['ISSR_DATA_ARCHIVE'])) {
    echo "Nothing stored in shopping cart, so far.<br>\n";
  } else {
    $list = split(";", $_COOKIE['ISSR_DATA_ARCHIVE']);
    while (list ($key, $val) = each ($list)) {
      # echo "$key => $val<br />\n";
      if ($val == "") { # skip empty values
      } elseif (file_exists("citations/$val.TXT")) {
        include("citations/$val.TXT"); 
        echo "<hr>\n";
      } else {
        echo "No citation found for $val.</br>\n";
        echo "<hr>\n";
     }
    }
  }
?>
