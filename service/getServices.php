<?php

    include "../connect.php";
    include "service.php";

    $serviceObj = new Service($con);
    $services = $serviceObj->getServices();

    if($services != []){
        http_response_code(200);
        echo json_encode(array("data"=>$services));  
    }else{
        http_response_code(500);
        echo json_encode(array("message"=> "failed to get services"));
    }
?>
