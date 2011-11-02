<ul id="log">
<?php foreach($log as $row): ?>
	<li class="entry <?php echo $row['type']; ?>">
		<div class="message">
			<span class="date"><?php echo Date::formatted_time($row['date'], "F jS, Y H:i:s"); ?></span> -
			<?php echo $row['log']; ?>
		</div>
	</li>

<?php endforeach; ?>
</ul>
