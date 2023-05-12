<?php
    include "../connect.php";
    include "../company/company.php";

    function endRequest($msg="",$statusCode=400){
        http_response_code($statusCode);
        echo json_encode(array("message" =>$msg));
        die();
    }

    $body = json_decode( file_get_contents('php://input'),true);

    $email = $body['email']? $body['email'] :endRequest("email is requied");
    $password = $body['password']? $body['password'] :endRequest("password is requied");

    $query = "SELECT companyId  FROM company c WHERE `email` = ? AND `password`=?";
    $stmt = $con->prepare($query);
    $stmt->execute(array($email,$password));

    $count = $stmt->rowCount();
    
    if($count>0){
        $companyId = implode("",$stmt->fetch(PDO::FETCH_ASSOC));
        $company = new Company($con);
        http_response_code(200);
        echo json_encode(array("data"=>$company->getCompany($companyId)));
    }else{
        http_response_code(404);
        echo json_encode(array("message"=> "email or passworded are wrong"));
    }
?>
