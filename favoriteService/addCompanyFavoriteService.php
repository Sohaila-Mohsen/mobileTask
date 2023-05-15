<?php
    include "../connect.php";

    include "favoriteService.php";

    
    function endRequest($msg="",$statusCode=400){
        http_response_code($statusCode);
        echo json_encode(array("message" =>$msg));
        die();
    }
    
    $body = json_decode( file_get_contents('php://input'),true);
    
    $companyId = $body['companyId']? $body['companyId'] :endRequest("companyId is requied1");
    $serviceId = $body['serviceId']? $body['serviceId'] :endRequest("serviceId is requied1");

    $favoriteService = new FavoriteService($con);
    $favoriteServiceId = $favoriteService->addFavoriteService($companyId,$serviceId);

    if($favoriteServiceId != -1 ){
        http_response_code(200);
        echo json_encode(array($favoriteServiceId));  
    }else{
        http_response_code(500);
        echo json_encode(array("message"=> "failed to add favorite service"));
    }