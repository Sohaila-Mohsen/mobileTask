<?php
    include "../industry/industry.php";
    include "../service/service.php";

    class Company {
        private $con;

        public function __construct($con){
            $this->con = $con;
        }

        public function getCompany($companyId){

            // 1) get comapany has this id and it location
            $query = "SELECT * 
                      FROM company c 
                      LEFT JOIN location l ON c.locationId =l.locationId
                      WHERE c.companyId = ? ";
            $stmt = $this->con->prepare($query);
            $stmt->execute(array($companyId));

            $count = $stmt->rowCount();
            if($count>0){
                $company = $stmt->fetch(PDO::FETCH_ASSOC);

                // 2) get industry and append it to the company
                $industryObj = new Industry($this->con);
                $serviceObj = new Service($this->con);
                $company['industries']= $industryObj->getCompanyIndustries($companyId);
                $company['services']= $serviceObj->getCompanyServices($companyId);
                return $company;  
            }else{
                http_response_code(404);
                echo json_encode(array("message"=> "No company found with this id" . $companyId));
            }
            
            // 3) get services and append it to the company

            // ) return company
        }

        public function createCompany($locationId,$companyName,$email,$password,$contactName,$contactPhone,$address,$size,$image){

            // 1) create company
            $stmt = $this->con->prepare("INSERT INTO `company` (`locationId`, `name`, `email`, `password`, `contactName`, `contactPhone`, `address`, `size`,`image`) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
            $stmt->execute(array($locationId,$companyName,$email,$password,$contactName,$contactPhone,$address,$size,$image));
            $companyId = $this->con->lastInsertId();

            $count = $stmt->rowCount();
            if($count >0){
                return $companyId;
            }else{
                return -1;
            }
            // 2) call create location
            // 3) call create industry

            // ) return company
        }
        public function updateCompanyWithImage($companyId,$companyName,$email,$password,$contactName,$contactPhone,$address,$size,$image){

            // 1) create company
            $query = "UPDATE `company` SET `name` = ?, `email` = ?,`password` = ?, `contactName` = ?, `contactPhone` = ?, `address` = ? ,`size` =?, `image` =? WHERE `company`.`companyId` = ?";

            $stmt = $this->con->prepare($query);
            $stmt->execute(array($companyName,$email,$password,$contactName,$contactPhone,$address,$size,$image,$companyId));
            return $companyId;
            
            // $count = $stmt->rowCount();
            // if($count >0){
            // }else{
            //     return -1;
            // }
            // 2) call create location
            // 3) call create industry

            // ) return company
        }



        public function updateCompanyWithoutImage($companyId,$companyName,$email,$password,$contactName,$contactPhone,$address,$size){

            // 1) create company
            $query = "UPDATE `company` SET `name` = ?, `email` = ?,`password` = ?, `contactName` = ?, `contactPhone` = ?, `address` = ? ,`size` =? WHERE `company`.`companyId` = ?";

            $stmt = $this->con->prepare($query);
            $stmt->execute(array($companyName,$email,$password,$contactName,$contactPhone,$address,$size,$companyId));
            return $companyId;
            
            // $count = $stmt->rowCount();
            // if($count >0){
            // }else{
            //     return -1;
            // }
            // 2) call create location
            // 3) call create industry

            // ) return company
        }

    }

?>