<?php $this->load->view('common/header') ?>
<section class="container-fluid">
     
       <?php if(empty($_SESSION['name'])){  ?>
        <div class="row-fluid">
          <div class="span12 tagline center well">
            <a onclick="dataLayer.push({'event': 'GAEvent', 'eventCategory':window.location.href, 'eventAction':this.name, 'eventLabel':""});" href=<?php echo '"' . site_url('ideas/login') . '" class="uppercase" name="authentication" >'?> Sign in with your twitter account</a>                          
          </div>          
        </div>                 
        <?php } ?>   
</section>

<section class="center">
	<img src="http://ideatime.us/img/ideatime_oscar_banner.png"  />
</section>

<?php $this->load->view('common/footer') ?>