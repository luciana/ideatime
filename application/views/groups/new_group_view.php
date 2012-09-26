<?php $attributes = array('class' => 'well', 'id' => 'newGroup') ?>
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