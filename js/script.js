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
                  $('#no-idea').show(); 
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
                        $('#voting').html(data);
                        $('#nameidea').val(""); 
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
                        $('#no-idea').hide();                                           
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
                      $('#no-idea').hide();          
                    },
                      error: function(a,b,c)
                      {
                        $('#no-idea').show(); 
                        $('#no-idea').addClass("alert alert-error");
                      }
                  });
              });                              
        })