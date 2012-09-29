 <?php $this->load->view('common/header') ?>
<div class="container-fluid">  <?php
  //User is only in one group - show idea page           
  $this->load->view('forms/idea_form_view', $groups);  

  if($this->group_model->is_user_group_admin($_SESSION['active_group_id'],$_SESSION['user_id'])){
      $data['group_id'] = $_SESSION['active_group_id'];
     $this->load->view('forms/admin_view', $data);
  }

  if(count($ideas)>0){          
  ?>        
    <div class="row-fluid">        
      <h3 class="pink">Vote for the idea</h3>                       
      <div id="voting" class="well"> 
       <?php 
       $data['ideas'] = $ideas ;             
       $this->load->view('ideas/idea_view', $data)?>
       </div>
        <div style="height:auto;width:70px;margin:-20px auto 0;padding-bottom:20pt;" id="moreIdeas"> 
         <button style="align:center; width:80px;" class="addidea btn btn-inverse" id="moreIdeas">Next</button>
     </div>
    </div>
 <?php } ?>
</div> 

<script type="text/javascript">
var page = 1;
$('#moreIdeas').click(function() {
    
    page++;

    if (page > <?php echo $this->idea_model->get_total_pages() ?>)
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
    }
  });
  return false;

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
    group: "<?php echo $_SESSION['groups'] ?>", 
    ajax: '1'   
  };
  
  $.ajax({
    url: "<?php echo site_url('ideas/submit'); ?>",
    type: 'POST',
    data: form_data,
    success: function(msg) {
      $('#voting').append(msg);
      $('#ideaName').val('');
    }
  });
  
  return false;
});

$('.votegoodbutton').live("click", function() {
  
  var id = $(this).attr("id");
  var temp = id.indexOf('-');
  var ideaId = id.substring(temp+1);
  
  if (!ideaId || ideaId < 0) {
    return false;
  }
  
  var form_data = {
    field: 'good',
    id: ideaId,
    ajax: '1'   
  };
  var spanId = '#idea-good-id-' + ideaId;
  $.ajax({
    url: "<?php echo site_url('ideas/post_vote'); ?>",
    type: 'POST',
    data: form_data,
    success: function(msg) {
      if (isNaN(msg))
        alert(msg);
      else
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
  
  if (!ideaId || ideaId < 0) {
    return false;
  }
  
  var form_data = {
    field: 'bad',
    id: ideaId,
    ajax: '1'   
  };
  var spanId = '#idea-bad-id-' + ideaId;
  $.ajax({
    url: "<?php echo site_url('ideas/post_vote'); ?>",
    type: 'POST',
    data: form_data,
    success: function(msg) {
      if (isNaN(msg))
        alert(msg);
      else
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

