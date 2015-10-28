<?PHP

# Name: redirectMe.php
# Purpose:  redirect from an old data archive page to the new catalog page
# Usage: called from the web
# Steps:
#   1) get the original URI from  $_SERVER["QUERY_STRING"]
#   2) pull off the .HTM  - I just checked, they are all .HTM in caps, no .HTML
#   3) a 'V' has to be inserted before the ending version number,
#      example M5111  -->   M511V1

echo $_SERVER["REQUEST_URI"] . "<br>";   // would be something like $studynumber=M1115
echo $_SERVER["QUERY_STRING"] . "<br>";   // M1115.HTM
echo $_SERVER["SCRIPT_NAME"] . "<br>";   //  not sure
echo $_SERVER["PHP_SELF"] . "<br>";     not sure


//  could do someting like ...redirectMe.php?originalURI=M5111.HTM
$originalURI= $_REQUEST["oldFile"];

//  NOTE: don't forget that you cannont send ANYthing, ANY text, etc before the headers. 
//        the echos are all commented out becuase of this - 12-9-2009-jmj

//   To Test:   hardcoded original URL to practice
//$originalURI = "M5111.HTM";
$originalURI =  $_SERVER["QUERY_STRING"];
echo "Original request-URI: " . $originalURI;

//  get rid of /.htm or /.html
$pattern = "/.HTM/";
$originalURI = preg_replace($pattern, "", $originalURI);



$studynumber =  $_SERVER["QUERY_STRING"] 
//echo "<BR>";

//  this is split into part1 and part2 because that is easier to read - as opposed to one long obfuscated string

$part1 = trim(substr($originalURI, 0, (strlen($originalURI)-1))) ;
//echo $part1 . "<br>";

$part2 = trim(substr($originalURI, -1));
//echo $part2 . "<br>";
					

$studynumber = $part1 . "V" . $part2;
//echo $studynumber;


Header("Location: http://www.sscnet.ucla.edu/issr/da/da_catalog/da_catalog_titleRecord.php?studynumber=$studynumber");

?> 