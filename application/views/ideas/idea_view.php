<?php 
$count = 0;
foreach($ideas as $row): ?>  		
	 <?php if(!empty($row->name)): ?>		 	
		 <?php 
			$position ='';
		 	
		 	if ($count % $perpage){
		 		$position = 'style="margin-left:0";';
		 	}
		 	if ($count == $start){ 
		 		$active = '';
		 		
		 		if($count==$start_active) { 
		 			$active = 'active'; 		 			
		 		}
		 	?>
			<div class="<?php echo $active ?> item">  	
			 <ul class="thumbnails"> <?php } ?>				
              <li class="well thumbnail span12" <?php echo $position ?> >
                    <div class="alert caption"><h3 class="ideaname" id="idea-name-<?php echo $row->id ?>"><?php echo $row->name; ?> </h3></div>
                    <div class="alert alert-error idea-error" id="idea-error-<?php echo $row->id ?>">></div>
					<div class="span2">					
						<button class="votegoodbutton btn btn-inverse" id="voteGood-<?php echo $row->id ?>"  value="<?php echo $row->id ?>" >
							<i class="icon-thumbs-up icon-white"></i>
							<?php $good =  !empty($row->vGood) ? $row->vGood : 0 ?>
							<span class="votecount" id="idea-good-id-<?php echo $row->id ?>"><?php echo $good ?></span>
						</button>
					</div> 
					<div class="span2">
						<button class="votebadbutton btn btn-inverse" id="voteBad-<?php echo $row->id ?>" value="<?php echo $row->id ?>" >
							<i class="icon-thumbs-down icon-white"></i>
							<?php $bad =  !empty($row->vBad) ? $row->vBad : 0 ?>
							<span class="votecount" id="idea-bad-id-<?php echo $row->id ?>"><?php echo $bad ?></span>
						</button>
					</div>										
					<div class="total-score">
							<span class="voter pink clearfix" id="idea-total-id-<?php echo $row->id ?>"><?php echo ($good -$bad) ?></span>				
					</div>
											
					<div class="ideainfo" style="color:black" id="ideacell-<?php echo $row->id ?>">  </div>	
					<div class="well well-small clearfix comment-area dropdown-toggle" data-toggle="dropdown" id="comment-area-<?php echo $row->id ?>" >
						<div class="alert" style="margin-bottom: 2px;">
							<form class="form" id="comment-form-<?php echo $row->id ?>">					
							<input class="span12" type="text" id="comment-add-<?php echo $row->id ?>" placeholder="add your comment..."></textarea>
							</form>
						</div>
						<div class="alert comments" id="comments-<?php echo $row->id ?>" style="margin-bottom: 2px;"></div>											
					</div>
			  </li>	
			 <?php if ($count == $end){ 
	  			$start = $count + 1;
	  			$end = ($start + $perpage) -1; 
	  			?>
			  	</ul>	
			  	</div>  
			  	<?php }?>				
			  	
		<? endif; ?>
		<?php $count += 1; ?>
<? endforeach; ?>

			
 
							