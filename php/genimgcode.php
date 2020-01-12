
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gallery from Folder Demo</title>
<style type="text/css">
<!--
* {box-sizing: border-box;}

body {
	font-family: Arial, Helvetica, sans-serif;
}

section {
	display: block;
	max-width: 80%;
	padding: 0 3%;
}

li{
	list-style-type:none;
	margin-right:10px;
	margin-bottom:10px;
	float:left;
}
-->
</style>
</head>

<?php

$dirname = (empty($_POST['directory'])) ? 'wp-content/uploads/2020/01/' : $_POST['directory'];

$assetsdir = (empty($_POST['assets'])) ? '/assets/images/' : $_POST['assets'];

function convert_filename_alt_title($str)
{ 
	// Convert the filename to an alt and title.
	// Replace hyphens with a space.
	$altstr = preg_replace('"-"', ' ', $str);
	// Remove the file extension.
	$altstr = preg_replace('"\.(jpg|jpeg|png|gif|svg)$"', '', $altstr);
	return $altstr;
}
?>

<body>
<section id="liquid">
	<h2>Liquid Front Matter</h2>
	<?php
		$images2 = scandir($dirname); // To do: Error handling.
		$ignore2 = array(".", "..");
		echo "<pre>\n";
		foreach($images2 as $curimg2){
			if(!in_array($curimg2, $ignore2)) {
				$altstr = (empty($_POST['alt'])) ? convert_filename_alt_title($curimg2) : $_POST['alt'];
				$title = $altstr;
				
				/* Spaces here are important. */
				echo "\n  - url: $assetsdir$curimg2\n    image_path: $assetsdir$curimg2\n    alt: \"$altstr\"\n    title: \"$title\"\n";
			}
		} 
		echo "</pre>\n";
	echo "\n";							
	?>
</section>
<hr>
<section id="images">
<h2>Images</h2>
<p>View source to get HTML code.</p>
<ul>
	<?php
		$images = scandir($dirname); // To do: Error handling.
		$ignore = array(".", "..");
		foreach($images as $curimg){
			if(!in_array($curimg, $ignore)) {
				$altstr = convert_filename_alt_title($curimg);
				$title = $altstr;
				echo "\n\t<li><a href=\"$dirname$curimg\"><img src='$dirname$curimg' alt='$altstr' title='$title' /></a></li>";
			}
		} 
		echo "\n\n"; 
	?>
</ul>
<?php
echo "\n\n"; 
?>
</section>
</body>
</html>