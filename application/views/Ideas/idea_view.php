

<?php 
	$page = $this->idea_model->page_active;
	$perpage = $this->idea_model->max_rows;

	$active = $_SESSION['active_group_id'];
	if ($page > $this->idea_model->get_total_pages($_SESSION['active_group_id'])){
		$this->idea_model->set_page_active(1);
		$page = $this->idea_model->page_active;
	}

	$active_ideas = $this->idea_model->get_ideas_page($page, $active);
	$ideas = $this->idea_model->get_idea_by_group($active);	
	
	//$start = ($end - $perpage) + 1;
	$start_active =0;
	$start = $start_active;
	$end =  ($start + $perpage) -1;
?>
<?php $count = 0; ?>

<?php foreach($ideas as $row): ?>  		
	 <?php if(!empty($row->name)): ?>		 	
		 <?php 
			$position ='';
		 	if($count % 3 ==0){
		 		$position ="style='margin-left:0px;'";
		 	}
		 	if ($count == $start){ 
		 		$active = '';
		 		
		 		if($count==$start_active) { 
		 			$active = 'active'; 		 			
		 		}
		 	?>
			<div class="<?php echo $active ?> item">  	
			 <ul class="thumbnails">				
		 <?php } ?>				
              <li class="well thumbnail span4" <?php echo $position ?> >
                    <div class="alert caption"><h3 class="ideaname" id="idea-name-<?php echo $row->id ?>"><?php echo $row->name ?> </h3></div>
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
			<br class="clearfix">	
			<br class="clearfix">	
			<br class="clearfix">					
			<div class="well well-small clearfix" id="comment-area-<?php echo $row->id ?>" >
				<div class="alert" style="margin-bottom: 2px;">
					<form class="form" id="comment-form-<?php echo $row->id ?>">					
					<input class="" type="text" id="comment-add-<?php echo $row->id ?>" placeholder="add your comment..."></textarea>
					</form>
				</div>
				<div class="alert" style="margin-bottom: 2px;">
					<button type="button" class="close" data-dismiss="alert">×</button>
					This is a great idea.. I think we should continue adding more info 
				</div>				
			</div>
              </li>
              
		  <?php if ($count == $end){ 
		  		$start = $count + 1;
		  		$end = ($start + $perpage) -1; 
		  		?>
		  		</ul>
			</div>					
		 <?php } ?>		
	<? endif; ?>
	<?php $count += 1; ?>
<? endforeach; ?>
 
