<?php

	//session_start();
	// get.php
	// gets the filenames listed
	// sets a cookie variable for the filenames
	// redirects to the shibboleth protected folder
	
	// usage, the initial target of the ISR website
	// expectations:
	// isr website provides the requested variables in a http post value
	// a string of semi-colon delimited filenames
	// e.g: file1;file2;file3

	$techInfo = $_SERVER['HTTP_REFERER'];
	setcookie("returnUrl",$techInfo,time()+3600,'/');	
	$filestring = $_POST['files'];
	echo "<br>" . $filestring . "<br>";
	setcookie("filestring",$filestring,time()+3600,'/');
	
	//$_SESSION['filestring'] = $filestring;
	
	
	// $filestring = "DTA099.file0001.DATACCTP.CENSUA(I7698V1);DTA099.file0002.SPSSCCTP.CENSUA(I7698V1);DTA099.file0003.DATACCTP.CENSUB(I7698V1);DTA099.file0004.SPSSCCTP.CENSUB(I7698V1)"; // for testing

	//if (empty($filestring))
	//{
		//die("ERROR: You did not request any files!"); // some error situation
	//}
	// set the cookie
	// expires in 1 hr - is this enough time?
	
	
	// redirect to shibboleth folder
	//header('Location:https://eve.ats.ucla.edu/data/disclaimer.php');
	//exit();
	
	echo  $_COOKIE['filestring'];
	//echo $_SESSION['filestring'];
	
	//unset $_SESSION['filestring'];
	//session_destroy();
?>