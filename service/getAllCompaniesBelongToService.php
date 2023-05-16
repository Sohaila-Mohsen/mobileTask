<?php
    include "../connect.php";

    // include "service.php";
    include "../company/company.php";

    
    function endRequest($msg="",$statusCode=400){
        http_response_code($statusCode);
        echo json_encode(array("message" =>$msg));
        die();
    }
    $body = json_decode( file_get_contents('php://input'),true);
    
    $serviceId = $body['serviceId']? $body['serviceId'] :endRequest("serviceId is requied1");
    
    $serviceObj = new Service($con);
    $companiesIds = $serviceObj->getCompaniesByService($serviceId);

    $companies=[];

    $company= new Company($con);
    foreach($companiesIds as $companyId){
        $companies[]=$company->getCompany($companyId['companyId']);
    }

    http_response_code(500);
    echo json_encode(array("data"=>$companies));  