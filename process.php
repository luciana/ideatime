<?php
include 'conn.php'; 
include 'functions.php'; 

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
        echo showData();
       //die();
   }
}
die();
?>