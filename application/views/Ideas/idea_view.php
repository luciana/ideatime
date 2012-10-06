<div id="voting2">
<?php foreach($ideas as $row): ?>  
	 <?php if(!empty($row->name)): ?>
		<div class="well idea-cell" id="ideacell-<?php echo $row->id ?>">  			
			<div class="alert alert-error span12 idea-error" id="idea-error-<?php echo $row->id ?>">></div>
			<div class="span1">
				<button class="votegoodbutton btn btn-inverse" id="voteGood-<?php echo $row->id ?>"  value="<?php echo $row->id ?>" >
					<i class="icon-thumbs-up icon-white"></i>
					<?php $good =  !empty($row->vGood) ? $row->vGood : 0 ?>
					<span class="votecount" id="idea-good-id-<?php echo $row->id ?>"><?php echo $good ?></span>
				</button>
			</div> 
			<div class="span1">
				<button class="votebadbutton btn btn-inverse" id="voteBad-<?php echo $row->id ?>" value="<?php echo $row->id ?>" >
					<i class="icon-thumbs-down icon-white"></i>
					<?php $bad =  !empty($row->vBad) ? $row->vBad : 0 ?>
					<span class="votecount" id="idea-bad-id-<?php echo $row->id ?>"><?php echo $bad ?></span>
				</button>
			</div>			
				<div class="total-score">
					<span class="voter pink clearfix" id="idea-total-id-<?php echo $row->id ?>"><?php echo ($good -$bad) ?></span>				
				</div>		
			<div class="ideainfo"><span class="span10 ideaname" id="idea-name-<?php echo $row->id ?>"><?php echo $row->name ?> </span></div>				
			<br>
			<div class="ideainfo" style="color:black" id="ideacell-<?php echo $row->id ?>"> <button class="commentcell" id="commentbutton-<?php echo $row->id ?>"> Show Comments</button> </div>	
				<div class="well well-small clearfix comment-area dropdown-toggle" data-toggle="dropdown" id="comment-area-<?php echo $row->id ?>" >
					<div class="alert" style="margin-bottom: 2px;">
						<form class="form" id="comment-form-<?php echo $row->id ?>">					
						<input class="span12" type="text" id="comment-add-<?php echo $row->id ?>" placeholder="add your comment..."></textarea>
						</form>
					</div>
					<div class="alert comments" id="comments-<?php echo $row->id ?>" style="margin-bottom: 2px;"></div>	
								
				</div>
							
		</div>    	
	<? endif; ?>
<? endforeach; ?>
</div>