<?php
//Belépés
  if (!isset($user)) {
    header("location: ../index.php");
  }
?>
      <div class="post">
        <h2 class="title">Bejelentkezés</h2>     
        <div style="clear: both;">&nbsp;</div>
        <div class="entry belepes">
          <form action="." method="post">
            <label><input type="text" id="fnev" name="fnev" /> Felhasználói név: </label><br clear="all" /><br>
            <label><input type="password" name="pw" /> Jelszó: </label><br clear="all" /><br>
            <input type="submit" value="Bejelentkezés" /><br clear="all" />
          </form>
        </div>
      </div>
                  
      <script type="text/javascript">
        $("#fnev").focus();
      </script>
