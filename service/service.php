<?php

class Service {

    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function getCompanyServices($companyId){

        
        $query = "SELECT s.serviceId , s.name as serviceName
        FROM company c 
        INNER JOIN company_service c_s ON c_s.companyId = c.companyId 
        INNER JOIN service s ON s.serviceId =  c_s.serviceId 
        WHERE c.companyId = ?";
        
        $stmt = $this->con->prepare($query);
        $stmt->execute(array($companyId));

        $count = $stmt->rowCount();
        
        if($count>0){
            $services = $stmt->fetchAll (PDO::FETCH_ASSOC);
            return $services; 
        }else{
            return [];
        }
    }
    
    
}