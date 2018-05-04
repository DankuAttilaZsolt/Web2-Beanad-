<?php
    try
    {
      // Kapcsolódás  az adatbázishoz, karakterkészlet beállítása
      $conn = new PDO(DB_SYSTEM.":host=".DB_HOST.";dbname=".DB_NAME, USER_NAME, PASSWORD,
                    array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
      $conn->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
    }
    catch(PDOException $e)
    {
        die("Sajnos, nem lehet kapcsolódni az adatbázishoz. Próbálj újra később.");
    }
?>