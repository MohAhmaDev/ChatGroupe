<?php

session_start();

include_once "server/php/config.php";
if (!isset($_SESSION['unique_id'])) 
{
    header("location: index.html");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style-home.css">
</head>
<body>
  <div class="action">
    <div class="profil" onclick="menuToggle()">
        <img src="images/logo1.png" id="myimg">
    </div>
    <div class="menu">
        <h3 id="profil-user"> Anonymous </h3>
        <ul>
        <li> 
            <i class="fas fa-cog"></i> <a href="profil.php"> My profil </a> </li>
            <li> <i class="fas fa-cog"></i> <a href="home.html"> Anonymmes chat </a> </li>
            <li> <i class="fas fa-cog"></i> <a href="users.php"> chat with somme one </a> </li>
            <!--<li> <i class="fas fa-cog"></i> <a href=""> Settings </a> </li>
            <li> <i class="fas fa-cog"></i> <a href=""> Help </a> </li>-->
            <li> <i class="fas fa-cog"></i> <a href="server/php/logout.php" id="deconnection"> Logout </a> </li>			
          </ul>
    </div>
  </div>  
    <div class="back-home">
        <div class="contain-content-inform">
            <div class="inform-part1"> 

            </div>
            <?php 
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
                if(mysqli_num_rows($sql) > 0){
                    $row = mysqli_fetch_assoc($sql);
                }
            ?>
            <div class="inform-part2">
                <div class="new-card">
                    <div class="content">
                            <h3>Pseudo: <?php echo $row['fname']. " " . $row['lname'] ?></h3>
                            <h3>mail : <?php echo $row['email']?> </h3>
                            <h3>status <?= $row["status"] ?> </h3>

                            <br>
                            <b>  Information : </b> ce chat est un forum de discussion en ligne entre des étulisateurs masqueé.
                
                    </div>
                
                    <img src="images/anonym.png" id="img">
                </div>
            </div>
        </div>
    </div>


    <script>

        function menuToggle(argument) 
        {
            const toggleMenu = document.querySelector('.menu');
            toggleMenu.classList.toggle('active');
        }
    
    </script>
</body>
</html>