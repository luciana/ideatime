<?php if(!isset($_SESSION)){session_start();}; ?>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Idea Time</title>

        <!-- Javascript
          ================================================== -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>         
        <script type="text/javascript" src="/js/script.js"></script>

        <!-- CSS
          ================================================== -->
        <link href='/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
        <link href='/css/bootstrap-responsive.min.css' rel='stylesheet' type='text/css'> 
        <link href='/css/style.css' rel='stylesheet' type='text/css'>           
</head>
<body>

 <header class="container-fluid">      
    <div class="row-fluid"> 
      <div class="span8">
        <h2 ><a class="brand" href="<?php echo  site_url('ideas/index') ?>">IdeaTime</a><span class="small gray">.us</span></h2>        
      </div>
        <?php if(!empty($_SESSION['name'])): ?>
        <div class="span4">
           <a href=<?php echo '"' . site_url('ideas/logout') . '" class="uppercase">'?> Sign-out</a>            
        </div>  
        <? endif; ?>
    </div>       
 </header>

  <section class="container-fluid">
       <p class="tagline center no-loggedin uppercase">
      <?php if(!empty($_SESSION['name'])): ?>
      <?php  echo '<img src="'.$_SESSION['avatar'].'">' ?>
       <?php echo $_SESSION['name'].'</img>' ?> 
     <?php else: ?>
       <?php   echo 'Have an idea to share ?'; ?>
       <? endif; ?>

       </p>
     </section>
