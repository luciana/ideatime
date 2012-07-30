<?php
include 'conn.php'; 


function getPollData(){                               
    $query = mysql_query("SELECT sum(votes)as'sum' FROM ideas");
    $count =mysql_fetch_array($query);
    $query = mysql_query("SELECT id, name, votes FROM ideas ORDER BY votes desc");                       
    while($row = mysql_fetch_array($query)){       
        $votes = ($row['votes']>0)  ?  " (".$row['votes'].")" : "";      
        $rank =  ($row['votes']>0)  ?  round(($row['votes']/$count['sum'])*10): "0";      
        $hasvoted = false;
        echo "<li >";
        if(!$hasvoted)
          echo '<button class="votebutton btn btn-warning" id="i-'.$row['id'].'" type="submit" data-idea="'.$row['id'].'" >vote</button>';
        echo "<span>".$row['name']. $votes."</span><div class='vote v-".$rank."'></div>";                                                        
        echo "</li>";
    }
  }

if (isset($_POST['action'])=='vote') {
	if(isset($_POST['ideaId'])){
		$id = $_POST['ideaId'];
		$query  = "UPDATE ideas SET votes = votes + 1 WHERE id =".$id;
		mysql_query($query);
	}
}

if (isset($_POST['action'])=='add') {
	if(isset($_POST['name']) && isset($_POST['author'])){
		$name = $_POST['name'];
		$author =  $_POST['author'];
		$query  = "INSERT INTO ideas (name, author) VALUES ('".$name."', '".$author."')";	
		mysql_query($query);		
	}	
}

echo getPollData();
?>