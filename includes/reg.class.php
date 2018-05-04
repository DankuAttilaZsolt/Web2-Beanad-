<?php

  if(isset($_POST['regisztracio']))
  {
    try
    {
      // Kapcsolódás
      $dbh = new PDO('mysql:host=localhost;dbname=web2', 'root', '',
                    array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
      $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci'); 
      
        // Felesleges szóközök eldobása
        $_POST['fh_fnev'] = trim($_POST['fh_fnev']);
        $_POST['fh_jelszo'] = trim($_POST['fh_jelszo']);
        $_POST['fh_tnev'] = trim($_POST['fh_tnev']);
        $_POST['fh_email'] = trim($_POST['fh_email']);
        /*$_POST['fh_aktiv'] = '1';
        $_POST['fh_szint']= '2'; */
        $_POST['fh_lastlogin'] = '2018-02-23 19:58:27';
        
        // Ha nem kaptunk meg minden adatot
        if($_POST['fh_fnev'] == "" || $_POST['fh_jelszo'] == "" || $_POST['fh_tnev'] == "" || $_POST['fh_email'] == "")
        {
          $regisztracio_hiba = "A megadott adatok hiányosak!";  
        }
        // Ha megkaptunk minden adatot hozzuk létre a felhasználót a táblában
        else
        {
          $sql = "insert into motor_felhasznalok values (0, :fh_fnev, sha1(:fh_jelszo), :fh_tnev, :fh_email, 1, 2, :fh_lastlogin )";
          $sth = $dbh->prepare($sql);
          if($sth->execute(Array(':fh_fnev' => $_POST['fh_fnev'], ':fh_jelszo' => $_POST['fh_jelszo'],
                              ':fh_tnev' => $_POST['fh_tnev'], ':fh_email' => $_POST['fh_email'], ':fh_lastlogin' => $_POST['fh_lastlogin'])))
          {
            // Sikerült a létrehozás (insert)
            $regisztracio_eredmeny = true;
          }
          else
          {
            // Nem sikerült a létrehozás
            $regisztracio_eredmeny = false;
          }
        }
      }
    
    catch (PDOException $e)
    {
      echo "Hiba: ".$e->getMessage();
    }
  }

?>

