<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Kohana::$charset; ?>" />
	<title><?php echo $title; ?></title>

	<?php foreach($css as $file => $media) echo HTML::style($base . $file, array('media' => $media)); ?>

	<?php foreach($js as $file) echo HTML::script($base . $file); ?>
</head>
<body>
	<div id="header">
		<div class="box">
			<h1>Console</h1>
		</div>
	</div>

	<div id="page">
		<div class="box" id="two-col">

			<h1><?php echo $headline; ?></h1>

			<table cellspacing="0">
				<tr>
					<td id="content">
						<?php echo $content; ?>
					</td>
					<td id="right">
						<?php echo $right; ?>
					</td>
				</tr>
				<tr id="footer">
					<td class="left">Console: Developed by <a href="http://www.davewidmer.net">Dave Widmer</a></td>
					<td class="right">Powered by <a href="http://www.kohanaphp.com">Kohana</a> v3.0</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>