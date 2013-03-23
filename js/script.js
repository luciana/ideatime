$(function() {    

$('input').bind('focus', function(){
      dataLayer.push({
             'event': 'GAEvent', 
             'eventCategory':window.location.href, 
             'eventAction':$(this).attr('name'), 
             'eventLabel':'test1'
     });
});

$('a').bind('click', function(){
      
      dataLayer.push({
             'event': 'GAEvent', 
             'eventCategory':window.location.href, 
             'eventAction':$(this).attr('name'), 
             'eventLabel':'test'
     });
});

$('.tracking').bind('click.dontclick', function(e) {

     e.preventDefault();
     dataLayer.push({
             'event': 'GAEvent', 
             'eventCategory':window.location.href, 
             'eventAction':$(this).attr('name'), 
             'eventLabel':$(this).text()
     });
});




$('#sendIdea').click(function() { 
  var idea = $('#ideaName').val();
  
  if (!idea || idea == 'what is the idea name?') {
    alert('Please enter your idea');
    return false;
  }
  
  var form_data = {
    idea: idea,
    author: "<?php echo $_SESSION['username'] ?>",
    group: "<?php echo $_SESSION['group'] ?>", 
    ajax: '1'   
  };
  
  $.ajax({
    url: "<?php echo site_url('ideas/submit'); ?>",
    type: 'POST',
    data: form_data,
    success: function(msg) {
      $('#voting').append(msg);
      $('#ideaName').val('what is the idea name?');
    }
  });
  
  return false;
});               
        })