<?php

session_start();



// $CONCT = "check";


if (array_key_exists("check", $_GET)) {

    $check = $_GET['check'];
    if($check == "do") {
        doConnction();
    }
}
else {
    doCheckConnction();
}

// if($check == "do"){
//     doConnction();
// } else {
//     doCheckConnction();
// }



function doCheckConnction()
{

    if (isset($_GET['mail'], $_GET['mdp'])) {

    
        $mail = htmlspecialchars($_GET['mail']) ;
        $options = ['cost' => 14];
        $mdp = $_GET['mdp'];

        if (!empty($_GET['mail']) && !empty($_GET['mdp'])) {
    
            require 'base.php';
            $Test_Login = $db->prepare('SELECT * FROM user_chat WHERE mail_user = ?');
            $Test_Login->execute(array($mail)) ;
            $test = $Test_Login->fetch(); 
            $conteur = $Test_Login->rowCount() ;
      

            
    
            if ($conteur != 0 && password_verify($mdp, $test['mdp_user'])) {
                $_SESSION["check"] = true;
                $result = "<span style='color:#18aaff'>  admis  </span>";
                echo ($result);    
            }
            else
            {
                $result = "<span style='color:red'> non admis </span>";
                echo ($result);  
            }
    
        }
        else
        {
            $result = "<span style='color:red'> non admis </span>"; 
            echo ($result);  
        }
    }
}


function doConnction()
{
    if (isset($_POST['mail'], $_POST['mdp'])) {
        if (!empty($_POST['mail']) && !empty($_POST['mdp'])) {
           $mail = $_POST['mail'];
           $mdp = $_POST['mdp'];
           if (isset($_SESSION['check']) && !empty($_SESSION['check']) && $_SESSION['check']) 
           {
                require 'base.php';
                $get_id = $db->prepare('SELECT * FROM users WHERE email = ?');
                $get_id->execute(array($mail)) ;
                $row = $get_id->fetch();
                $Connteur = $get_id->rowCount();
                if ($Connteur != 0 && password_verify($mdp, $row['password'])) {
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo("profil.php");
                }
            
           }
        }
    }
}


