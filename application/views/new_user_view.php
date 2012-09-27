 <?php $this->load->view('common/header') ?>
	 <section class="container-fluid ">                     
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