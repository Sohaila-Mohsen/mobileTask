<?php

class Industry {

    public $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function createIndustry($industryName){

        $stmt = $this->con->prepare("INSERT INTO `industry` (`name`) VALUES (?)");
        $stmt->execute(array($industryName));

        $count = $stmt->rowCount();
        
        if($count>0){
            $industry = $this->con->lastInsertId();
            return $industry; 
        }else{
            return -1;
        }
    }

    public function getIndustries(){

        $stmt = $this->con->prepare("SELECT * FROM industry");
        $stmt->execute();

        $count = $stmt->rowCount();
        
        if($count>0){
            $industry = $stmt->fetchAll (PDO::FETCH_ASSOC);
            return $industry; 
        }else{
            return -1;
        }
    }

    public function getIndustryByName($industryName){

        $stmt = $this->con->prepare("SELECT industryId FROM industry WHERE `name`=?");
        $stmt->execute(array($industryName));

        $count = $stmt->rowCount();
        
        if($count>0){
            $industryId = $stmt->fetch (PDO::FETCH_ASSOC);
            return implode("",$industryId); 
        }else{
            return -1;
        }
    }


    public function createCompanyIndustry($companyId,$industryId){

        $stmt = $this->con->prepare("INSERT INTO `company_industry` (`companyId`, `industryId`) VALUES (?,?)");
        $stmt->execute(array($companyId, $industryId ));

        $count = $stmt->rowCount();
        
        if($count>0){
            $companyIndustryId = $this->con->lastInsertId();
            return $companyIndustryId; 
        }else{
            return -1;
        }
    }
    

    public function getCompanyIndustries($companyId){

        
        $query = "SELECT i.industryId , i.name as industryName
        FROM company c 
        INNER JOIN company_industry c_i ON c_i.companyId = c.companyId 
        INNER JOIN industry i ON i.industryId =  c_i.industryId 
        WHERE c.companyId = ?";
        
        $stmt = $this->con->prepare($query);
        $stmt->execute(array($companyId));

        $count = $stmt->rowCount();
        
        if($count>0){
            $industries = $stmt->fetchAll (PDO::FETCH_ASSOC);
            return $industries; 
        }else{
            return [];
        }
    }
    
    
}