 <?php $this->load->view('common/header') ?>
	 <section class="container-fluid ">             
        <div class="row-fluid">                    
                <h3 class="pink">What is your next idea?</h3>              
              <?php
                $attributes = array('class' => 'well', 'id' => 'newIdea');
                $hidden = array('username' => $_SESSION['username']);
                ?>
                <?php echo form_open('/ideas/submit', $attributes, $hidden);
             		$data = array(
		              'name'        => 'idea',
		              'id'          => 'ideaName',
		              'class'		=> 'span12',
		              'placeholder'       => 'what is the idea name?',
		            );

        				echo form_input($data); 
        				$btnAtt = array(
        					'class' => 'addidea btn btn-inverse',
        					'id'	=> 'sendIdea',
        					'content' => 'Send',
        					'type' =>	'submit'
        					);
        				echo form_button($btnAtt);
        				echo form_close();
      				?>
          
            </div>
            <div class="row-fluid">        
                <h3 class="pink">Vote for the idea</h3>
             
           <?php $data['ideas'] = $ideas ?>  
			 <?php $this->load->view('idea_view', $data) ?>
        </div>      
    </section>

<script type="text/javascript">
$('#sendIdea').click(function() {
  
  var idea = $('#ideaName').val();
  
  if (!idea || idea == 'what is the idea name?') {
    alert('Please enter your idea');
    return false;
  }
  
  var form_data = {
    idea: idea,
    author: "<?php echo $_SESSION['username'] ?>", 
    ajax: '1'   
  };
  
  $.ajax({
    url: "<?php echo site_url('ideas/submit'); ?>",
    type: 'POST',
    data: form_data,
    success: function(msg) {
      $('#voting').append(msg);
    }
  });
  
  return false;
});
  
  
</script>

 <?php $this->load->view('common/footer') ?>