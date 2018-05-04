<?php

  /*
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";
  */
  
  // Kaptuk adatokat?
  if(isset($_POST['belepes']) || isset($_POST['regisztracio']))
  {
    try
    {
      // Kapcsolódás
      $dbh = new PDO('mysql:host=localhost;dbname=web2', 'root', '',
                    array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
      $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
      
      // Belépés esetén
      if(isset($_POST['belepes'])) {
        // Felesleges szóközök eldobása
        $_POST['login'] = trim($_POST['login']);
        $_POST['jelszo'] = trim($_POST['jelszo']);
        
        // Kérdezzük le a bejelentkezett felhasználó családi nevét és utónevet
        $sql = "select csaladi_nev, utonev from felhasznalok where bejelentkezes = :login and jelszo = sha1(:jelszo);";
        $sth = $dbh->prepare($sql);
        $sth->execute(Array(':login' => $_POST['login'], ':jelszo' => $_POST['jelszo']));
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        switch(count($rows))
        {
          // Ha nem kaptunk vissza sort
          case 0: $belepes_hiba = "Hibás login név - jelszó pár!"; break;
          // Ha egyetlen egy sort kaptunk vissza
          case 1: $csaladinev = $rows[0]['csaladi_nev']; $utonev = $rows[0]['utonev']; break;
          // Ha több sort kaptunk vissza
          default: $belepes_hiba = "Több felhsználó rendelkezik a megadott login név - jelszó párral!";
        }
      }
      // Regisztráció esetén
      else
      {
        // Felesleges szóközök eldobása
        $_POST['csaladi_nev'] = trim($_POST['csaladi_nev']);
        $_POST['utonev'] = trim($_POST['utonev']);
        $_POST['login_nev'] = trim($_POST['login_nev']);
        $_POST['jelszo_reg'] = trim($_POST['jelszo_reg']);
        
        // Ha nem kaptunk meg minden adatot
        if($_POST['csaladi_nev'] == "" || $_POST['utonev'] == "" || $_POST['login_nev'] == "" || $_POST['jelszo_reg'] == "")
        {
          $regisztracio_hiba = "A megadott adatok hiányosak!";  
        }
        // Ha megkaptunk minden adatot hozzuk létre a felhasználót a táblában
        else
        {
          $sql = "insert into felhasznalok values (0, :csaladi_nev, :utonev, :login, sha1(:jelszo))";
          $sth = $dbh->prepare($sql);
          if($sth->execute(Array(':csaladi_nev' => $_POST['csaladi_nev'], ':utonev' => $_POST['utonev'],
                              ':login' => $_POST['login_nev'], ':jelszo' => $_POST['jelszo_reg'])))
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
    }
    catch (PDOException $e)
    {
      echo "Hiba: ".$e->getMessage();
    }
  }

?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
  <style>
    h1 {
      margin: 0px 10px;
    }
    .left {
      float: left;
      border: 1px solid black;
      padding: 10px;
      margin: 10px;
    }
    #bottom {
      clear: both;
      margin: 10px;
    }
    #eredmeny {
      margin: 10px;
      padding: 5px;
      background-color: #0000FF;
      color: #FFFFFF;
    }
    form {
      text-align: right;
    }
    input {
      margin: 2px;
      padding: 5px;
      width: 150px;
    }
    .uzenet {
      padding-top: 5px;
      color: red;
    }
  </style>
  <title>PHP - MYSQL</title>
  </head>
  <body>
  <?php
  if(isset($csaladinev) && isset($utonev) || isset($regisztracio_eredmeny))
  {
    echo "<div id=\"eredmeny\">";
    if(isset($csaladinev) && isset($utonev))
    {
      echo "Bejelentkezett a felhasználó: ".$csaladinev." ".$utonev." (".$_POST['login'].")";
    }
    if(isset($regisztracio_eredmeny) && $regisztracio_eredmeny)
    {
      echo "Sikeresen regisztrált felhasználó: ".$_POST['csaladi_nev']." ".$_POST['utonev']." (".$_POST['login_nev'].")";
    }
    elseif(isset($regisztracio_eredmeny) && ! $regisztracio_eredmeny)
    {
      echo "Nem sikerült regisztrálni a felhasználót: ".$_POST['csaladi_nev']." ".$_POST['utonev']." (".$_POST['login_nev'].")";
    }
    echo "</div>";
  }
  ?>
  <h1>Belépés vagy regisztráció</h1>
  <div>
    <div class="left">
      <form name="belepes" action="kesz_2.php" method="post">
      <label for="login">Login:<input type = "text" name="login" id = "login"></label><br> 
      <label for="jelszo">Jelszó: <input type = "password" name="jelszo" id = "jelszo"></label><br> 
      <input type="submit" name="belepes" value="Belépés"><br>
      </form>
      <?php if(isset($belepes_hiba) && strlen(trim($belepes_hiba)) > 0) echo "<div class=\"uzenet\">".$belepes_hiba."</div>"; ?>
    </div>
    <div class="left">
      <form name="regisztracio" action="kesz_2.php" method="post">
      <label for="csaladi_nev">Családi név: <input type = "text" name="csaladi_nev" id = "csaladi_nev"></label><br>
      <label for="utonev">Utónév: <input type = "text" name="utonev" id = "utonev"></label><br>
      <label for="login_nev">Login: <input type = "text" name="login_nev" id = "login_nev"></label><br>
      <label for="jelszo_reg">Jelszó: <input type = "password" name="jelszo_reg" id = "jelszo_reg"></label><br> 
      <input type="submit" name="regisztracio" value="Regisztráció"><br>
      </form>
      <?php if(isset($regisztracio_hiba) && strlen(trim($regisztracio_hiba)) > 0) echo "<div class=\"uzenet\">".$regisztracio_hiba."</div>"; ?>
    </div>
  </div>
  <div id="bottom">
  &copy 2015 WEB-programozás II - 2. gyakorlat
  </div>
  </body>
</html>
