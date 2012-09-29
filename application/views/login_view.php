
<?php $this->load->view('common/header') ?>
<section class="container-fluid">
     
       <?php if(empty($_SESSION['name'])){  ?>
        <div class="row-fluid">
          <div class="span12 tagline center well">
            <a href=<?php echo '"' . site_url('ideas/login') . '" class="uppercase">'?> Sign in with your twitter account</a>                          
          </div>          
        </div>                 
        <?php } ?>   
</section>
<?php $this->load->view('common/footer') ?>