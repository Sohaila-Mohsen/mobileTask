<?php 


function filterRequest($requestname){
    return htmlspecialchars(strip_tags($_POST[$requestname]));
} 

define ('APP_ROOT', realpath(dirname(__FILE__)));
function imageUpload($imageRequest){

    global $msgError;
    if($_FILES[$imageRequest]){
        $imageName = $_FILES[$imageRequest]['name'];
        $imageTmp = $_FILES[$imageRequest]['tmp_name'];
        $imageSize = $_FILES[$imageRequest]['size'];
        $allowedExt = array("jpg","png","jpeg");
    
        $strToArray = explode(".",$imageName);
        $ext = end($strToArray);
        $ext = strtolower($ext);
    
        if(!empty($imageName) && !in_array($ext, $allowedExt)){
            $msgError = "Ext";
        }
    
        if(empty($msgError)){
            $imagePath = APP_ROOT."/upload/" . $imageName;
            move_uploaded_file($imageTmp,$imagePath);
            return $imagePath;
        }else{
            print_r("there is error in the" , $msgError);
        }
    }else{
        return null;
    }
}

