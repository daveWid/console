<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Kohana::$charset; ?>" />
	<title><?php echo $title; ?></title>

	<link type="text/css" href="/console/media/css/reset.css" rel="stylesheet" media="screen" />
	<link type="text/css" href="/console/media/css/console.css" rel="stylesheet" media="screen" />

	<script type="text/javascript" src="/console/media/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="/console/media/js/console.js"></script>
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