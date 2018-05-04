<?php
  session_start();
  include_once("includes/initial.php");
  $user     = new User();
  $jogmaszk = $user->GetJogmaszk();
  $page     = new Page($jogmaszk);
  $pid      = $page->GetPid();
  if (file_exists("content/".$pid."_pre.php"))
    include_once("content/".$pid."_pre.php");
  include("page.tpl.php");
?>