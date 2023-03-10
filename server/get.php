<?php  
    function getIPAddress() {  
        //whether ip is from the share internet  
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
            $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
        //whether ip is from the proxy  
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
        }  
        //whether ip is from the remote address  
        else{  
            $ip = $_SERVER['REMOTE_ADDR'];  
        } 

        return $ip;  
    }  
     
    if (array_key_exists("ip", $_GET)) 
    {
        require "base.php";
        $ip = getIPAddress(); 
        $request = $db->prepare("INSERT INTO ip_adress SET adress = :adress");
        if($request->execute(["adress" => $ip]))
        {
            echo 'User Real IP Address - '.$ip;  
        }
        else
        {
            echo "BIG PROBLEMME :(";
        }

    }
    else
    {
        echo "PROBLEMME :(";
    }

?>  
