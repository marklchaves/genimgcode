<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>The Code - Generate Img Code</title>
	<link rel="stylesheet" href="genimgcode.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>
</head>

<?php

$def_inputdir = '/wp-content/uploads/2020/01/';
$def_outputdir = '/assets/images/';
$def_reldir = '..';

$dirname = (empty($_POST['directory'])) ? $def_inputdir : $_POST['directory'];
$inputdir = $def_reldir . $dirname;

$assetsdir = (empty($_POST['assets'])) ? $def_outputdir : $_POST['assets'];

$ignore = array(".", "..", ".DS_Store");

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
	<header>
		<h1>Generate Img Code</h1>
		<p><a class="fancy-link" href="genimgcode.html">Settings</a></p>
		<h2>The Code</h2>
	</header>
	<section id="liquid">
		<h2>Liquid Front Matter</h2>
		<?php
		if (is_dir($inputdir)) {
			$images2 = preg_grep('~\.(jpeg|jpg|png|gif|svg)$~', scandir($inputdir)); // To do: Error handling.
			if (count($images2) > 0) {
				echo "<pre id='liquid-code'>\n";
				foreach ($images2 as $curimg2) {
					if (!in_array($curimg2, $ignore)) {
						$altstr = (empty($_POST['alt'])) ? convert_filename_alt_title($curimg2) : $_POST['alt'];
						$title = $altstr;

						/* Spaces here are important. */
						echo "\n  - url: $assetsdir$curimg2\n    image_path: $assetsdir$curimg2\n    alt: \"$altstr\"\n    title: \"$title\"";
					} // if
				} // foreach
				echo "</pre>\n";
				echo '<button class="button" onclick="alert(\'Copied\')" class="button" id="liquid-button" data-clipboard-target="#liquid-code">Copy</button>';
			} // if
			else {
				echo '<p><span class="error-text">I got nada.</span></p>';
			}
		} // if
		echo "\n\n";
		?>
	</section>

	<section id="html">
		<h2>HTML</h2>
			<?php
			if (is_dir($inputdir)) {
				$images = preg_grep('~\.(jpeg|jpg|png|gif|svg)$~', scandir($inputdir));
				if (count($images) > 0) {
					echo "<pre id='html-code'>\n";
					foreach ($images as $curimg) {
						if (!in_array($curimg, $ignore)) {
							$altstr = (empty($_POST['alt'])) ? convert_filename_alt_title($curimg) : $_POST['alt'];
							$title = $altstr;
							$dispstr = htmlspecialchars("<a href=\"$dirname$curimg\">\n  <img src=\"$dirname$curimg\"\n  alt=\"$altstr\"\n  title=\"$title\"></a>", ENT_QUOTES);
							echo "\n" . $dispstr;
						}
					} // foreach
					echo "</pre>\n";
					echo '<button class="button" onclick="alert(\'Copied\')" class="button" id="html-button" data-clipboard-target="#html-code">Copy</button>';
				} // if
				else {
					echo '<p><span class="error-text">I got zip.</span></p>';
				}
			}
			echo "\n\n";
			?>
	</section>
	<section id="images">
		<h2>Images</h2>
		<ul>
			<?php
			$img_width = '320px';
			if (is_dir($inputdir)) {
				$images = preg_grep('~\.(jpeg|jpg|png|gif|svg)$~', scandir($inputdir));
				if (count($images) > 0) {
					foreach ($images as $curimg) {
						if (!in_array($curimg, $ignore)) {
							$altstr = (empty($_POST['alt'])) ? convert_filename_alt_title($curimg) : $_POST['alt'];
							$title = $altstr;
							echo "\n\t<li><a href=\"$dirname$curimg\"><img src=\"$dirname$curimg\" alt=\"$altstr\" title=\"$title\" width=\"$img_width\"/></a></li>";
						}
					}
				}
				else {
					echo '<li><span class="error-text">Directory ' . $dirname . ' has no images.</span></li>';
				}
			}
			else {
				echo '<li><span class="error-text">There is something wrong with directory ' . $dirname . '. Maybe it doesn\'t exist?</span></li>';
			}
			echo "\n\n";
			?>
		</ul>
		<?php
		echo "\n\n";
		?>
	</section>
	<script>
		(function() {
			new ClipboardJS('#liquid-button');
			new ClipboardJS('#html-button');
		})();
	</script>
</body>

</html>