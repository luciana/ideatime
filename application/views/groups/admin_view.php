 <?php $this->load->view('common/header') ?>
 <div class="container-fluid"> 
  <div class="row-fluid">
    <?php $this->load->view('forms/meetup_form_view.php'); ?>
  </div>
<div class="row-fluid">   
    <div class="well">     
         <h3 class="pink">Admin Panel</h3> 
          <div class="row-fluid"> 
            <div class="span6">
             <?php 
              $requests = $this->group_model->get_group_requests($group_id);
              if(!empty($requests)){                 
              $attributes = array('class' => 'well black', 'id' => 'grantAccess');             
             ?>
              <?php echo form_open('/groups/grant_access', $attributes); ?>
               <h3 class="pink">Grant Access To This Group</h3>                
               <?php    
                foreach($requests as $row){
                    $value = $this->user_model->get_user_by_username($row->requester);                 
                    $data = array(
                    'name'        => 'access',           
                    'value'       => $value->id,  
                    'checked'     => false                                
                    );
                    ?>
                   <label for="access" class="checkbox">   <?php                                   
                   echo form_checkbox($data);              
                   echo $row->requester;
                   form_hidden('username', $row->requester);
                   form_hidden('users_id', $value->id);
                   form_hidden('groups_id', $_SESSION['active_group_id']);
                   ?></label><?php
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
               <?php }else{
                echo '<span class="black">No Request for Group Access</span>';
               } ?>
            </div>
      </div>
     
</div>  
</div>
</div>
 <?php $this->load->view('common/footer') ?>