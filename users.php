<?php 
  session_start();
  
  include_once "server/php/config.php";
  if(!isset($_SESSION['unique_id']))
  {
    header("location: index.html");
  }
  else
  {
    $status = "Active now";
    $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$_SESSION['unique_id']}");
  }
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Realtime Chat App | CodingNepal</title>
  <link rel="stylesheet" href="css/style-chat.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body>
<?php 
  $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
  if(mysqli_num_rows($sql) > 0){
    $row = mysqli_fetch_assoc($sql);
  }
?>
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
  <div class="container-chat">
    <div class="wrapper">
      <section class="users">
        <header>
          <div class="content">

            <img src="server/php/images/<?php echo $row['img']; ?>" alt="">
            <div class="details">
              <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
              <p><?php echo $row['status']; ?></p>
            </div>
          </div>
          <!--<a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>-->
        </header>
        <div class="search">
          <span class="text">Select an user to start chat </span>
          <input type="text" placeholder="Enter name to search...">
          <button><i class="fas fa-search"></i></button>
        </div>
        <div class="users-list">
    
        </div>
      </section>
    </div>
  </div>

  <script>
        function menuToggle(argument) 
        {
            const toggleMenu = document.querySelector('.menu');
            toggleMenu.classList.toggle('active');
        }
  </script>
  <script>
    const searchBar = document.querySelector(".search input"),
    searchIcon = document.querySelector(".search button"),
    usersList = document.querySelector(".users-list");

    searchIcon.onclick = ()=>{
      searchBar.classList.toggle("show");
      searchIcon.classList.toggle("active");
      searchBar.focus();
      if(searchBar.classList.contains("active")){
        searchBar.value = "";
        searchBar.classList.remove("active");
      }
    }

    searchBar.onkeyup = ()=>{
      let searchTerm = searchBar.value;
      if(searchTerm != ""){
        searchBar.classList.add("active");
      }else{
        searchBar.classList.remove("active");
      }
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "server/php/search.php", true);
      xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
              let data = xhr.response;
              usersList.innerHTML = data;
            }
        }
      }
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("searchTerm=" + searchTerm);
    }

    setInterval(() =>{
      let xhr = new XMLHttpRequest();
      xhr.open("GET", "server/php/users.php", true);
      xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
              let data = xhr.response;
              if(!searchBar.classList.contains("active")){
                usersList.innerHTML = data;
              }
            }
        }
      }
      xhr.send();
    }, 500);

  </script>

</body>
</html>
