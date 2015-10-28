<?php
	/*
	disclaimer.php
	displays disclaimer before user downloads files
	*/
		$filestring = $_POST['files'];
	$_COOKIE['filestring'] = $_POST['files'];
	// some initial variable checking to assert the files for download
	// print_r($_COOKIE);
	$filestring = $_COOKIE['filestring'];
	if (empty($filestring))
		die("ERROR: No files to process");
	// display the disclaimer readme
?>
<html>
<head>
<title>ISSR/DA</title>
</head>
<body>
<h1>Social Science Data Archives <br />
Data Delivery System</h1>
<br />
<h2>File(s): <br /> <?php 
	$files = explode(";",$filestring);
	foreach($files as $file)
	{
		$args = explode(".",$file);
		array_shift($args);
		array_shift($args);
		echo implode(".",$args).'<br />'; 
	}
?></h2>
<h3>General Licensing and Restrictions:</h3>
<p>Unless explicitly stated otherwise, all data sets provided on this website are for the use of UCLA faculty, students and staff. The use of this data is solely for research and instructional purposes. US Copyright Law (Title 17 U.S. Code) and University Licensing agreements govern the use of the data. Users are responsible for obtaining any required authorization or exemption to use data sets provided on this web site. Individuals are liable for any infringement of this law or agreements.</p>
<h3>Agreement and Disclaimer:</h3>
<p>By downloading these data you signify that you agree not to duplicate, reproduce, share or redistribute the data in whole or in part to anyone. The inclusion of small, limited quantities of these data in research communications, scholarly papers, journals, and the like is permitted, but the authors of these communications and documents are required to cite the source of these data. U.S. Copyright Law (Title 17 U.S. Code) and University of California Licensing agreements govern the use of the data. Individuals using these data are liable for any infringement of these laws and agreements. You also agree to the following conditions: The use of this data is solely for non-profit scientific, scholarly research and instructional purposes. You will not use or permit others to use data in any other way except for these purposes. These data are supplied as publicly available data. You will not attempt to link items in the data with any individually identifiable records. You will not use the data to identify an individual or organization. These data are supplied to you &quot;as is&quot;. Neither the investigators, nor the University of California makes any guarantee concerning the accuracy of the information contained in the data. The University of California further makes no warranties, either expressed or implied, as to any other matter whatsoever, including, without limitation, the condition of the data, or their fitness for any particular purpose. The burden for fitness lies entirely with the user. In no event shall the University of California have any liability whatsoever for payment of any consequential, incidental, indirect, or special damages of any kind, including but not limited to, any loss arising out of the use of or reliance on the data, or arising out of the delivery, installation, operation, or support by the University of California.
</p>
<p>If you have read and understood the above agreement and agree to abide by its terms, click on the &quot;I Agree&quot; button.</p>
<form action='variableDownload.php' method='POST'>
<input type="submit" name="agree_button" value="I Agree" />
<INPUT NAME="files" VALUE='<? echo $filestring; ?>'>
</form>
<h3>Other Alternatives</h3>
<p>There are alternative methods to get the file you want. Many files are available directly from the <a href="http://www.icpsr.umich.edu/">Inter-university Consortium for Political and Social Research</a>. Or you can contact <a href="mailto:libbie@ucla.edu">Libbie Stephenson</a> or phone (310)825-0716.</p>
<hr />
<p><em><?php echo date("dMY"); ?></em></p>
<p class='smalltext' style='font-size:0.8em;'>This data delivery system is provided by the <a href="http://www.oit.ucla.edu/">UCLA Office of Information Technology</a> in cooperation with the <a href="http://www.sscnet.ucla.edu/issr/da/">UCLA Social Science Data Archives</a></p>
</body>
</html>
