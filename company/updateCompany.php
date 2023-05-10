<?php
    include "../connect.php";
    include "../company/company.php";
    include "../location/location.php";
    // include "../industry/industry.php";


    function endRequest($msg="",$statusCode=400){
        http_response_code($statusCode);
        echo json_encode(array("message" =>$msg));
        die();
    }

    $body = json_decode( file_get_contents('php://input'),true);

    $companyId = $body['companyId']? $body['companyId'] :endRequest("companyId is requied");
    $companyName = $body['name']? $body['name'] :endRequest("company name is requied");
    $email = $body['email']? $body['email'] :endRequest("email is requied");
    $password = $body['password']? $body['password'] :endRequest("password is requied");
    $contactName = $body['contactName']? $body['contactName'] :endRequest("contactName is requied");
    $contactPhone = $body['contactPhone']? $body['contactPhone'] :endRequest("contactPhone is requied");
    $address = $body['address']? $body['address'] :endRequest("address is requied");
    $locationId = $body['locationId']? $body['locationId'] :endRequest("locationId is requied");
    $lat = $body['lat']? $body['lat'] :endRequest("lat is requied");
    $lon = $body['lon']? $body['lon'] :endRequest("lon is requied");
    $size = $body['size']? $body['size'] :null;
    $industries = $body['industries']? $body['industries'] :[];
    
    $image= imageUpload('image');


    //update location
    $location = new Location($con);
    $newLocationId=$location->updateLocation($locationId,$lat,$lon);
    echo $newLocationId;

    //delete previous industries
    $stmt = $con->prepare("DELETE FROM `company_industry` WHERE `company_industry`.`companyId` = ?");
    $stmt->execute(array($companyId));
    
    $com_ind =[];
    
    $company = new Company($con);
    $companyId = $company->updateCompany($companyId,$companyName,$email,$password,$contactName,$contactPhone,$address,$size,$image);
    
    if($companyId != -1){
        foreach($industries as $industry){
            $industryObj = new Industry($con);
            $industryId=$industryObj->getIndustryByName($industry);
            if($industryId != -1 ){
                $companyIndustryId=$industryObj->createCompanyIndustry($companyId,$industryId);
                array_push($com_ind,$companyIndustryId);
            }
        }
        echo json_encode(array("data"=>$company->getCompany($companyId)));
    }else{
        $location->deleteLocation($locationId);
        http_response_code(400);
        echo json_encode(array("status"=>"failed to update company"));
    }