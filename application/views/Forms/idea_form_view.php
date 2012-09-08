 <div class="row-fluid">                    
    <h3 class="pink">What is your next idea?</h3>              
      <?php
          $attributes = array('class' => 'well', 'id' => 'newIdea');
          $hidden = array('username' => $_SESSION['username'], 'group_id' => $_SESSION['group']);
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