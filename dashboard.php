<?php



include "connect.php" ;
// $stmt = $con->prepare("SELECT * FROM service ORDER BY serviceId DESC");
// $stmt->execute();
// $services =$stmt ->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// echo json_encode($services);
// echo "</pre>";

// $stmt = $con->prepare("INSERT INTO `service` (`name`) VALUES (?)");
// $stmt->execute(array("chat service"));
// $serviceID =$con ->lastInsertId();
$serviceID =1;


$stmt = $con->prepare("UPDATE service SET name= ? WHERE serviceId=?");
$stmt->execute(array("3d-printing",$serviceID));

$stmt = $con->prepare("SELECT  * FROM service WHERE serviceId=$serviceID");
$stmt->execute();
$service = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<pre>";
echo json_encode($service);
echo "</pre>";

echo "How are you ". $_GET['name'];

?>

<!-- <?php
    include "../connect.php";

    function getLocation($con,$locationId){
        $stmt = $con->prepare("SELECT lat , lon FROM location WHERE `locationId` = ? ");
        $stmt->execute(array($locationId));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // function getIndustry($con,$companyId){
    //     $stmt = $con->prepare("SELECT `industryId` FROM  `company_industry` WHERE `companyId` = ? ");
    //     $stmt->execute(array($companyId));
    //     if($stmt->rowCount()>0){
    //         $industryId= $stmt->fetch(PDO::FETCH_ASSOC);
    //         echo json_decode($industryId);
    //     }else{
    //         echo "no industryid found";
    //     }
    // }

    $email= filterRequest('email');
    $password= filterRequest('password');

    $stmt = $con->prepare("SELECT * FROM company WHERE `email` = ? AND `password`=?");
    $stmt->execute(array($email,$password));

    $count = $stmt->rowCount();
    
    if($count>0){
        $company = $stmt->fetch(PDO::FETCH_ASSOC);
        $company['locationId']= getLocation($con,$company['locationId']);
        // getIndustry($con,$company['companyId']);
        echo json_encode($company);  
    }else{
        echo json_encode(array("status"=> "email or passworded are wrong"));
    }
?> -->