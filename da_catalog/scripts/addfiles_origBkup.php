<?
# Name: addfiles.php
# Purpose: accept study or filename and add it to ISSR_DATA_ARCHIVE_TAR cookie with data which will tell 
#  Shirley (ATS) which files or packages to tar up and provide to user. On first save, give UCLA Login warning 
# Subversion: https://laguna.sscnet.ucla.edu/svn/classweb/ISSRDA/addfiles.php

# Description: The first time through the user is logged in through ISIS.  If they're a valid user the 
# ISSR_DATA_ARCHIVE_TAR cookie is saved.  
# If it is a valid user subsequent clicks will just save the cookie.  
# If not a valid user maybe a message that they aren't authorized to get data.  When view all saved files 
# is clicked they should be presented with a list of files (either individual or entire study) they selected, 
# and then on to Shirley to .TAR and download. This is handled by viewfiles.php.
#
#  Individual filenames start with DTA...  Studies start with other than D...

# Usage: called from pages like http://www.sscnet.ucla.edu/issr/da/index/techinfo/M1511.HTM with POST or GET?
# The command to execute the php script is:
# addfiles.php?save=(If it starts with a D it's a file, otherwise a study)&src=(return page 
#    without .HTM)
# ex:
# addfiles.php?file=DTA001.file0001&study=M034V1&src=M0341 (for file DTA001.file0001)
# addfiles.php?file=&study=M034V1&src=M0341  (for study M034V1)

# Steps:
# + check for appropriate params: study and src required, file is optional, can be empty
# + if no cookie present
#   + create cookie (see format above), add file or study and give UCLA warning message with link back to $src page

# + if cookie exists and we're storing a file
#   + if the file is already in the cookie, don't add, just redirect to $srs
#   + if the study it's in is in the cookie already by itself, not as part of a file, then 
#     + don't change cookie, and give message that this file will be included in that study with link to $src
#   + if other files that belong to this study are present, that's ok, just add file to cookie and redirect to $src
#   + else add file to cookie and redirect to $src

# + if cookie exists and we're storing a study
#   + if the study is already in the cookie, don't add, just redirect to $srs
#   + if other files that belong to this study are present
#     + delete the individual files associated with this study from the cookie
#     + add study to cookie
#     + redirect to $src
#   + else add study to cookie and redirect to $src
#
# Update: 07-03-07 mike and Marty adding de-duping logic, changed to accept params of file, study and src
# Update: 06-28-07 mike and Marty checking cookies being saved and redirecting to source.scart.htm for testing
# Update: 06-19-07 mike and Marty dropping ISIS login in favor of warning message first time through
# Update: 06-12-07 mike and Marty laying this out
# Update: 06-04-07 mike and Marty and Shirley - planning addfile.php functionality
#
# Status: WRITING
if ($clear == "yes") {
#  delete the cookie by setting the expiration date to one hour ago
  setcookie ("ISSR_DATA_ARCHIVE_TAR", "", time() - 3600);
  echo "Citation list cleared. Return to <a href=\"$src.HTM\">Study Page</a>\n";
  exit;
}


############################################
# - check for appropriate params: study and src required, file is optional, can be empty
if (empty($study) or empty($src)) {
  echo "Certain required parameters are missing, please email pawlocki@ucla.edu with this information: $REQUEST_URI and the study or file you were trying to add.\n<br>";
   echo "Please go to <a href=\"http://www.sscnet.ucla.edu/issr/da/\">Data Archives</a>.";
} 


#   echo "Citation saved. Return to <a href=\"$src.scart.HTM\">Study Page</a>\n";
# if (empty($file)) {
#    echo "Please go to <a href=\"http://www.sscnet.ucla.edu/issr/da/index/\">Data Archives Index</a>.";
# } else {
#   # add test for valid filename here
#   if (isset($_COOKIE['ISSR_DATA_ARCHIVE_TAR'])) {
#     if (strstr($_COOKIE['ISSR_DATA_ARCHIVE_TAR'],"$file;")) {
#       # don't add it again, since it's already in list
#     } else {
#       $newcookie =  $_COOKIE['ISSR_DATA_ARCHIVE_TAR'].$file.";";
#       setcookie('ISSR_DATA_ARCHIVE_TAR',"$newcookie");
# #     header("Location: $src.scart.HTM"); # redirect back to source page # old test to get back to scart page
#       header("Location: $src.HTM"); # redirect back to source page
#     }
#   } else {
#     $newcookie = "$file;";
#     setcookie('ISSR_DATA_ARCHIVE_TAR',"$newcookie");
#     include("UCLAonly.php");
#     echo "You won't be able to download these files unless you have a UCLA Login ID.<br>\n";
#     echo "Citation saved. Return to <a href=\"$src.scart.HTM\">Study Page</a>\n";
#   }
# }

# - if no cookie present
  if (empty($_COOKIE['ISSR_DATA_ARCHIVE_TAR'])) {
  #   - create cookie (see format above), add file or study and give UCLA warning message with link back to $src page
    if (empty($file)) { # set Study into cookie
      $newcookie =  $study.";";
    } else { # set File into cookie
      $newcookie =  "$file($study);";
    }
    setcookie('ISSR_DATA_ARCHIVE_TAR',"$newcookie");
    include("UCLAonly.php");
    echo "You won't be able to download these files unless you have a UCLA Login ID.<br>\n";
    echo "Return to <a href=\"$src.HTM\">Study Page</a>\n";

# - if cookie exists and we're storing a file
  } elseif (!empty($file)) { 
#   - if the file is already in the cookie, don't add, just redirect to $srs
    if (strstr($_COOKIE['ISSR_DATA_ARCHIVE_TAR'],"$file")) {
      header("Location: $src.HTM"); # redirect back to source page
      exit;
    }
#   - if the study it's in is in the cookie already by itself, not as part of a file, then 
    if (strstr($_COOKIE['ISSR_DATA_ARCHIVE_TAR'],"$study;")) {
#     - don't change cookie, and give message that this file will be included in that study with link to $src
      echo "This file ($file) is already included in study ($study) that you've already selected.<br>\n";
      echo "Return to <a href=\"$src.HTM\">Study Page</a>\n";
      exit;
#   - else add file to cookie and redirect to $src
#   - don't need to check if other files that belong to this study are present, that's ok, 
#       just add file to cookie and redirect to $src
    } else {
      $addtocookie =  $_COOKIE['ISSR_DATA_ARCHIVE_TAR']."$file($study);";
      setcookie('ISSR_DATA_ARCHIVE_TAR',"$addtocookie");
      header("Location: $src.HTM"); # redirect back to source page
      exit;
    }
# - if cookie exists and we're storing a study
  } else { 
#   - if the study is already in the cookie, don't add, just redirect to $srs
    if (strstr($_COOKIE['ISSR_DATA_ARCHIVE_TAR'],"$study;")) {
      header("Location: $src.HTM"); # redirect back to source page
      exit;
    }
#   - if other files that belong to this study are present
    if (strstr($_COOKIE['ISSR_DATA_ARCHIVE_TAR'],"($study);")) {
      $elements = explode(";",$_COOKIE['ISSR_DATA_ARCHIVE_TAR']);
#     - delete the individual files associated with this study from the cookie
      $newcookie = "";
      foreach($elements as $key => $value) {
        # echo "key=$key value=$value<br>\n";
        if (!empty($value) and !strstr($value,"($study)")) { # skip file in this study because we're adding the complete study
          $newcookie .=  "$value;";
        } 
      }
#     - add study to cookie
      $newcookie .=  "$study;";
      # echo "newcookie = $newcookie<br>\n";
      setcookie('ISSR_DATA_ARCHIVE_TAR',"$newcookie");
#     - redirect to $src
      header("Location: $src.HTM"); # redirect back to source page
      exit;
    } else {
#   - else add study to cookie and redirect to $src
      $addtocookie =  $_COOKIE['ISSR_DATA_ARCHIVE_TAR']."$study;";
      setcookie('ISSR_DATA_ARCHIVE_TAR',"$addtocookie");
      header("Location: $src.HTM"); # redirect back to source page
      exit;
    }
  }
?>
