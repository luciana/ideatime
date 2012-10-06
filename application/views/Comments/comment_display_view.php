<div id="comments">
<?php foreach($comments as $row): ?>  
				<div class="alert" style="margin-bottom: 2px;">
					<?php echo $row->body ?>
				</div>	
<?php endforeach; ?>
</div>