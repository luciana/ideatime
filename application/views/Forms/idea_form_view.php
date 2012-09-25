 <div class="row-fluid">     
    <h2><?php echo $group['name'] ?></h2>                       
      <?php       
          $attributes = array('class' => 'well', 'id' => 'newIdea');
          $hidden = array('username' => $_SESSION['username']);
          ?>

          <?php echo form_open('/ideas/submit', $attributes, $hidden); ?>
           <h3 class="pink">What is your idea?</h3>     
           <?php
       		$data = array(
            'name'        => 'idea',
            'id'          => 'ideaName',
            'class'		=> 'span12',
            'placeholder'       => 'describe your idea...',
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