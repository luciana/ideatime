<?php
include 'conn.php'; 

function getPollData(){                               
    $query = mysql_query("SELECT sum(good) + sum(bad) as 'sum' FROM ideas");
    $count =mysql_fetch_array($query);
    $query = mysql_query("SELECT id, name, good, bad FROM ideas ORDER BY good, name desc");                         
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

function showData(){
        $query = mysql_query("SELECT sum(good) + sum(bad) as'sum' FROM ideas");
        $total =mysql_fetch_array($query);                  
        $query = mysql_query("SELECT id, name, good, bad FROM ideas ORDER BY good desc"); 
        $data ='';                      
        while($row = mysql_fetch_array($query)){       
            $id = $row['id'];
            $good = ($row['good']>0)  ?  $row['good'] : 0;      
            $bad = ($row['bad']>0)  ?  $row['bad']: 0;  
            $allvotes = $good + $bad;  
            $totalvotes = ($total['sum']==0)?1:$total['sum'];                      
            $rank =  round(($allvotes/$totalvotes)*10);
            $data .= "<div class='well'>";
            $data .='<div class="span1"><a class="votegoodbutton btn btn-inverse"  data-idea-good="'.$id.'" ><i class="icon-thumbs-up icon-white"></i><span class="votecount" id="idea-good-id-'.$id.'">'.$good.'</span></a></div>';
            $data .='<div class="span1"><a class="votebadbutton btn btn-inverse"   data-idea-bad="'.$id.'" ><i class="icon-thumbs-down icon-white"></i><span class="votecount" id="idea-bad-id-'.$id.'">'.$bad.'</span></a></div>';     
            $data .= '<div class="ideainfo"><span class="span10 ideaname" id="idea-name-'.$id.'">'.$row['name'].'</span></div>';
            $data .= '<div id="idea-count-'.$id.'" class="good vote v-'.$rank.'"><span class="votecount" id="idea-all-id-'.$id.'">'.$allvotes.'</span></div>';
            $data .= '</div>';              
        } 
        echo $data;
    } 
?>