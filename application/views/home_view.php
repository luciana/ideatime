 <?php $this->load->view('common/header') ?>
	 <section class="container-fluid ">             
       
      
      <?php      
        $group_count = count($groups);        
        if ($group_count % 3 == 0) $class ="span4";
        if ($group_count % 2 == 0) $class ="span6";

        //User is in multiple groups..
        if($group_count>1){?>
          <div class="row-fluid">  <?php
          foreach ($groups as $group)
          {
             ?>
             <div class="well <?php echo $class ?>">
              <h3 class="pink"><a href="#" class="group" id="group-<?php echo $group->id ?>"><?php echo $group->name; ?> Group</a></h3>
             </div>
             <?php
          } ?>
          <div id="idea-content">
          </div><?php
        }else {
          $data['group']= $groups[0];
          $data['ideas']= $ideas;
          $this->load->view('ideas/single_idea_view', $data);        
        }
        ?>
                
    </section>

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

$('.group').click(function(){

  var form_data = {   
    user_id: "<?php echo $_SESSION['user_id'] ?>",
    group: '1', 
    ajax: '1'   
  };

  $.ajax({
      url: "<?php echo site_url('ideas/show'); ?>",
      type: 'POST',     
      data: form_data,
      success: function(data) {
        alert(data);
        $(".group").hide();
        $("#idea-content").fadeIn(data);
      }
    });

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