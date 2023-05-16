<?php

include "../connect.php";

include "favoriteService.php";


function endRequest($msg = "", $statusCode = 400)
{
    http_response_code($statusCode);
    echo json_encode(array("message" => $msg));
    die();
}

$body = json_decode(file_get_contents('php://input'), true);

$companyId = $body['companyId'] ? $body['companyId'] : endRequest("companyId is requied1");

$favoriteService = new FavoriteService($con);
$companyFavoriteServices = $favoriteService->getCompanyFavoriteService($companyId);

http_response_code(200);
echo "{\"data\":";
echo json_encode($companyFavoriteServices);
echo "}";
    