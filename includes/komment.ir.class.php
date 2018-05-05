<?php

  if(isset($_POST['komment']))
  {
    try
    {
      // Kapcsolódás
      $dbh = new PDO('mysql:host=localhost;dbname=web2', 'root', '',
                    array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
      $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci'); 
      
        // Felesleges szóközök eldobása
        $_POST['mh_hozzaszolas'] = trim($_POST['mh_hozzaszolas']);
        $t=time();      
         $_POST['mh_date'] = date("Y-m-d H:i:s",$t);        
         if($_POST['mh_fnev']==""){
          $_POST['mh_fnev']='Anonymus';
         } else{
        $_POST['mh_fnev'] = trim($_POST['mh_fnev']);
         }
       /* $sql  = "select fh_fnev
            from ".MOTOR_FELHASZNALOK."
            where fh_fnev = :mh_fnev;
          "; */
        // Ha nem kaptunk meg minden adatot
        if($_POST['mh_hozzaszolas'] == "" )
        {
          $komment_hiba = "Nincs komment!";  
        }
        // Ha megkaptunk minden adatot hozzuk létre a felhasználót a táblában
        else
        {
          $sql = "insert into motor_hozzaszolas values (1, :mh_fnev, :mh_hozzaszolas, :mh_date)";
          $sth = $dbh->prepare($sql);
          if($sth->execute(Array(':mh_fnev' => $_POST['mh_fnev'], ':mh_hozzaszolas' => $_POST['mh_hozzaszolas'],':mh_date' => $_POST['mh_date'])))
          {
            // Sikerült a létrehozás (insert)
            $komment_eredmeny = true;
          }
          else
          {
            // Nem sikerült a létrehozás
            $komment_eredmeny = false;
          }
        }
      }
    
    catch (PDOException $e)
    {
      echo "Hiba: ".$e->getMessage();
    }
  }

?>

