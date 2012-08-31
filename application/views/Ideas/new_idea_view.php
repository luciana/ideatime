<?php foreach($idea->result() as $row): ?>
<div class="well" id="voting">
	<div class="ideainfo"><span class="span10 ideaname" id="idea-name-<?php echo $row->id?>"><?php echo $row->name ?> </span></div>
</div>
<?php endforeach; ?>
