<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Kohana::$charset; ?>" />
	<title><?php echo $title; ?></title>

	<?php foreach($css as $file => $media) echo HTML::style($file, array('media' => $media)), "\r\n"; ?>

	<?php foreach($js as $file) echo HTML::script($file), "\r\n"; ?>

	<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
	<header>
		<h1><?php echo HTML::anchor(Route::get('console')->uri(array('file'=>NULL)), 'Console'); ?></h1>
	</header>

	<div id="page">
		<h1 class="half-bottom-margin"><?php echo $headline; ?></h1>

		<aside id="sidebar">
			<?php echo $right; ?>
		</aside>
		<div id="content">
			<?php echo $content; ?>
		</div>
	</div>

	<footer>
		<div class="right">
			Powered by <a href="http://www.kohanaphp.com">Kohana</a> v<?php echo Kohana::VERSION; ?>
		</div>
		Console: Developed by <a href="http://www.davewidmer.net">Dave Widmer</a>
	</footer>
</body>
</html>
