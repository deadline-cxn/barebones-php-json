<?php 
include("funcs.php");
// for($i=0;$i<count($argv);$i++) {  echo $i." ".$argv[$i]."\n"; }
switch($argv[1]) {

    case "create_guid":
        echo "\n\n";
        echo create_guid();
        echo "\n\n";
        break;
    

    default:
        break;

}
