<?php

    include "../connect.php";
    include "industry.php";

    $industryObj = new Industry($con);
    $industry = $industryObj->getIndustries();

    if($industry != -1 ){
        http_response_code(200);
        echo json_encode(array("data"=>$industry));  
    }else{
        http_response_code(500);
        echo json_encode(array("message"=> "failed to get industies"));
    }
?>
