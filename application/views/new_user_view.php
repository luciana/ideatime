 <?php $this->load->view('common/header') ?>
	 <section class="container-fluid ">                     
      <div class="row-fluid">        
          
         <div  class="well span6"> 
           <?php $attributes = array('class' => 'well', 'id' => 'newGroup') 
          ?>
          <?php echo form_open('/groups/submit', $attributes); ?>
           <h3 class="pink">Create a New Idea Time Group</h3>     
           <?php
           $data = array(
            'name'        => 'username',            
            'class'   => 'span6',
            'placeholder'       => 'enter your twitter userid',
            'value'=> $user
          );
          echo form_input($data); 
          $data = array(
            'name'        => 'group',
            'id'          => 'group',
            'class'   => 'span6',
            'placeholder'       => 'enter your new group name'
          );
          echo form_input($data); 

          $btnAtt = array(
            'class' => 'addidea btn btn-inverse',
            'id'  => 'sendNewGroup',
            'content' => 'Send',
            'type' => 'submit'
            );
          echo form_button($btnAtt);
         echo form_close();
    ?>
          </div>
          <div  class="well span6"> 
          <?php $attributes = array('class' => 'well', 'id' => 'newUser') ?>

          <?php echo form_open('/twitter/post_status', $attributes); ?>
           <h3 class="pink">Request Access to an existing group</h3>     
           <?php
          $data = array(
            'name'        => 'twitter_name',            
            'class'   => 'span6',
            'placeholder'       => 'enter your twitter userid',
            'value'=> $user
          );
          echo form_input($data); 
          $options = array();
          foreach($groups as $row){
            if(!empty($row->name)){                     
                $options[$row->id] = $row->name;
            }
          }                
          echo form_dropdown('groups', $options, '1');?>
          <br>
          <?php
          $btnAtt = array(
            'class' => 'addidea btn btn-inverse',
            'id'  => 'sendAccessRequest',
            'content' => 'Send',
            'type' => 'submit'
            );
          echo form_button($btnAtt);
          echo form_close();
    ?>
          </div>
        </div>      
    </section>

 <?php $this->load->view('common/footer') ?>