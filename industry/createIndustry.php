<?php

    include "../connect.php";
    include "industry.php";

    $body = json_decode( file_get_contents('php://input'),true);

    // $industryObj = new Industry($con);
    // $industry = $industryObj->createIndustry($body['industryName']);

    // if($industry != -1 ){
    //     http_response_code(201);
    //     echo json_encode(array("data"=> array($industry)));  
    // }else{
    //     http_response_code(404);
    //     echo json_encode(array("message"=> "email or passworded are wrong"));
    // }
?>