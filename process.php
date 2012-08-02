<?php
include 'conn.php'; 


function array2json($arr) { 
    if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
    $parts = array(); 
    $is_list = false; 

    //Find out if the given array is a numerical array 
    $keys = array_keys($arr); 
    $max_length = count($arr)-1; 
    if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
        $is_list = true; 
        for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position 
            if($i != $keys[$i]) { //A key fails at position check. 
                $is_list = false; //It is an associative array. 
                break; 
            } 
        } 
    } 

    foreach($arr as $key=>$value) { 
        if(is_array($value)) { //Custom handling for arrays 
            if($is_list) $parts[] = array2json($value); /* :RECURSION: */ 
            else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */ 
        } else { 
            $str = ''; 
            if(!$is_list) $str = '"' . $key . '":'; 

            //Custom handling for multiple data types 
            if(is_numeric($value)) $str .= $value; //Numbers 
            elseif($value === false) $str .= 'false'; //The booleans 
            elseif($value === true) $str .= 'true'; 
            else $str .= '"' . addslashes($value) . '"'; //All other things 
            // :TODO: Is there any more datatype we should be in the lookout for? (Object?) 

            $parts[] = $str; 
        } 
    } 
    $json = implode(',',$parts); 
     
    if($is_list) return '[' . $json . ']';//Return numerical JSON 
    return '{' . $json . '}';//Return associative JSON 
} 

function getPollData(){                               
    $query = mysql_query("SELECT sum(good)as'sum' FROM ideas");
    $count =mysql_fetch_array($query);
    $query = mysql_query("SELECT id, name, good, bad FROM ideas ORDER BY good desc");                         
    $data = array();
    while($row = mysql_fetch_array($query)){       

        $good = ($row['good']>0)  ?  " ( +".$row['good'].")" : "";      
        $bad = ($row['bad']>0)  ?  " ( - ".$row['bad'].")" : "";      
     
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