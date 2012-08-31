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
        <link href='/idea/assets/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
        <link href='/idea/assets/css/bootstrap-responsive.min.css' rel='stylesheet' type='text/css'> 
        <link href='/idea/assets/css/style.css' rel='stylesheet' type='text/css'>        
</head>
<body>

 <header class="container-fluid">       
            <h2><a class="brand" href='index.php'>IdeaTime</a><span class="small gray">.us</span></h2>            
 </header>

  <section class="container-fluid">
       <p class="tagline center no-loggedin uppercase">
      <?php if(!empty($_SESSION['username'])): ?>
      <?php  echo '<img src="'.$_SESSION['avatar'].'">' ?>
       <?php echo $_SESSION['username'].'</img>' ?> 
     <?php else: ?>
       <?php   echo 'Have an idea to share?'; ?>
       <? endif; ?>

       </p>
        <p class="tagline center">
           <?php if(empty($_SESSION['username'])){  ?>
                        <a href=<?php echo '"' . site_url('ideas/login') . '" class="uppercase">'?> Sign in with your twitter account</a>
            <?php } ?></p>   
</section>
