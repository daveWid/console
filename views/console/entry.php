<ul id="log">
<?php foreach($log as $row): ?>
	<li class="entry <?php echo $row['type']; ?>">
		<div class="message">
			<span class="date"><?php echo Date::formatted_time($row['date'], "F jS, Y H:i:s"); ?></span> -
			<?php echo $row['message']; ?>
		</div>

	<?php if (isset($row['stacktrace'])): ?>
		<div class="stacktrace">
			<h6>Stack Trace</h6>
			<ul>
		<?php foreach($row['stacktrace'] as $trace): ?>
				<li><?php echo $trace; ?></li>
		<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	</li>

<?php endforeach; ?>
</ul>
