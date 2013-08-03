 <?php $this->load->view('common/header') ?>
<div class="container-fluid">  <?php
  //User is only in one group - show idea page           
  $this->load->view('forms/idea_form_view', $groups);           
  ?>    

  <div class="row-fluid">        
      <h2>Vote for the idea</h2>        
      <div id="myCarousel1" class="carousel1 slide1">                                              
               <?php              
                     if(count($ideas)>0){ 
                        $data = array(
                          'ideas' => $ideas,
                          'start' => 0,
                          'start_active' => 0,
                          'end'=> $this->idea_model->max_rows -1,
                          'perpage' => $this->idea_model->max_rows
                          );          
                      $this->load->view('ideas/idea_view', $data);
                }else{
                   
                  ?> <div class="alert caption"> Ideas have been archived.  
                  <a name="archive-ideas" href=<?php echo '"' . site_url('ideas/archive/'.$_SESSION['active_group_id']) . '" class="uppercase">'?> View Archived Ideas </a>   
                  </div><?php
                }?>                         
     </div>
  </div>
</div> 

<script type="text/javascript">
var page = 1;

$(document).ready(function() {
  $(".idea-error").hide();
  //$(".comment-area").hide();    

$('.ideainfo').each(function() {
    var id = $(this).attr('id');
    var temp = id.indexOf('-');
    var ideaId = id.substring(temp+1);
    var _data = {
        idea: ideaId,
        ajax:1
      };

    var commentBlock =  "#comment-area-" + ideaId;
    var commentID = "#comments-" + ideaId;
    var dropdown = "#dropdown" + ideaId;

    $.ajax({
      url: "<?php echo site_url('comments/get_for_idea'); ?>",
      type: 'POST',
      data: _data,
      success: function(msg) {
        $(".idea-error").hide();
        $(commentBlock).show();
        $(commentID).html(msg);
      },
      error: function() {
        alert("SHIIT");
      }
      
    });
});





$('.form').bind('keypress', function(e) {
        if(e.keyCode==13){
              e.preventDefault();
              $(".idea-error").hide();
              var id = $(this).attr('id');
              var temp = id.indexOf('-');
              var id2 = id.substring(temp+1);
              var temp2 = id2.indexOf('-');
              var ideaId = id2.substring(temp2+1);
              var commentBody = "#comment-add-" + ideaId;

              var form_data = {
                id: ideaId,
                body: $(commentBody).val(),
                userID: "<?php echo $_SESSION['user_id'] ?>",
                ajax:1
              };

            var commentBlock =  "#comment-area-" + ideaId;
            var commentID = "#comments-" + ideaId;

            $.ajax({
              url: "<?php echo site_url('comments/insert'); ?>",
              type: 'POST',
              data: form_data,
              success: function(msg) {
                $(".idea-error").hide();
                $(commentID).append(msg);
                $(commentBody).val('');
              },
              error: function() {
                alert("SHIIT");
              }
              
            });

            return false;             
        }
});

 $('#sendIdea').click(function() {
  
  var idea = $('#ideaName').val();  
  if (!idea || idea == 'what is the idea name?') {
    alert('Please enter your idea');
    return false;
  }
  
  var form_data = {
    idea: idea,
    author: "<?php echo $_SESSION['username'] ?>",
    group: "<?php echo $_SESSION['active_group_id'] ?>", 
    ajax: "1"   
  };
  
  $.ajax({
    url: "<?php echo site_url('ideas/submit'); ?>",
    type: 'POST',
    data: form_data,
    success: function(msg) {
      $('#voting').append(msg);
      $('#ideaName').val('what is the idea name?');
      $(".idea-error").hide();
    }
  });
  
  return false;
});

$('.votegoodbutton').live("click", function() {  
  var id = $(this).attr("id");
  var temp = id.indexOf('-');
  var ideaId = id.substring(temp+1);
  $(".idea-error").hide();
  if (!ideaId || ideaId < 0) {
    return false;
  }
  
  var form_data = {
    field: 'good',
    id: ideaId,
    ajax: '1'   
  };
  var spanId = '#idea-good-id-' + ideaId;
  var errorId = '#idea-error-'+ ideaId;
  
    $.ajax({
    url: "<?php echo site_url('ideas/post_vote'); ?>",
    type: 'POST',
    data: form_data,
    success: function(msg) {      
      if (isNaN(msg)){
        $(errorId).show();
        $(errorId).text("Basta! you already voted for this idea");
      }else
      {
        $(spanId).html(msg);
        getTotal(ideaId);
      }
    }
  });
  
  return false;
});

$('.votebadbutton').live("click", function() {
  
  var id = $(this).attr("id");
  var temp = id.indexOf('-');
  var ideaId = id.substring(temp+1);
  $(".idea-error").hide();
  if (!ideaId || ideaId < 0) {
    return false;
  }
  
  var form_data = {
    field: 'bad',
    id: ideaId,
    ajax: '1'   
  };
  var spanId = '#idea-bad-id-' + ideaId;
  var errorId = '#idea-error-'+ ideaId;
 
  $.ajax({
    url: "<?php echo site_url('ideas/post_vote'); ?>",
    type: 'POST',
    data: form_data,
    success: function(msg) {
      if (isNaN(msg)){
         $(errorId).show();
         $(errorId).text("Basta! you already voted for this idea");
      }else
      {
        $(spanId).html(msg);
        getTotal(ideaId);
      }
    }
  });
  
  return false;
});




});

function getTotal(ideaId)
{
  var spanTotal = '#idea-total-id-' + ideaId;
  var spanGood = '#idea-good-id-' + ideaId;
  var spanBad = '#idea-bad-id-' + ideaId;
  var total = $(spanGood).text() - $(spanBad).text();
  $(spanTotal).text(total);
}

</script>
<?php $this->load->view('common/footer') ?>