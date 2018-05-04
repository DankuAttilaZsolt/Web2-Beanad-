          
<?php    
  // Kaptuk adatokat?
  if(isset($_POST['regisztracio']))
  {
    try
    {
      // Kapcsolódás
      $dbh = new PDO('mysql:host=localhost;dbname=web2', 'root', '',
                    array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
      $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');      
      // Belépés esetén
      if(isset($_POST['registracio'])) { //////////////
        // Felesleges szóközök eldobása
        $_POST['fnev'] = trim($_POST['fnev']);
        $_POST['jelszo'] = trim($_POST['jelszo']);
        $_POST['tnev'] = trim($_POST['tnev']);
        $_POST['email'] = trim($_POST['email']);
        
        // Ha nem kaptunk meg minden adatot
        if($_POST['fnev'] == "" || $_POST['jelszo'] == "" || $_POST['tnev'] == "" || $_POST['email'] == "")
        {
          $regisztracio_hiba = "A megadott adatok hiányosak!";  
        }
        // Ha megkaptunk minden adatot hozzuk létre a felhasználót a táblában
        else
        {
          $sql = "insert into felhasznalok values (0, :fnev, sha1(:jelszo)), :tnev, :email";
          $sth = $dbh->prepare($sql);
          if($sth->execute(Array(':fnev' => $_POST['fnev'], ':tnev' => $_POST['tnev'],
                              ':email' => $_POST['email'], ':jelszo' => $_POST['jelszo_reg'])))
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
  </head>
  <body>
  <?php
  if(isset($fnev) && isset($tnev) || isset($regisztracio_eredmeny))
  {
    echo "<div id=\"eredmeny\">";
    if(isset($fnev) && isset($tnev))
    {
      echo "Bejelentkezett a felhasználó: ".$tnev." ".$fnev." (".$_POST['login'].")";
    }
    if(isset($regisztracio_eredmeny) && $regisztracio_eredmeny)
    {
      echo "Sikeresen regisztrált felhasználó: ".$_POST['tnev']."  ".$_POST['fnev']." (".$_POST['login_nev'].")";
    }
    elseif(isset($regisztracio_eredmeny) && ! $regisztracio_eredmeny)
    {
      echo "Nem sikerült regisztrálni a felhasználót: ".$_POST['fnev']." ".$_POST['tnev']." (".$_POST['login_nev'].")";
    }
    echo "</div>";
  }
  ?>
 <div class="post">
        <h2 class="title">Regisztráció</h2>
        <div style="clear: both;">&nbsp;</div>
        <div class="entry belepes">
          <form action="." method="post">      
            <label><input type="text" id="fnev" name="fnev" /> Felhasználói név: </label><br clear="all" /><br>
            <label><input type="password" name="pw" /> Jelszó: </label><br clear="all" /><br>
            <label><input type="text" id="tnev" name="tnev" /> Teljes név: </label><br clear="all" /><br>
            <label><input type="email" id="email" name="email" /> Email cím: </label><br clear="all" /><br>            
            <input type="submit" value="Regisztráció" /><br clear="all" />
      </form>
      <?php if(isset($regisztracio_hiba) && strlen(trim($regisztracio_hiba)) > 0) echo "<div class=\"uzenet\">".$regisztracio_hiba."</div>"; ?>
    </div>
  </div>
 <script type="text/javascript">
        $("#fnev").focus();
      </script>
  </body>
</html>

      