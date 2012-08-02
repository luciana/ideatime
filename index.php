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
        <link href='css/style.css' rel='stylesheet' type='text/css'>
        <script type="text/javascript">
        $(function() {    

            function updateData(data){
                var data = eval(data);
                for (var i = 0; i < data.length; i++) { 
                  var name = "idea-name-" + data[i].id;
                  var barGood = "idea-count-good-"+ data[i].id;
                  var barBad = "idea-count-bad-"+ data[i].id;
                  var total = data[i].total;
                  var badRank = Math.round((data[i].bad/total)*10);
                  var goodRank = Math.round((data[i].good/total)*10);
                  var display = data[i].name;
                  $('#'+name).text(display);
                  $('#'+barGood).html('<span class="votecount">'+data[i].good +'</span>');
                  $('#'+barBad).html('<span class="votecount">'+data[i].bad+'</span>');                  
                  $('#'+barGood).removeClass();
                  $('#'+barBad).removeClass();
                  $('#'+barBad).addClass("bad vote v-"+badRank);
                  $('#'+barGood).addClass("good vote v-"+goodRank);                              
                }

            } 

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
                 //$('#voting').fadeOut('slow'); 
                  var badIdeaId = this.getAttribute('data-idea-bad');                 
                  $.ajax({              
                      type: "POST",               
                      url: "process.php?action=",                
                      data: { ideaBadId: badIdeaId, action: "votebad" },                
                      success: function(data) {                                                         
                        updateData(data);                                            
                      }
                    });
              });
           
            $(".votegoodbutton").click(function(){                        
                //$('#voting').fadeOut('slow'); 
                var goodIdeaId = this.getAttribute('data-idea-good');                              
                $.ajax({              
                    type: "POST",               
                    url: "process.php?action=",                
                    data: { ideaGoodId: goodIdeaId, action: "votegood" },                
                    success: function(data) {                                                      
                      //$('#voting').html(html);
                      //$('#voting').fadeIn('slow');     
                      updateData(data);                
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
                  <input type="text" class="span12" id="nameidea" placeholder="what is the idea name?">                 
                  <button type="submit" id="addidea" class="btn btn-inverse">Send</button>
                </form>
            </div>
            <div class="row-fluid">        
                <h3 class="pink">Vote for the idea</h3>
                <div id="voting" class="well">
                   
                    <?php        
                    $query = mysql_query("SELECT sum(good)as'sum' FROM ideas");
                    $count =mysql_fetch_array($query);                
                    $query = mysql_query("SELECT id, name, good, bad FROM ideas ORDER BY good desc");                       
                    while($row = mysql_fetch_array($query)){       
                        $good = ($row['good']>0)  ?  $row['good'] : 0;      
                        $bad = ($row['bad']>0)  ?  $row['bad']: 0;  
                        $sum = $count['sum'];
                        $rankgood =  ($good>0)  ?  round(($good/$sum)*10): "1";  
                        $rankbad=  ($bad>0)  ?  round(($bad/$sum)*10): "1";  
                      ?>             
                      <div class='well'>
                        <div class="span1"><a class="votegoodbutton btn btn-inverse" id="idea-good-id-<?php echo $row['id']?>" type="submit" data-idea-good="<?php echo $row['id']?>" ><i class="icon-thumbs-up icon-white"></i></a></div> 
                        <div class="span1"><a class="votebadbutton btn btn-inverse"  id="idea-bad-id-<?php echo $row['id']?>" type="submit" data-idea-bad="<?php echo $row['id'] ?>" ><i class="icon-thumbs-down icon-white"></i></a></div>       
                        <div class='ideainfo'><span class='span10 ideaname' id="idea-name-<?php echo $row['id']?>"><?php echo $row['name'] ?></span></div>
                        <div id="idea-count-good-<?php echo $row['id']?>" class='good vote v-<?php echo $rankgood ?>'><span class="votecount"><?php echo $good ?></span></div>
                        <div id="idea-count-bad-<?php echo $row['id']?>"  class='bad vote v-<?php echo $rankbad ?>'><span class="votecount"><?php echo $bad ?></span></div>                     
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