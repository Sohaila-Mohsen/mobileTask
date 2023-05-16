<?php
    include "../connect.php";

    function endRequest($msg="",$statusCode=400){
        http_response_code($statusCode);
        echo json_encode(array("message" =>$msg));
        die();
    }

    $body = json_decode( file_get_contents('php://input'),true);

    $lat1 = $body['lat1']? $body['lat1'] :endRequest("lat1 is requied1");
    $lon1 = $body['lon1']? $body['lon1'] :endRequest("lon1 is requied1");
    $lat2 = $body['lat2']? $body['lat2'] :endRequest("lat2 is requied1");
    $lon2 = $body['lon2']? $body['lon2'] :endRequest("lon2 is requied1");

    function degrees_to_radians($degrees) {
        return $degrees * (M_PI / 180);
    }
      
    function hav($theta) {
        return (1 - cos($theta)) / 2;
    }
    
    function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $lat1 = degrees_to_radians($lat1);
        $lon1 = degrees_to_radians($lon1);
        $lat2 = degrees_to_radians($lat2);
        $lon2 = degrees_to_radians($lon2);
        
        $dLat = $lat1 - $lat2;
        $dLon = $lon1 - $lon2;
        
        $R = 6371;
        
        // hav(theta) = (1-cos(theta)) /2
        
        // Haversin angle
        $havAngle = hav($dLat) + cos($lat1) * cos($lat2) * hav($dLon);
        $centralAngle =
        2 * atan2(sqrt($havAngle), sqrt(1 - $havAngle));
        $distance = $R * $centralAngle;
        return $distance;
    }

    http_response_code(200);
    echo json_encode(array("distance"=>calculateDistance($lat1, $lon1, $lat2, $lon2)));