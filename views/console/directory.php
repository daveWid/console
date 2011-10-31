<?php $route = Route::get('console'); ?>

<div class="directory">
<?php foreach($dir as $year => $months): ?>
	<h2><?php echo $year; ?></h2>
	<div class="year">
		<?php foreach($months as $month => $days): ?>
		<div class="month">
			<h3><?php echo Console::get_month($month); ?></h3>
			<ul class="files">
			<?php foreach($days as $day => $file): ?>
				<li class="<?php
					if (Console::is_active($active, $year, $month, $day))
					{
						echo "active";
					}
				?>">
					<?php echo HTML::anchor($route->uri(array('file' => $file)), $day); ?>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
		<?php endforeach; ?>
	</div>
<?php endforeach; ?>
</div>
