<div class="row-fluid">  	
		<div class="well">
        <h3 class="pink">My Groups</h3> 
		<div class="row-fluid">  
        <?php
		foreach ($groups as $group)
		{ ?>
		   <div class="well <?php echo $class ?>">
		   	<div class="span3">
		   		<img src="#" class="img-polaroid thumbnail">
		   	</div>
  			<div class="span9">		   	
		    	<h3><a href="<?php echo site_url('ideas/single/'.$group->groups_id)?>" id="group-<?php echo $group->id ?>"><?php echo $group->name; ?> Group</a></h3>		    
		    </div>
		   </div>
		   <?php
		}
		?>
		</div>
	</div>
	</div>     
</div>