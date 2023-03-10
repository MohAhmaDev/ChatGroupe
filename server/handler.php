<?php

$db = new PDO('mysql:host=localhost;dbname=project_ssad;charset=utf8', 'root', '');


$task = "list";

if(array_key_exists("task", $_GET)){
  $task = $_GET['task'];
}

if($task == "write"){
  postMessage();
} else {
  getMessages();
}


function getMessages(){
  global $db;

  $resultats = $db->query("SELECT * FROM chat_messages ORDER BY created_at DESC LIMIT 20");
  $messages = $resultats->fetchAll();
  echo json_encode($messages);
}


function postMessage(){
  global $db;
  
  if(!array_key_exists('author', $_POST) || !array_key_exists('content', $_POST)){

    echo json_encode(["status" => "error", "message" => "One field or many have not been sent"]);
    return;

  }

  $author = $_POST['author'];
  $content = $_POST['content'];
  $bool = false;

  if (isset($author,$content)) 
  {
    if (!empty($author) && !empty($content)) 
    {
      $query = $db->prepare('INSERT INTO chat_messages SET author = :author, content = :content, created_at = NOW()');
      $query->execute(["author" => $author,"content" => $content]);
    }
    else
    {
      
      echo "<br><div class=\"alert alert-danger alert-dismissible fade show\" style='transition:0.5s' role=\"alert\">
        desolé mon pote mais tous les champs doivent etre completer  
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\" style=\"outline:none;\">
        <span aria-hidden=\"true\">&times;</span>
      </button>
      </div>";  
    }
  }
  // 3. Donner un statut de succes ou d'erreur au format JSON
  //echo json_encode(["status" => "success"]);

  // if ($bool) {
  //   $query = $db->prepare('INSERT INTO messages SET author = :author, content = :content, created_at = NOW()');

  //   $query->execute([
  //     "author" => $author,
  //     "content" => $content
  //   ]);


  //   echo json_encode(["status" => "success"]);
  // }
  // else
  // {
  //   echo "<br><div class=\"alert alert-danger alert-dismissible fade show\" style='transition:0.5s' role=\"alert\">
  //   Désolé message non registrer  <strong> veillez vous inscrir avant <a href=\"#\">ici<a> </strong> 
  //   <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\" style=\"outline:none;\">
  //     <span aria-hidden=\"true\">&times;</span>
  //   </button>
  //   </div>";   
  // }

}

