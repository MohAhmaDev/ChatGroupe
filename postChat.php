<?php 
  session_start();
  include_once "server/php/config.php";
  if(!isset($_SESSION['unique_id']))
  {
    header("location: index.html");
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
<div class="action">
        <div class="profil" onclick="menuToggle()">
            <img src="images/logo1.png" id="myimg">
        </div>
        <div class="menu">
            <h3 id="profil-user"> Anonymous </h3>
            <ul>
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
      <section class="chat-area">
        <header>
          <?php 
            $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }else{
              header("location: users.php");
            }
          ?>
          <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
          <img src="server/php/images/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </header>
        <div class="chat-box">

        </div>
        <form action="#" class="typing-area">
          <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
          <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
          <button><i class="fab fa-telegram-plane"></i></button>
        </form>
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
    const form = document.querySelector(".typing-area"),
    incoming_id = form.querySelector(".incoming_id").value,
    inputField = form.querySelector(".input-field"),
    sendBtn = form.querySelector("button"),
    chatBox = document.querySelector(".chat-box");

    form.onsubmit = (e)=>{
        e.preventDefault();
    }

    inputField.focus();
    inputField.onkeyup = ()=>{
        if(inputField.value != ""){
            sendBtn.classList.add("active");
        }else{
            sendBtn.classList.remove("active");
        }
    }

    sendBtn.onclick = ()=>{
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/php/insertData.php", true);
        xhr.onload = ()=>{
          if(xhr.readyState === XMLHttpRequest.DONE){
              if(xhr.status === 200){
                  inputField.value = "";
                  scrollToBottom();
              }
          }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    }
    chatBox.onmouseenter = ()=>{
        chatBox.classList.add("active");
    }

    chatBox.onmouseleave = ()=>{
        chatBox.classList.remove("active");
    }

    setInterval(() =>{
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/php/getData.php", true);
        xhr.onload = ()=>{
          if(xhr.readyState === XMLHttpRequest.DONE){
              if(xhr.status === 200){
                let data = xhr.response;
                chatBox.innerHTML = data;
                if(!chatBox.classList.contains("active")){
                    scrollToBottom();
                  }
              }
          }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("incoming_id="+incoming_id);
    }, 500);

    function scrollToBottom(){
        chatBox.scrollTop = chatBox.scrollHeight;
    }
  </script>

</body>
</html>
