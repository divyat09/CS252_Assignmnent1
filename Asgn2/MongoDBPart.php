<!DOCTYPE html>
<html>
<body>
<h1>U.P. Police FIR Data</h1>

<?php

try {

	# Connection
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

    # Database Statistics
    #$stats = new MongoDB\Driver\Command(["dbstats" => 1]);
    #$res = $mng->executeCommand("CS252", $stats);
    #$stats = current($res->toArray());
    #print_r($stats);

    # TASK 1
    $filter = [ ];
    $query = new MongoDB\Driver\Query($filter);  
    $rows = $mng->executeQuery("CS252.FIRData", $query);

    $DistrictArr=array();

    foreach($rows as $row) {

        if (array_key_exists($row->DISTRICT, $DistrictArr)){
            $DistrictArr[$row->DISTRICT]= $DistrictArr[$row->DISTRICT]+1;            
        }
        else{
             $DistrictArr[$row->DISTRICT]=1; 
        }
    }        

    // $Max=0;
    // $DistrictRes;
    // foreach( $DistrictArr as $key => $value ){
    //     if($Max<$value){
    //         $Max= $value;
    //         $DistrictRes= $key;
    //     }
    //     #echo $key;
    //     #echo " : ";
    //     #echo $value;
    //     #echo "\n";
    // }

    $Max=max($DistrictArr);
    $DistrictRes= array_search( max($DistrictArr), $DistrictArr); 
    echo "<h3> Most crime per capita </h3>";
    # Answer
    echo "<p>";
    echo $DistrictRes;
    echo " District leads in crime in per capita cateogry with  "; 
    echo $Max;
    echo " cases reported ";
    echo "<p>";


    # TASK 2
    $filter = [ "Status" => "Pending" ];
    $query = new MongoDB\Driver\Query($filter);  
    $rows = $mng->executeQuery("CS252.FIRData", $query);

    $PSArr=array();

    foreach($rows as $row) {

        if (array_key_exists($row->PS, $PSArr)){
            $PSArr[$row->PS]= $PSArr[$row->PS]+1;            
        }
        else{
             $PSArr[$row->PS]=1;   
        }
    }        

    $Max=max($PSArr);
    $PSRes= array_search( max($PSArr), $PSArr); 
    echo "<h3> Most inefficient in completing investigations </h3>";
    echo "<p>";
    echo $PSRes;
    echo " Police Station that is the most inefficient in completing investigations with a total of   "; 
    echo $Max;
    echo " cases pending ";
    echo "<p>";



    # TASK 3
    $filter = [];
    $query = new MongoDB\Driver\Query($filter);  
    $rows = $mng->executeQuery("CS252.FIRData", $query);

    $LawsArr=array();
    foreach($rows as $row) {

        $CrimeLaws= $row->Act_Section;
        foreach($CrimeLaws as $Item) {

            // echo $Item;
            // echo "\n";                

            if (array_key_exists($Item, $LawsArr)){
                $LawsArr[$Item]= $LawsArr[$Item]+1;            
            }
            else{
                 $LawsArr[$Item]=1;   
            }
            
        }        
    }

    echo "<h3> Most Reported Crime Laws</h3>";

    $Max=max($LawsArr);
    $MaxRepLaw= array_search( max($LawsArr), $LawsArr); 

    echo "<p>";
    echo $MaxRepLaw; 
    echo " is the most reported crime law, total of ";
    echo $Max;
    echo " FIR applications have reported it so far " ;
    echo "<p>";

    echo "<h3> Least Reported Crime Laws</h3>";

    $Min=min($LawsArr);
    $MinRepLaw= array_keys( $LawsArr, min($LawsArr)); 

    echo "<p>";
    echo " The following are the least reported crime laws, only them occur in only  ";
    echo $Min;
    echo " FIR application each" ;
    echo "<ul>";
    foreach($MinRepLaw as $Key){
            echo "<li>";
            echo $Key;
            echo "</li>";
    }
    echo "</ul>";
    echo "<p>";



} catch (MongoDB\Driver\Exception\Exception $e) {

    $filename = basename(__FILE__);
    
    echo "The $filename script has experienced an error.\n"; 
    echo "It failed with the following exception:\n";
    
    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";       
}

?>

</body>
</html>