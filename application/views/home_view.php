 <?php $this->load->view('common/header') ?>
	 <section class="container-fluid ">             
        <div class="row-fluid">                    
                <h3 class="pink">What is your next idea?</h3>              
             <!--  <form class="well" action="" method="POST">
                  <input type="text" class="span12" id="nameidea" placeholder="what is the idea name?">                 
                  <a  class="addidea btn btn-inverse" id="sendIdea">Send</a>
                  <div id="no-idea"></div>
                </form> --><?php
                $attributes = array('class' => 'well');
                $hidden = array('username' => $_SESSION['username']);
                ?>
                <?php echo form_open('/ideas/submit', $attributes, $hidden);
             		$data = array(
		              'name'        => 'idea',
		              'id'          => 'sendIdea',
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

 <?php $this->load->view('common/footer') ?>