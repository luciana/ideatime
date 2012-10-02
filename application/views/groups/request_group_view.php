<?php $attributes = array('class' => 'well', 'id' => 'requestAccess') ?>

          <?php echo form_open('/groups/request_access', $attributes); ?>
           <h3 class="pink">Request Access to an existing group</h3>     
           <?php
          $data = array(
            'name'        => 'twitter_name',            
            'class'   => 'span6',
            'placeholder'       => 'enter your twitter userid',
            'value'=> $_SESSION['username']
          );
          echo form_input($data); 
          $options = array();
          $groups = $this->group_model->get_groups();
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