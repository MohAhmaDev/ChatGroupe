<?php 
    session_start();
    if(isset($_SESSION['unique_id']))
    {
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = $_POST['incoming_id'];
        $message = $_POST['message'];
        
        if(!empty($message))
        {
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES (SHA1({$incoming_id}), SHA1({$outgoing_id}), '{$message}')") or die();
        }
    }

    else
    {
        header("location: ../../index.html");
    }


    
?>