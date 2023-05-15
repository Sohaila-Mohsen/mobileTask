<?php

class FavoriteService {

    public $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function addFavoriteService($companyId,$serviceId){

        $stmt = $this->con->prepare("INSERT INTO `company_fav_service` (`companyId`, `serviceId`) VALUES ( ?, ?)");
        $stmt->execute(array($companyId,$serviceId));

        $count = $stmt->rowCount();
        
        if($count>0){
            $favServiceId = $this->con->lastInsertId();
            return $favServiceId; 
        }else{
            return -1;
        }
    }

    public function getCompanyFavoriteService($companyId){

        $stmt = $this->con->prepare("SELECT * from `service` WHERE `serviceId` IN (SELECT serviceId FROM `company_fav_service` WHERE `companyId` = ? ) ");
        $stmt->execute(array($companyId));
        $companyFavoriteServices = $stmt->fetchAll (PDO::FETCH_ASSOC);
        if(count($companyFavoriteServices) >0){
            return $companyFavoriteServices;
        }else{
            return [];
        }
        
    }

    
    
}