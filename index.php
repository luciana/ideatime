<?php
    session_start();  
   require("twitteroauth/twitteroauth/twitteroauth.php");  
   include 'conn.php';  
   include 'functions.php'; 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Idea Time</title>

        <!-- Javascript
          ================================================== -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
        <script type="text/javascript" src="js/script.js"></script>

        <!-- CSS
          ================================================== -->
        <link href='css/bootstrap.min.css' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
        <link href='css/bootstrap-responsive.min.css' rel='stylesheet' type='text/css'> 
        <link href='css/style.css' rel='stylesheet' type='text/css'>        
    </head>
    <body >    
    <header class="container-fluid">       
            <h2><a class="brand" href='index.php'>IdeaTime</a><span class="small gray">.us</span></h2>            
    </header>
    <section class="container-fluid">
       <p class="tagline center no-loggedin uppercase">
      <?php
       if(!empty($_SESSION['name'])) { 
        ?><img src="<?php echo $_SESSION['avatar']?>"> <?php
        echo $_SESSION['name'];
      }else{
         echo 'Have an idea to share?'; 
      }?>

       </p>
        <p class="tagline center">
           <?php if(empty($_SESSION['username'])){  ?>
                       <a href="twitter_login.php" class="uppercase">Sign in with your twitter account </a>
            <?php } ?></p>   
    </section>
    <?php if(!empty($_SESSION['username']) && (is_null($_SESSION['author']))){  ?>
    <section class="container-fluid ">
      <p class="tagline center uppercase pink">Sorry this site is by invitation only</p>
      <p class="center"><a href="mailto:luciana.bruscino@gmail.com">Request to be invited</a></p>
    </section>
    <?php } ?>

    <?php if(!empty($_SESSION['username']) && (!is_null($_SESSION['author']))){  ?>
    <section class="container-fluid ">             
          <div class="row-fluid">                    
                <h3 class="pink">What is your next idea?</h3>              
               <form class="well" action="" method="POST">
                  <input type="text" class="span12" id="nameidea" placeholder="what is the idea name?">                 
                  <a  class="addidea btn btn-inverse">Send</a>
                  <div id="no-idea"></div>
                </form>
            </div>
            <div class="row-fluid">        
                <h3 class="pink">Vote for the idea</h3>
                <div id="voting" class="well">                   
                    <?php   echo showData(); ?>                      
                </div>
            </div>      
    </section>
      <?php } ?></p>  
    <footer class="container-fluid ">              
          <div class="well">                    
               <span style="color:#000"> Copyright 2012 - All ideas in this site are of sole ownership of the author. You may not modify, publish, copy, transmit, transfer, sell, reproduce, create derivative works from, license, distribute, frame, hyperlink, download, repost, perform, display or in any way commercially exploit any of the content of this site without the permission of the author.</span> 
               
            </div>
    </footer>


</body>
</html>