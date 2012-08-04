<?php
  session_start();  
 require("twitteroauth/twitteroauth/twitteroauth.php");  
  include 'conn.php';  
?>
<!DOCTYPE html>
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
                if(data != null){
                  for (var i = 0; i < data.length; i++) { 
                    var name = "idea-name-" + data[i].id;
                    var bar = "idea-count-"+ data[i].id;
                    var goodcount = "idea-good-id-" + data[i].id;       
                    var badcount = "idea-bad-id-" + data[i].id;    
                    var count = "idea-all-id-" + data[i].id;   
                    var display = data[i].name;
                    var rank = Math.round(((parseInt(data[i].good) + parseInt(data[i].bad))/data[i].total)*10);
                    var rankClass = "good vote v-"+rank;
                    $('#'+name).text(display);   
                    $('#'+goodcount).text(data[i].good); 
                    $('#'+badcount).text(data[i].bad); 
                    $('#'+count).text(parseInt(data[i].good) + parseInt(data[i].bad));
                    $('#'+bar).removeClass();
                    $('#'+bar).addClass(rankClass);
                  }
                }
            }            

            $('.addidea').click(function(){
                var name = $('#nameidea').val();
               
                if(name == ''){
                  $('#no-idea').addClass("alert");
                  $('.alert').text('oops, you forgot to enter an idea.');
                }else{   
                  $('#no-idea').hide(); 
                   $('#voting').fadeOut();
                  var author = "<?php echo $_SESSION['username'] ?>";                            
                  $.ajax({              
                      type: "POST",               
                      url: "process.php?action=",                
                      data: { name: name, author: author, action: "addidea" },                
                      success: function(data) {                                                         
                        updateData(data);     
                         $('#voting').fadeIn();                                                
                      },
                      error: function(a,b,c)
                      {
                        $('#no-idea').show(); 
                        $('#no-idea').addClass("alert alert-error");
                      }
                    });

                }


            });
           

            $('.votebadbutton').click(function(){           
                  $('#no-idea').hide();        
                  var badIdeaId = this.getAttribute('data-idea-bad');                 
                  $.ajax({              
                      type: "POST",               
                      url: "process.php?action=",                
                      data: { ideaBadId: badIdeaId, action: "votebad" },                
                      success: function(data) {                                                         
                        updateData(data);                                            
                      },
                      error: function(a,b,c)
                      {
                        $('#no-idea').show(); 
                        $('#no-idea').addClass("alert alert-error");
                      }
                    });
              });
           
            $(".votegoodbutton").click(function(){                   
                $('#no-idea').hide();                      
                var goodIdeaId = this.getAttribute('data-idea-good');                              
                $.ajax({              
                    type: "POST",               
                    url: "process.php?action=",                
                    data: { ideaGoodId: goodIdeaId, action: "votegood" },                
                    success: function(data) {                                                                              
                      updateData(data);                
                    },
                      error: function(a,b,c)
                      {
                        $('#no-idea').show(); 
                        $('#no-idea').addClass("alert alert-error");
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
                  <a  class="addidea btn btn-inverse">Send</a>
                  <div id="no-idea"></div>
                </form>
            </div>
            <div class="row-fluid">        
                <h3 class="pink">Vote for the idea</h3>
                <div id="voting" class="well">                   
                    <?php        
                    $query = mysql_query("SELECT sum(good) + sum(bad) as'sum' FROM ideas");
                    $total =mysql_fetch_array($query);                  
                    $query = mysql_query("SELECT id, name, good, bad FROM ideas ORDER BY good desc");                       
                    while($row = mysql_fetch_array($query)){       
                        $good = ($row['good']>0)  ?  $row['good'] : 0;      
                        $bad = ($row['bad']>0)  ?  $row['bad']: 0;  
                        $allvotes = $good + $bad;  
                        $totalvotes = ($total['sum']==0)?1:$total['sum'];                      
                        $rank =  round(($allvotes/$totalvotes)*10);
                      ?>             
                      <div class='well'>
                        <div class="span1"><a class="votegoodbutton btn btn-inverse"  data-idea-good="<?php echo $row['id']?>" ><i class="icon-thumbs-up icon-white"></i><span class="votecount" id="idea-good-id-<?php echo $row['id']?>"><?php echo $good ?></span></a></div> 
                        <div class="span1"><a class="votebadbutton btn btn-inverse"   data-idea-bad="<?php echo $row['id'] ?>" ><i class="icon-thumbs-down icon-white"></i><span class="votecount" id="idea-bad-id-<?php echo $row['id']?>"><?php echo $bad ?></span></a></div>       
                        <div class='ideainfo'><span class='span10 ideaname' id="idea-name-<?php echo $row['id']?>"><?php echo $row['name'] ?></span></div>
                        <div id="idea-count-<?php echo $row['id']?>" class='good vote v-<?php echo $rank ?>'><span class="votecount" id="idea-all-id-<?php echo $row['id']?>"><?php echo $allvotes ?></span></div>
                      </div>                     
                  <?php } ?>  
                    
                </div>
            </div>      
    </section>
      <?php } ?></p>  
    <footer class="container-fluid ">
              
          <div class="well">                    
               <span style="color:#000"> Copyright 2012 - All ideas in this site are of sole ownership of the author. It can not be used without the permission of the author</span> 
               
            </div>
    </footer>


</body>
</html>