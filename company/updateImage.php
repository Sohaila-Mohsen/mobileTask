<?php
    include "../connect.php";

    function endRequest($msg){
        echo json_encode(array("message" =>$msg));
        die();
    }

    $comanyId = isset($_POST['companyId'])? filterRequest('companyId') : endRequest("companyId is required");
    
    $image = imageUpload('image');

    $stmt = $con->prepare("UPDATE `company` SET `image` = ? WHERE `company`.`companyId` = ? ");
    $stmt->execute(array( $image,$comanyId));
    
    $count = $stmt->rowCount();
    if($count > 0){
        http_response_code(200);
        echo json_encode(array("message"=>"image added successfult","data"=>array("image"=>$image)));
    }else{
        http_response_code(404);
        endRequest("no company with this id : ".$comanyId." or no changes made");
    }
