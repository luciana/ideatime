 <?php $this->load->view('common/header') ?>
<div class="container-fluid">  <?php
  //User is only in one group - show idea page           
  $this->load->view('forms/idea_form_view', $groups);  
         
  ?>        
    <div class="row-fluid">        
      <h3 class="pink">Vote for the idea</h3>                       
      <div id="voting" class="well"> 
       <?php 
       if(count($ideas)>0){ 
          $data['ideas'] = $ideas ;             
          $this->load->view('ideas/idea_view', $data);
        }?> 
       </div>
        <div style="height:auto;width:70px;margin:-20px auto 0;padding-bottom:20pt;" id="moreIdeas"> 
         <button style="align:center; width:80px;" class="addidea btn btn-inverse" id="moreIdeas">Next</button>
     </div>
    </div>
</div> 

<script type="text/javascript">
var page = 1;
$(".idea-error").hide();

$('.form').bind('keypress', function(e) {
        if(e.keyCode==13){
              e.preventDefault();
              $(".idea-error").hide();
              var elem = $(this).attr('id');
              var textElem = elem.replace("form", "add"); 
              var areaElem = elem.replace("form", "area"); 
              var comment = $('#'+textElem).val();
              $('#'+areaElem).append('<div class="alert" style="margin-bottom: 2px;"><button type="button" class="close" data-dismiss="alert">×</button>'+ comment +'</div>');
              $('#'+textElem).val('');
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


$('#moreIdeas').click(function() {
    
    page++;

    if (page > <?php echo $this->idea_model->get_total_pages($_SESSION['active_group_id']) ?>)
      page = 1;

    var form_data = {
      pageNum: page
    };
    $.ajax({
    url: "<?php echo site_url('ideas/next_page'); ?>",
    type: 'POST',
    data: form_data,
    success: function(msg) {
      $('#voting').html(msg);
      $('#ideaName').val('');
      $(".alert").hide();
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

