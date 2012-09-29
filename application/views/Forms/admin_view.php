<div class="row-fluid">   
    <div class="well">
  <h3 class="pink">Admin Panel</h3> 
     <div class="row-fluid"> 
  
        <div class="span6"><?php
         $attributes = array('class' => 'well black', 'id' => 'grantAccess') ?>

          <?php echo form_open('/groups/grant_access', $attributes); ?>
           <h3 class="pink">Grant Access To This Group</h3>     
           <?php
          
          $requests = $this->group_model->get_group_requests($group_id);
          
          foreach($requests as $row){
             // $value = $this->user_model->get_user_by_username($row->requester);
              //print($value);
              $data = array(
              'name'        => 'access',           
              //'value'       => $value->id,  
              'checked'     => false,
              
              );
             echo form_checkbox($data);
             echo $row->requester;
             }              
          ?>
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
</div>  
</div>