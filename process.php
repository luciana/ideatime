<?php
include 'conn.php'; 

function getPollData(){                               
    $query = mysql_query("SELECT sum(good) + sum(bad) as 'sum' FROM ideas");
    $count =mysql_fetch_array($query);
    $query = mysql_query("SELECT id, name, good, bad FROM ideas ORDER BY good desc");                         
    $data = array();
    while($row = mysql_fetch_array($query)){        
        $out = array(
                'id' => $row['id'],
                'bad' => $row['bad'],
                'good' => $row['good'],
                'name'=> $row['name'],
                'total'=> $count['sum']                
            );
        array_push($data,$out);
    }
    return json_encode($data);
  }

if (isset($_POST['action'])=='votegood') {
    $id = $_POST['ideaGoodId'];
    if(isset($id)){       
        $query  = "UPDATE ideas SET good = good + 1 WHERE id =".$id;
        mysql_query($query);
        echo getPollData();
       die();
    }
}

if (isset($_POST['action'])=='votebad') {
    $id = $_POST['ideaBadId'];
    if(isset($id)){     
        $query  = "UPDATE ideas SET bad = bad + 1 WHERE id =".$id;
        mysql_query($query);
       echo getPollData();
       die();

    }
}

if (isset($_POST['action'])=='addidea') {
    $name = $_POST['name'];
    $author = $_POST['author'];
    if(isset($name) && isset($author)){
        $query  = "INSERT INTO ideas (name, author) VALUES ('$name','$author')";
        mysql_query($query);
        echo getPollData();
       die();
   }
}
die();
?>