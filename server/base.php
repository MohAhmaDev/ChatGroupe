<?php


try {
    $db = new PDO('mysql:host=localhost;dbname=project_ssad;charset=utf8', 'root', '');
} catch (PDOException $e) {
	die("Erreur :".$e->getMessage()) ;
}

