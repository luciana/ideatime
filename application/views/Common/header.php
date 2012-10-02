<?php if(!isset($_SESSION)){session_start();}; ?>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Idea Time</title>

        <!-- Javascript
          ================================================== -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>         
        <script type="text/javascript" src="/js/script.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>

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
      <div class="span7">
        <h2 ><a class="brand" href="<?php echo  site_url('groups/home') ?>">IdeaTime</a><span class="small gray">.us</span></h2>        
      </div>
        <?php if(!empty($_SESSION['name'])): ?>        
        <div class="span2">
           <a href=<?php echo '"' . site_url('groups/home') . '" class="uppercase">'?> Start a Group</a>            
        </div> 
          <?php  if($this->user_model->is_user_admin($_SESSION['user_id'])): ?>
           <div class="span2">
             <a href=<?php echo '"' . site_url('groups/admin') . '" class="uppercase">'?> Manage Group</a>            
          </div> 
          <? endif; ?>
        <div class="span1">
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
