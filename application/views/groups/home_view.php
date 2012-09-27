<section class="container-fluid ">     
  <div class="row-fluid">
    <?php        
    if ($group_count % 3 == 0) $class ="span4";
    if ($group_count % 2 == 0) $class ="span6";
    $data['groups'] = $groups;
    $data['class'] = $class;

    //User is in multiple groups..
    if($group_count>1)
      $this->load->view('groups/list_group_view',$data);
    ?>
  </div>               
  <div class="row-fluid">                
     <div  class="well span6"> 
       <?php $this->load->view('groups/new_group_view') ?>
      </div>
      <div  class="well span6"> 
        <?php $this->load->view('groups/request_group_view') ?>
      </div>
    </div>      
</section>