<div id="voting2">
<?php foreach($ideas as $row): ?>  
			 <?php if(!empty($row->name)): ?>
					<div class="well">  
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
							<span class="voter" style="color:black" id="idea-total-id-<?php echo $row->id ?>"><?php echo ($good -$bad) ?></span>
					</div>

					<div class="ideainfo"><span class="span10 ideaname" id="idea-name-<?php echo $row->id ?>"><?php echo $row->name ?> </span></div>	
                	</div>
			<? endif; ?>
<? endforeach; ?>
</div>