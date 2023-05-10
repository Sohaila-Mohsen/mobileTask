<?php

    include "../connect.php";
    include "company.php";

    function endRequest($msg="",$statusCode=400){
        http_response_code($statusCode);
        echo json_encode(array("message" =>$msg));
        die();
    }

    $body = json_decode( file_get_contents('php://input'),true);

    $companyId = $body['companyId']? $body['companyId'] :endRequest("companyId is requied");
    $companyObj = new Company($con);
    $company = $companyObj->getCompany($companyId);

    if($company != -1 ){
        http_response_code(200);
        echo json_encode(array("data"=>$company));  
    }else{
        http_response_code(500);
        echo json_encode(array("message"=> "failed to get industies"));
    }
?>