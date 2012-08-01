<!DOCTYPE html>
<?php
  require("twitteroauth/twitteroauth/twitteroauth.php");  
  include 'conn.php'; 
  session_start();   
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Idea Time</title>

        <!-- Javascript
          ================================================== -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>	
        <!-- CSS
          ================================================== -->
          <link href='css/bootstrap.min.css' rel='stylesheet' type='text/css'>
          <link href='http://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
        <link href='css/bootstrap-responsive.min.css' rel='stylesheet' type='text/css'> 
        <style type="text/css">
           body{
             background-color: #000;
             color: #fff;
           }

           .ideaname{
            color: #000;
           }
           h2 a
           {
            /*color: #59b259;*/
            color: #F5385E;
            font-weight: bold;
            text-decoration: none;
            font: bold 2em 'Signika', sans-serif;            
           }
           
           h2 a:hover
           {
            /*color: #59b259;*/
             color: #F5385E;
            font-weight: bold;            
           }

           .uppercase{
            text-transform: uppercase;
           }
           .small
           {
            font-size: 0.5em;
           }

           .gray 
           {
            color: #ccc;
           }
           .pink{
            color: #F5385E;
           }
          .green{
            color: #59b259;
            font-weight: bold;
           }
           .red
           {
            color: red;
            font-weight: bold;
           }

           ul{
            list-style: none;
           }


          li {
                position: relative;
                margin: 10px;
            }

          li span {
            
            padding: 0 8px;
            position: relative;
            z-index: 5;
          }
  
          .no-loggedin
          {
            font: normal 4em 'Signika', sans-serif;            
            display: block;
            font-weight: bold; 
            padding: 10px;    
            
          }

          .center {
            text-align: center;
          }
          .vote {
            content: "";
            margin: 5px 0;
            display: block;
            /*border-top : solid 1px #4F9E51;    */
            border-top: solid 1px #F5385E;
            height: 15px;
            clear: both;
            -moz-border-radius: 5px;
            border-radius: 5px;          

           background: #ff6bb7; /* Old browsers */
background: -moz-linear-gradient(top,  #ff6bb7 0%, #f5385e 94%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff6bb7), color-stop(94%,#f5385e)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ff6bb7 0%,#f5385e 94%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ff6bb7 0%,#f5385e 94%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ff6bb7 0%,#f5385e 94%); /* IE10+ */
background: linear-gradient(to bottom,  #ff6bb7 0%,#f5385e 94%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff6bb7', endColorstr='#f5385e',GradientType=0 ); /* IE6-9 */

          }

          .vote.v-10
          {
            width: 100%;
          }
          .vote.v-8
          {
            width: 85%;
          }
           .vote.v-7
          {
            width: 70%;
          }
          .vote.v-5
          {
            width: 55%;
          }
           .vote.v-4
          {
            width: 45%;
          }
          .vote.v-3
          {
            width: 30%;
          }
          .vote.v-0
          {
            width: 1%;
          }                    
        </style> 
        <script type="text/javascript">
        $(function() {     

            $('#addidea').click(function(){
              $('#voting').fadeOut('slow'); 
              var name = $('#nameidea').val();
              var author = "<?php echo $_SESSION['username']; ?>";              
              $.ajax({              
                    type: "POST",               
                    url: "process.php",                
                    data: { name: name, author: author,action: "add" },                
                    success: function(html) {                                                    
                       $('#voting').html(html);
                       $('#voting').fadeIn('slow'); 
                     }
                   });
            });

            $('.votebadbutton').click(function(){  
                 $('#voting').fadeOut('slow'); 
                  var badIdeaId = this.getAttribute('data-idea-bad');                 
                  $.ajax({              
                      type: "POST",               
                      url: "process.php?action=",                
                      data: { ideaBadId: badIdeaId, action: "votebad" },                
                      success: function(html) {                                 
                         //$('#voting').html(html);
                         $('.ideainfo').html(html);
                         $('#voting').fadeIn('slow');                         
                      }
                    });
              });
           
            $(".votegoodbutton").click(function(){                        
                $('#voting').fadeOut('slow'); 
                var goodIdeaId = this.getAttribute('data-idea-good');                              
                $.ajax({              
                    type: "POST",               
                    url: "process.php?action=",                
                    data: { ideaGoodId: goodIdeaId, action: "votegood" },                
                    success: function(html) {                                 
                       $('#voting').html(html);
                       //var test = html;
                       //$('.ideainfo').html(html);
                       $('#voting').fadeIn('slow');                      
                    }
                  });
              });                              
        })
        </script>
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
                  <input type="text" class="span9" id="nameidea" placeholder="what is the idea name?">                 
                  <button type="submit" id="addidea" class="btn btn-inverse">Send</button>
                </form>
            </div>
            <div class="row-fluid">        
                <h3 class="pink">Vote for the idea</h3>
                <div id="voting" class="well">
                   
                    <?php                        
                    $query = mysql_query("SELECT id, name, good, bad FROM ideas ORDER BY good desc");                       
                    while($row = mysql_fetch_array($query)){       
                        $good = ($row['good']>0)  ?  " ( +".$row['good'].")" : "";      
                        $bad = ($row['bad']>0)  ?  " ( - ".$row['bad'].")" : "";      
                      ?>             
                      <div class='well'>
                        <div class="span1"><button class="votegoodbutton btn btn-inverse" type="submit" data-idea-good="<?php echo $row['id']?>" ><i class="icon-thumbs-up icon-white"></i></button></div> 
                        <div class="span1"><button class="votebadbutton btn btn-inverse"  type="submit" data-idea-bad="<?php echo $row['id'] ?>" ><i class="icon-thumbs-down icon-white"></i></button></div>       
                        <div class='ideainfo'><span class='span10 ideaname'><?php echo $row['name']. $good. $bad ?></span></div>
                      </div>                     
                  <?php } ?>  
                    
                </div>
            </div>      
    </section>
      <?php } ?></p>  
    <footer>
    </footer>


</body>
</html>