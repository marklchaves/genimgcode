<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>The Code - Generate Img Code</title>
	<link rel="stylesheet" href="genimgcode.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>
</head>

<?php

$dirname = (empty($_POST['directory'])) ? 'wp-content/uploads/2020/01/' : $_POST['directory'];
$assetsdir = (empty($_POST['assets'])) ? '/assets/images/' : $_POST['assets'];
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
		if (is_dir($dirname)) {
			$images2 = scandir($dirname); // To do: Error handling.
			echo "<pre id='liquid-code'>\n";
			foreach ($images2 as $curimg2) {
				if (!in_array($curimg2, $ignore)) {
					$altstr = (empty($_POST['alt'])) ? convert_filename_alt_title($curimg2) : $_POST['alt'];
					$title = $altstr;

					/* Spaces here are important. */
					echo "\n  - url: $assetsdir$curimg2\n    image_path: $assetsdir$curimg2\n    alt: \"$altstr\"\n    title: \"$title\"";
				}
			}
		}
		echo "</pre>\n";
		echo '<button class="button" onclick="alert(\'Copied\')" class="button" id="liquid-button" data-clipboard-target="#liquid-code">Copy</button>';
		echo "\n\n";
		?>
	</section>

	<section id="html">
		<h2>HTML</h2>
			<?php
			if (is_dir($dirname)) {
				$images = scandir($dirname); // To do: Error handling.
				echo "<pre id='html-code'>\n";
				foreach ($images as $curimg) {
					if (!in_array($curimg, $ignore)) {
						$altstr = (empty($_POST['alt'])) ? convert_filename_alt_title($curimg) : $_POST['alt'];
						$title = $altstr;
						$dispstr = htmlspecialchars("<a href=\"$dirname$curimg\">\n  <img src=\"$dirname$curimg\"\n  alt=\"$altstr\"\n  title=\"$title\"></a>", ENT_QUOTES);
						echo "\n" . $dispstr;
					}
				}
			}
			echo "</pre>\n";
			echo '<button class="button" onclick="alert(\'Copied\')" class="button" id="html-button" data-clipboard-target="#html-code">Copy</button>';
			echo "\n\n";
			?>
	</section>
	<section id="images">
		<h2>Images</h2>
		<ul>
			<?php
			$img_width = '320px';
			if (is_dir($dirname)) {
				$images = scandir($dirname); // To do: Error handling.
				foreach ($images as $curimg) {
					if (!in_array($curimg, $ignore)) {
						$altstr = (empty($_POST['alt'])) ? convert_filename_alt_title($curimg) : $_POST['alt'];
						$title = $altstr;
						echo "\n\t<li><a href=\"$dirname$curimg\"><img src=\"$dirname$curimg\" alt=\"$altstr\" title=\"$title\" width=\"$img_width\"/></a></li>";
					}
				}
			}
			else {
				echo '<li><span class="error-text">Directory ' . $dirname . ' is empty or invalid.</span></li>';
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