<?php
include 'conn.php'; 


function getPollData(){                               
    //$query = mysql_query("SELECT sum(good)as'sum' FROM ideas");
    //$count =mysql_fetch_array($query);
    $query = mysql_query("SELECT id, name, good, bad FROM ideas ORDER BY good desc");                       
    $out ='';
    while($row = mysql_fetch_array($query)){       

        $good = ($row['good']>0)  ?  " ( +".$row['good'].")" : "";      
        $bad = ($row['bad']>0)  ?  " ( - ".$row['bad'].")" : "";      
      //  $rank =  ($row['good']>0)  ?  round(($row['good']/$count['sum'])*10): "0";              
        $out .= "<div class='well'>";      
        $out .= '<div class="span1"><button class="votegoodbutton btn btn-inverse" id="i-'.$row['id'].'" type="submit" data-idea-good="'.$row['id'].'" ><i class="icon-thumbs-up icon-white"></i></button></div>'; 
        $out .=  '<div class="span1"><button class="votebadbutton btn btn-inverse" id="i-d-'.$row['id'].'" type="submit" data-idea-bad="'.$row['id'].'" ><i class="icon-thumbs-down icon-white"></i></button></div>';       
        $out .=  "<span class='span10 ideaname'>".$row['name']. $good. $bad."</span><br>";                                                            
        $out .=  "</div>";
        //echo "<div class='vote v-".$rank."'></div>";  
    }
    echo $out;
  }

if (isset($_POST['action'])=='votegood') {
	if(isset($_POST['ideaGoodId'])){
		$id = $_POST['ideaGoodId'];
		$query  = "UPDATE ideas SET good = good + 1 WHERE id =".$id;
		mysql_query($query);
       echo getPollData();
	}
}

if (isset($_POST['action'])=='votebad') {
    if(isset($_POST['ideaBadId'])){
        $id = $_POST['ideaBadId'];
        $query  = "UPDATE ideas SET bad = bad + 1 WHERE id =".$id;
        mysql_query($query);
       echo getPollData();
    }
}

if (isset($_POST['action'])=='add') {
	if(isset($_POST['name']) && isset($_POST['author'])){
		$name = $_POST['name'];
		$author =  $_POST['author'];
		$query  = "INSERT INTO ideas (name, author) VALUES ('".$name."', '".$author."')";	
		mysql_query($query);	
        echo getPollData();	
	}	
}
?>