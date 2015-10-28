<?php
	// serve.php
	// serve the requested file
	
	session_start();

	// the requested file is?
	$file = $_COOKIE['servefile'];
	if (empty($file))
		die("Error: No file specified");

	if (!file_exists($file)) 
		die("Error: file does not exist");	

	// expire the cookie
	setcookie("servefile",'',1,'/');

	// serve the file
	header('Content-Disposition: attachment; filename="'.basename($file).'"');

	readfile($file);

?>
