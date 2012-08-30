  <div id="voting" class="well"> 
	 <?php foreach($ideas as $row): ?>  
			 <?php if(!empty($row->name)): ?>
					<div id="voting" class="well">  

					<div class="ideainfo"><span class="span10 ideaname" id="idea-name-<?php echo $row->id ?>"><?php echo $row->name ?> </span></div>	
                	</div>
			<? endif; ?>
	<? endforeach; ?>
</div>