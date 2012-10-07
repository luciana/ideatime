 <div class="row-fluid">                    
    <h3 class="pink">Create an Event</h3> 
    <div class="well">
       <a href=<?php echo '"' . site_url('meetup/meetup_get_event') . '" class="uppercase">'?> View Event</a>

    <?php 
    if (!empty($_SESSION['meetup_member_id'])) {    		
    	?>
  		 <a href=<?php echo '"' . site_url('meetup/meetup_get_events') . '" class="uppercase">'?> View Events</a>
      
     <?php } else { ?>            
       <a href=<?php echo '"' . site_url('meetup/meetup_login') . '" class="uppercase">'?> Sign in to MeetUp</a>
       <?php } ?>
    </div>                 
</div>
          