<?php
  if (!isset($user)) {
    header("location: ../index.php");
  }
  /* kilépés */
  $user->Kilepes();
  unset($_GET["q"]);
  $jogmaszk = $user->GetJogmaszk();
  $page = new Page($jogmaszk);
  $pid  = $page->GetPid();
?>