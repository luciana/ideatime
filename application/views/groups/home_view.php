 <?php $this->load->view('common/header') ?>
<section class="container-fluid ">   
<?php      
  if(!empty($groups)){  ?>  
    <div class="row-fluid">
      <?php
      //User is in multiple groups..
      $group_count = count($groups);  
        if($group_count>1){
          if ($group_count % 3 == 0) $class ="span4";
          if ($group_count % 2 == 0) $class ="span6";
          $data['groups'] = $groups;
          $data['class'] = $class;
          $this->load->view('groups/list_group_view',$data);
        }
      ?>
    </div>   
  <?php 
   } ?>            
  <div class="row-fluid">                
     <div  class="well span6"> 
       <?php $this->load->view('groups/new_group_view') ?>
      </div>
      <div  class="well span6"> 
        <?php $this->load->view('groups/request_group_view') ?>
      </div>
    </div>      
</section>
 <?php $this->load->view('common/footer') ?>