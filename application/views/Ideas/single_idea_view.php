<div class="row-fluid">  <?php
            //User is only in one group - show idea page           
            $this->load->view('forms/idea_form_view', $group);            
            ?>        
            <div class="row-fluid">        
              <h3 class="pink">Vote for the idea</h3>                       
              <div id="voting" class="well"> 
               <?php 
               $data['ideas'] = $ideas ;             
               $this->load->view('ideas/idea_view', $data)?>
               </div>
            </div>
           </div> 