<?php

if(isset($_GET["action"])) {
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $database = new PDO('mysql:host=localhost;dbname=web2;charset=utf8', 'root', '', $pdo_options);
    
    if($_GET["action"] == 'kommentek') {
        $req = $database->prepare("SELECT * FROM motor_hozzaszolas");
        $req->execute();
        echo json_encode(array('kommentek' => $req->fetchAll()));
    }
    /*else if($_GET["action"] == 'regenyek') {
        $req;
        if($_GET["foszereplo"] == 0) {
            $req = $database->prepare("SELECT *, (SELECT SUM(darab) FROM rendelesek WHERE regenyid = regenyek.id) as darab FROM regenyek");
            $req->execute();
        } else {
            $req = $database->prepare("SELECT *, (SELECT SUM(darab) FROM rendelesek WHERE regenyid = regenyek.id) as darab FROM regenyek WHERE foszereploid = :id");
            $req->execute(array('id' => $_GET["foszereplo"]));
        }
        echo json_encode(array('regenyek' => $req->fetchAll()));
    } else if($_GET["action"] == 'cim') {
        if($_POST["cim"] != '') {
            $req = $database->prepare("SELECT *, (SELECT SUM(darab) FROM rendelesek WHERE regenyid = regenyek.id) as darab FROM regenyek WHERE magyar LIKE :cim OR angol LIKE :cim");
            $req->execute(array('cim' => '%' . $_POST["cim"] . '%'));
            echo json_encode(array('regenyek' => $req->fetchAll()));
        } else {
            echo json_encode(array('regenyek' => ''));
        }
    } */
}
