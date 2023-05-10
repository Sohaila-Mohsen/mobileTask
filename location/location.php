<?php

class Location {

    public $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function createLocation($lat,$lon){

        $stmt = $this->con->prepare("INSERT INTO `location` (`lat`,`lon`) VALUES (?,?)");
        $stmt->execute(array($lat,$lon));

        $count = $stmt->rowCount();
        
        if($count>0){
            $locationId = $this->con->lastInsertId();
            return $locationId; 
        }else{
            return -1;
        }
    }
    public function updateLocation($locationId,$lat,$lon){

        $stmt = $this->con->prepare("UPDATE `location` SET `lat` = ?, `lon` = ? WHERE `location`.`locationId` =?");
        $stmt->execute(array($lat,$lon,$locationId));

        $count = $stmt->rowCount();
        
        if($count>0){
            return $locationId; 
        }else{
            return -1;
        }
    }
    public function deleteLocation($locationId){

        $stmt = $this->con->prepare("DELETE FROM `location` WHERE `location`.`locationId` =$locationId;");
        $stmt->execute();
    }
}