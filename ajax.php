<?php

if(isset($_GET["action"])) {
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $database = new PDO('mysql:host=localhost;dbname=web2;charset=utf8', 'root', '', $pdo_options);
    
    if($_GET["action"] == 'kommentek') {
        $req = $database->prepare("SELECT * FROM motor_hozzaszolas");
        $req->execute();
        echo json_encode(array('kommentek' => $req->fetchAll()));
    }
      if($_GET["action"] == 'felhasznalok') {
        $req = $database->prepare("SELECT * FROM motor_felhasznalok");
        $req->execute();
        echo json_encode(array('felhasznalok' => $req->fetchAll()));
    }    
}
