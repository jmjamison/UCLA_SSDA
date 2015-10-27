<?php
	// download.php
	// logs the download
	// gathers the files for download, packaging as necessary
	
	// usage: a user should come here from the disclaimer.php file
	// if not, bounce em!
	session_start();
	// print_r($_SERVER);
	// foreach ($_SERVER as $k =>$v)
	// 	echo "[{$k}] => {$v} <br />";
	logToDatabase();
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
		/("You do not have sufficient privileges to download these files");
	
	// it appears the file info's given to us in a cookie?
	$filestring = $_COOKIE['filestring'];
	if (empty($filestring))
		die("no files to process");

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
	else {
		// random tarfile name
		do {
			$rand_str = "isrdata-".date("Ymd")."-".rand_str();
			$tarfilepath = '/tmp/'.$rand_str.'.tar';
		} while (file_exists($tarfilepath));
		// echo $tarfilepath .'<br />';
		$tarcmd = "tar -cvf {$tarfilepath} ".implode(" ",$package);
		// echo $tarcmd .'<br />';
		exec($tarcmd);
		// echo 'tar done <br />';
	}

	$gzcmd = "gzip {$tarfilepath}";
	// echo $gzcmd .'<br />';
	// exec($gzcmd);
	// $gzfilepath = $tarfilepath.'.gz';
	// echo $gzfilepath .'<br />';
	// symlink
	$symlinkpath = "/var/www/html/data/packages/".basename($tarfilepath);
	$symlinkcmd = "ln -s $tarfilepath $symlinkpath";
	// echo $symlinkcmd .'<br />';
	exec($symlinkcmd);
	$symwebpath = str_replace("/var/www/html","",$symlinkpath);
	if (count($package) == 1)
	{
		// do something to the cookie
		setcookie("servefile",$symlinkpath,time()+3600,'/');
		// do something to the url
		$symwebpath = "./serve.php";
	}
	if (file_exists($tarfilepath))
		$tarfilesize = formatBytes(filesize($tarfilepath));

	// provide the package as a download
	echo "<p>Your file is available at <a href='{$symwebpath}'>{$rand_str}</a> ({$tarfilesize}) </p>";

	if (count($package) > 1)
		echo "<p><strong>Windows users:</strong> Multiple files are provided in a tar archive. If you are not familiar w/ extracting tar files, you may want to use the free utility <a href='http://www.7-zip.org/'>7-zip</a> to extract this archive file</p>";
	// disclaimer about file expiration?

	// return link?
	$returnTo = $_COOKIE['studyNumber'];
	$returnTo = $_COOKIE['returnUrl'];
	if (empty($returnTo))
		$returnTo = "http://www.sscnet.ucla.edu/issr/da/";
	echo "<p>Return to <a href='{$returnTo}'>ISR Data Archives</a></p>";
	// if all goes well, expire the file request in the cookie
	// cookies must be deleted with the same parameters they were set with except the input may be false
	
	setcookie("filestring",'',1,'/'); // expire it now	

	function rand_str($length = 8)
	{
		$chars = range("A","Z");
		$str = '';
		for ($inti = 0; $inti < $length; $inti++)
			$str .= $chars[rand(0,count($chars)-1)];
		return $str;
	}	
	
	function formatBytes($bytes, $precision = 2) { 
		$units = array('B', 'KB', 'MB', 'GB', 'TB'); 
	   
		$bytes = max($bytes, 0); 
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
		$pow = min($pow, count($units) - 1); 
	   
		$bytes /= pow(1024, $pow); 
	   
		return round($bytes, $precision) . ' ' . $units[$pow]; 
	} 	

	function logToDatabase() {
		$db = new mysqli("localhost","isrweb",'isrw3b$tats',"isrdata");
		if (mysqli_connect_error() or $db->connect_error)
			die("Error connecting to database: ".mysqli_connect_error());
		// log the base request
		// what id to use? let's use the count+1 for the id
		$result = $db->query("SELECT COUNT(*) FROM download_history");
		if ($result) {
			$count = 0;
			while ($row = mysqli_fetch_row($result))
				$count = $row[0];
			mysqli_free_result($result);
		}
		$id = $count + 1;
		$stmt = $db->prepare("INSERT INTO download_history VALUES(?,?,?,?,?,NOW(),NOW())") or die("error preparing statement");
		$stmt->bind_param("issss",$id,$_SERVER['SHIBEDUPERSONTARGETEDID'],$_SERVER['SHIBUCLAEMPLOYEEHOMEDEPARTMENTNAME'],$_SERVER['SHIBUCLAEMPLOYEEHOMEDEPARTMENTCODE'],date("Y-m-d H:i:s")) or die('error binding parameters');
		$stmt->execute();
		$stmt->close();
		$filestring = $_COOKIE['filestring'];
		if (!empty($filestring)) {
			$files = explode(";",$filestring);
			foreach ($files as $file) {
				$stmt2 = $db->prepare("INSERT INTO files_requested VALUES(?,?,NOW(),NOW())") or die("error preparing stmt2: {$db->error}");
				$stmt2->bind_param("is",$id,$file);
				$stmt2->execute();
				$stmt2->close();
			}
		}
		
		$affiliations = explode(";",$_SERVER['SHIBEDUPERSONAFFILIATION']);
		// print_r($affiliations);
		if (!empty($affiliations)) {
			foreach ($affiliations as $affiliation) {
				$stmt3 = $db->prepare("INSERT INTO affiliation VALUES(?,?,NOW(),NOW())") or die ("error preparing stmt3");
				$stmt3->bind_param("is",$id,$affiliation);
				$stmt3->execute();
				$stmt3->close();
			}
		}
		
		
		$db->close();
		return true;
	}

?>
