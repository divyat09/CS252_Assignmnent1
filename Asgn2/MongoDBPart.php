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

    $Max=0;
    $DistrictRes;
    foreach( $DistrictArr as $key => $value ){
        if($Max<$value){
            $Max= $value;
            $DistrictRes= $key;
        }
        #echo $key;
        #echo " : ";
        #echo $value;
        #echo "\n";
    }

    # Answer
    echo " District that has the most crime reported per capita : ";
    echo $DistrictRes; 
    echo "\n";


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

    $Max=0;
    $PSRes;
    foreach( $PSArr as $key => $value ){
        if($Max<$value){
            $Max= $value;
            $PSRes= $key;
        }
        #echo $key;
        #echo " : ";
        #echo $value;
        #echo "\n";
    }

    # Answer
    echo "Police Station that is the most inefficient in completing investigations: ";
    echo $PSRes; 
    echo "\n";


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

    $Max=0;
    $Min=0;
    $MaxRepLaw;
    $MinRepLaw;

    foreach( $LawsArr as $key => $value ){
        
        if($Max<$value){
            $Max= $value;
            $MaxRepLaw= $key;
        }

        #echo $key;
        #echo " : ";
        #echo $value;
        #echo "\n";

    }

    # Answer
    echo "crime laws that are most uniquely applied in FIRs :";
    echo $MaxRepLaw; 
    echo "\n";
    #echo $Max; 
    #echo "\n";


} catch (MongoDB\Driver\Exception\Exception $e) {

    $filename = basename(__FILE__);
    
    echo "The $filename script has experienced an error.\n"; 
    echo "It failed with the following exception:\n";
    
    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";       
}

?>
