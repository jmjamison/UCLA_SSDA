<?php
	// download.php
	// logs the download
	// gathers the files for download, packaging as necessary
	
	$filestring = $_POST['files'];
	setcookie('filestring', $_POST['files']); // 86400 = 1 day
	
	$_COOKIE['filestring'] = $_POST['files'];
	//setcookie("TestCookie", $value, time()+3600, "/~rasmus/", "example.com", 1);

// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
// setcookie("Ordering", $_POST['ChangeOrdering'], time() + 31536000);
	
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

	echo "<br>filestring: " . $filestring . "<br>";
	//$filestring = $_COOKIE['filestring'];
	
	
	

	echo "<br>cookie variable: " . $_COOKIE['filestring'] . "<br>";

	echo "<br>http: " . $HTTP_COOKIE_VARS['filestring'] . "<br>";


	// Another way to debug/test is to view all cookies
	echo "print-r: ";
	print_r($_COOKIE) . "<br>";


// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day


if(!isset($_COOKIE['filestring'])) {
    echo "<br>Cookie named: filestring is not set!";
} else {
    echo "<br>Cookie filestring is set!<br>";
    echo "<br>Value is: " . $_COOKIE['filestring'];
}


	// echo 'Hello ' . htmlspecialchars($_COOKIE["name"]) . '!';
	//  $_COOKIE[$cookie_name];
	
	// usage: a user should come here from the disclaimer.php file
	// if not, bounce em!
	//session_start();
	// print_r($_SERVER);
	// foreach ($_SERVER as $k =>$v)
	// 	echo "[{$k}] => {$v} <br />";
	
	//logToDatabase();
	// echo "deptcode:" .$_SERVER['SHIBUCLAEMPLOYEEHOMEDEPARTMENTCODE'].'<br />';
	// echo "deptname:" .$_SERVER['SHIBUCLAEMPLOYEEHOMEDEPARTMENTNAME'].'<br />';
	// die();
	//if ($_SERVER['HTTP_REFERER'] != 'https://eve.ats.ucla.edu/data/disclaimer.php')
	//{
		//die("You have reached this page in the wrong order. Please make sure you have read the disclaimer and agreed to the terms of use."); // some error condition
	//}
	// is the user logged in?
	//if (!($_SERVER['SHIBEDUPERSONTARGETEDID']) or empty($_SERVER['SHIBEDUPERSONTARGETEDID']))
	//{
		//die("Error verifying you are logged in. Please re-login and try again"); // another error condition
	//}
	// TODO: verify the affiliation status is not 'affiliate'; if so, bounce em!
	//if (empty($_SERVER['SHIBEDUPERSONAFFILIATION']))
		//die('You do not have sufficient privielges to download these files.');
	//$affiliations = explode(";",$_SERVER['SHIBEDUPERSONAFFILIATION']);
	//if (array_search('member',$affiliations) === false)
		//("You do not have sufficient privileges to download these files");
	
	// it appears the file info's given to us in a cookie?
	//$filestring = $_COOKIE['filestring'];
	//if (empty($filestring))
		//die("no files to process");

	echo "<p><strong>The following files are being packaged</strong></p>";
	// what are the files to package?
	$files = explode(";",$filestring);
	$notfound = array();
	$package = array();
	echo "<ul>";
	foreach ($files as $file) {
		$args = explode(".",$file);
		array_shift($args);
		array_shift($args);
		echo '<li>'.implode(".",$args).'</li>';
		$basefolder = substr($file,0,4);
		$filepath = dirname(__FILE__).'/'.$basefolder.'/'.strtok($file,'(');
		$filepath = '/data/'.$basefolder.'/'.strtok($file,'(');
		// echo "<li>{$filepath}</li>";
		if (file_exists($filepath))
		{
			// echo $filepath.'<br />';
			$package[] = '/data/'.$basefolder.'/'.strtok($file,'(');
		}
		else
			$notfound[] = $file; // echo 'missing: '.$filepath .'<br />';
		// echo '<br />';
	}
	echo "</ul>";
	
	// files not found
	if (count($notfound) > 0) {
		echo "<p><strong>Warning:</strong> You have requested files which could not be found: </p>";
		echo "<ul>";
		foreach ($notfound as $file)
			echo "<li>{$file}</li>";
		echo "</ul>";
	}	
	// package the files
	
	// is this a single file?
	// if so, do not package
	if (count($package) == 1)
	{
		$cpfilepath = '/tmp/'.basename($package[0]);
		// echo $cpfilepath .'<br />';
		$cpcmd = "cp {$package[0]} {$cpfilepath}";
		// echo $cpcmd .'<br />';
		exec($cpcmd);
		// some variable name matching 
		$tarfilepath = $cpfilepath;
		$rand_str = basename($package[0]);
		$args = explode(".",basename($package[0]));
		array_shift($args);
		array_shift($args);
		$rand_str = implode(".",$args);
	}
	//else {
		// random tarfile name
		//do {
			//$rand_str = "isrdata-".date("Ymd")."-".rand_str();
			//$tarfilepath = '/tmp/'.$rand_str.'.tar';
		// while (file_exists($tarfilepath));
		// echo $tarfilepath .'<br />';
		//$tarcmd = "tar -cvf {$tarfilepath} ".implode(" ",$package);
		// echo $tarcmd .'<br />';
		//exec($tarcmd);
		// echo 'tar done <br />';
	//}

	//$gzcmd = "gzip {$tarfilepath}";
	// echo $gzcmd .'<br />';
	// exec($gzcmd);
	// $gzfilepath = $tarfilepath.'.gz';
	// echo $gzfilepath .'<br />';
	// symlink
	//$symlinkpath = "/var/www/html/data/packages/".basename($tarfilepath);
	//$symlinkcmd = "ln -s $tarfilepath $symlinkpath";
	// echo $symlinkcmd .'<br />';
	//exec($symlinkcmd);
	//$symwebpath = str_replace("/var/www/html","",$symlinkpath);
	//if (count($package) == 1)
	//{
		// do something to the cookie
		//setcookie("servefile",$symlinkpath,time()+3600,'/');
		// do something to the url
		//$symwebpath = "./serve.php";
	//}
	//if (file_exists($tarfilepath))
		//$tarfilesize = formatBytes(filesize($tarfilepath));

	// provide the package as a download
	//echo "<p>Your file is available at <a href='{$symwebpath}'>{$rand_str}</a> ({$tarfilesize}) </p>";

	//if (count($package) > 1)
		//echo "<p><strong>Windows users:</strong> Multiple files are provided in a tar archive. If you are not familiar w/ extracting tar files, you may want to use the free utility <a href='http://www.7-zip.org/'>7-zip</a> to extract this archive file</p>";
	// disclaimer about file expiration?

	

	
	
?>

</body>
</html>