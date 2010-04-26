<div class="directory">
<?php foreach( $dir as $year => $months ): ?>
	<h2><?php echo $year; ?></h2>
	<div class="year">
		<?php foreach( $months as $month => $days ): ?>
		<div class="month">
			<h3><?php echo Console::get_month($month); ?></h3>
			<ul class="files">
			<?php
				foreach( $days as $day => $file )
				{
					$li = '';

					$li .= ( $active && $year.'/'.$month == $active['dirname'] && $day == $active['filename'] ) ?
						'<li class="active">' : '<li>' ;

					$uri = Request::instance()->uri(array('file' => $file));
					$li .= HTML::anchor($uri, $day).'</li>';
					echo "\t$li\n";
				}
			?>
			</ul>
		</div>
		<?php endforeach; ?>
	</div>
<?php endforeach; ?>
</div>
