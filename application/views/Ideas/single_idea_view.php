<div class="row-fluid">  
    <!--User is only in one group - show idea page     -->       
    <?php $this->load->view('forms/idea_form_view', $group)  ?>                
     <div class="row-fluid">        
        <h3 class="pink">Vote for the idea</h3>                       
     <div id="voting" class="well"> 
         <?php 
         $data['ideas'] = $ideas ;             
         $this->load->view('ideas/idea_view', $data)?>
     </div>
              <div style="background-color:white;height:50px;width:90px;margin:-20px auto 0;padding-bottom:20pt;" id="moreIdeas"> 
                <div style="padding:7px 7px">
                 <button style="width:80%;" class="addidea btn btn-inverse" id="moreIdeas">Next</button>
                 </div>
         </div>
  </div>
</div> 