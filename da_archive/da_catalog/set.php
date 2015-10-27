<?
# Name: set.php
# Purpose: accept filename and add it to ISSR_DATA_ARCHIVES cookie
# Usage: called from the web
# Steps:
#   - if no $file given, display form
#   - ck $file for validity, so as not to be hacked
#   - append to ISSR_DATA_ARCHIVE cookie, and create it if it doesn't exist
#   # display old and new cookie values
#   - redirect them back to the source page. ($src)
#
# Update: 02-23-05 mike and Marty - added $src variable, to send them back to calling page
# Update: 01-21-05 mike and Marty - starting this as test of citation shopping cart
#
# Status: WORKING
if ($clear == "yes") {
#  delete the cookie by setting the expiration date to one hour ago
  setcookie ("ISSR_DATA_ARCHIVE", "", time() - 3600);
  echo "Citation list cleared. Return to <a href=\"$src.HTM\">Study Page</a>\n";
  exit;
}
if (empty($file)) {
   echo "Please go to <a href=\"http://www.sscnet.ucla.edu/issr/da/index/\">Data Archives Index</a>.";
} else {
  # add test for valid filename here
# setcookie('ISSR_DATA_ARCHIVE','$file',,'/issr/da/index/techinfo/','www.sscnet.ucla.edu');
  if (isset($_COOKIE['ISSR_DATA_ARCHIVE'])) {
    if (strstr($_COOKIE['ISSR_DATA_ARCHIVE'],"$file;")) {
      # don't add it again, since it's already in list
    } else {
      $newcookie =  $_COOKIE['ISSR_DATA_ARCHIVE'].$file.";";
      setcookie('ISSR_DATA_ARCHIVE',"$newcookie");
    }
  } else {
    $newcookie = "$file;";
    setcookie('ISSR_DATA_ARCHIVE',"$newcookie");
  }
# echo "OLD: ", $_COOKIE['ISSR_DATA_ARCHIVE'], "<br>\n";
# echo "NEW: $newcookie<br>\n";
header("Location: $src.HTM"); # redirect back to source page
}
#echo "Citation saved. Return to <a href=\"$src.HTM\">Study Page</a>\n";
?>
