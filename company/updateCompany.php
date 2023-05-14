<?php
    include "../connect.php";
    include "../company/company.php";
    include "../location/location.php";

    function endRequest($msg="",$statusCode=400){
        http_response_code($statusCode);
        echo json_encode(array("message" =>$msg));
        die();
    }


//     {
//     "companyId":23,
//     "locationId":"25",
//     "name":"pharmacyy",
//     "email":"pharmacy866@gmail.com",
//     "password":"12345678",
//     "contactName":"gaber",
//     "contactPhone":"01563289654",
//     "address":"maadi",
//     "size":"Small",
//     "lat":"3.666699",
//     "lon":"3.666666",
//     "industries":["food"]
// }

    $companyId = isset($_POST['companyId'])? $_POST['companyId'] :endRequest("companyId is requied2");
    $companyName = isset($_POST['name'])? $_POST['name'] :endRequest("company name is requied");
    $email = isset($_POST['email'])? $_POST['email'] :endRequest("email is requied");
    $password = isset($_POST['password'])? $_POST['password'] :endRequest("password is requied");
    $contactName = isset($_POST['contactName'])? $_POST['contactName'] :endRequest("contactName is requied");
    $contactPhone = isset($_POST['contactPhone'])? $_POST['contactPhone'] :endRequest("contactPhone is requied");
    $address = isset($_POST['address'])? $_POST['address'] :endRequest("address is requied");
    $locationId = isset($_POST['locationId'])? $_POST['locationId'] :endRequest("locationId is requied");
    $lat = isset($_POST['lat'])? $_POST['lat'] :endRequest("lat is requied");
    $lon = isset($_POST['lon'])? $_POST['lon'] :endRequest("lon is requied");
    $size = isset($_POST['size'])? $_POST['size'] :null;
    $industries = isset($_POST['industries'])? $_POST['industries'] :[];
    $image= imageUpload('image');

    $industries = explode('[', $industries)[1];
    $industries = explode(']', $industries)[0];
    $industries = explode(',', $industries);

    //update location
    $location = new Location($con);
    $newLocationId=$location->updateLocation($locationId,$lat,$lon);

    //delete previous industries
    $stmt = $con->prepare("DELETE FROM `company_industry` WHERE `company_industry`.`companyId` = ?");
    $stmt->execute(array($companyId));
    
    $com_ind =[];
    
    $company = new Company($con);
    
    if($image != null){
        $companyId = $company->updateCompanyWithImage($companyId,$companyName,$email,$password,$contactName,$contactPhone,$address,$size,$image);
    }else{
        $companyId = $company->updateCompanyWithoutImage($companyId,$companyName,$email,$password,$contactName,$contactPhone,$address,$size);
    }
    
    if($companyId != -1){
        if(count($industries) != 0){
            foreach($industries as $industry){
                $industryObj = new Industry($con);
                $industryId=$industryObj->getIndustryByName(ltrim($industry));
                if($industryId != -1 ){
                    $companyIndustryId=$industryObj->createCompanyIndustry($companyId,$industryId);
                    array_push($com_ind,$companyIndustryId);
                }
            }
        }
        //echo $companyId;
        echo json_encode(array("data"=>$company->getCompany($companyId)));
    }else{
        //$location->deleteLocation($locationId);
        //http_response_code(400);
        echo json_encode(array("status"=>"failed to update company"));
    }





///////////////////////////////////////////////////////////////////////////////////////



     // include "../industry/industry.php";

    // $email = $_POST['email'];
    // echo $email;
    // $image = $_POST['image'];
    // echo gettype($image);
    // echo $image;
    // echo json_encode($_FILES['image']);
    // echo json_decode($image);
    // Get the request data
    // $requestData = json_decode(file_get_contents('php://input'));
    // echo json_encode($requestData);
    // $image = $requestData['image'];
    // echo $image;
    // echo json_encode($image);


    // Print the request data
    // print_r($requestData);

    // $body = json_decode( file_get_contents('php://input'),true);
    // // $email = $body['email']? $body['email'] : "there is no email id recived";

    // // http_response_code(200);
    // // echo json_encode(array("email" =>  $email , "image" => $_FILES['image']));
    

   


    // $companyId = $body['companyId']? $body['companyId'] :endRequest("companyId is requied2");
    // $companyName = $body['name']? $body['name'] :endRequest("company name is requied");
    // $email = $body['email']? $body['email'] :endRequest("email is requied");
    // $password = $body['password']? $body['password'] :endRequest("password is requied");
    // $contactName = $body['contactName']? $body['contactName'] :endRequest("contactName is requied");
    // $contactPhone = $body['contactPhone']? $body['contactPhone'] :endRequest("contactPhone is requied");
    // $address = $body['address']? $body['address'] :endRequest("address is requied");
    // $locationId = $body['locationId']? $body['locationId'] :endRequest("locationId is requied");
    // $lat = $body['lat']? $body['lat'] :endRequest("lat is requied");
    // $lon = $body['lon']? $body['lon'] :endRequest("lon is requied");
    // $size = $body['size']? $body['size'] :null;
    // $industries = $body['industries']? $body['industries'] :[];
    // //$image = $_FILES['image'];
    // // $image = null;