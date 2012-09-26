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