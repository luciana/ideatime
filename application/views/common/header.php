<?php if(!isset($_SESSION)){session_start();}; ?>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Idea Time</title>

        <!-- Javascript
          ================================================== -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>         
        <script type="text/javascript" src="/js/script.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>

        <!-- CSS
          ================================================== -->
        <link href='http://ideatime.us/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
        <link href='http://ideatime.us/css/bootstrap-responsive.min.css' rel='stylesheet' type='text/css'> 
        <link href='http://ideatime.us/css/style.css' rel='stylesheet' type='text/css'>           
</head>
<body>
 <script>
    dataLayer = [{
      'username': 'me',
      'pageTitle': 'signin',
      'visitorType': 'high-value'
    }];
  </script>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-S5N7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-S5N7');</script>
<!-- End Google Tag Manager -->
 <header class="container-fluid">      
    <div class="row-fluid"> 
      <div class="span7">
        <h2 ><a class="brand" href="<?php echo  site_url('groups/home') ?>" name="Logo">IdeaTime</a><span class="small gray">.us</span></h2>        
      </div>
        <?php if(!empty($_SESSION['username'])): ?>        
        <div class="span2">
           <a name="StartGroup" href=<?php echo '"' . site_url('groups/home') . '" class="uppercase">'?> Start a Group</a>            
        </div>          
        <div class="span2">
           <a name="archive-ideas" href=<?php echo '"' . site_url('ideas/archive/'.$_SESSION['active_group_id']) . '" class="uppercase">'?> Archived Ideas </a>           
        </div> 
        <div class="span2">
           <a name="archive-ideas" href=<?php echo '"' . site_url('ideas/single/'.$_SESSION['active_group_id']) . '" class="uppercase">'?> New Ideas </a>           
        </div> 
        <div class="span2">
           <a name="Logout" href=<?php echo '"' . site_url('ideas/logout') . '" class="uppercase">'?> Sign-out</a>            
        </div>  
        <? endif; ?>
    </div>       
 </header>

  <section class="container-fluid">
       <p name="page-header" class="tagline center no-loggedin uppercase tracking">
      <?php if(!empty($_SESSION['username'])): ?>
      <?php  echo '<img src="'.$_SESSION['avatar'].'">' ?>
       <?php echo $_SESSION['name'].'</img>' ?> 
     <?php else: ?>
       <?php   echo 'Have an idea to share ?'; ?>
       <? endif; ?>

       </p>
     </section>