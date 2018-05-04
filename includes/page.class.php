<?php
  class Page {
    private $pageid;
    private $pagetitle;
    private $pagejogok;
    
    public function __construct($jogok) {
	  global $conn;
      $this->pageid    = 1;
      $this->pagetitle = "Nyitólap";
      $this->pagejogok = $jogok;
      $q = isset($_GET['q']) ? $_GET['q'] : "nyitolap";
      $menudarabok = explode("/", $q);
      $felettes = 0; $hiba = false;
      $akt_datum = date('Y-m-d H:i:s');
      foreach ($menudarabok as $darab) {
        $sql = "
				  select *
					from ".MOTOR_OLDALAK."
					where mo_felettes=$felettes
						  and mo_alias='$darab'
						  and mo_aktiv=1
						  and mo_pubdate<'$akt_datum'
						  and mo_unpubdate>'$akt_datum'
						  and mo_jogok like '$jogok'";
        $oldalak = $conn->query($sql);
        if ($oldalak->rowCount() == 0) {
          $hiba = true;
        } else {
		  $oldal     = $oldalak->fetch(PDO::FETCH_ASSOC);
          $akt_oldal = $oldal["mo_id"];
          $akt_cim   = $oldal["mo_cim"];
          $felettes  = $akt_oldal;
        }
      }
      if (!$hiba and !file_exists("content/".$akt_oldal.".php")) {
        $hiba = true;
      }
      if ($hiba) {
        $this->pageid = 404;
        $this->pagetitle = "Hiba!";
      } else {
        $this->pageid = $akt_oldal;
        $this->pagetitle = $akt_cim;
      }
    }
    
    public function GetPid() {
      return $this->pageid;
    }
    
    public function GetPageTitle() {
      if ($this->pagetitle == "")
        return "";
      else
        return $this->pagetitle." | ";
    }
    
    private function MenuRekurziv($felettes, $elotag, $melyseg) {
	  global $conn;
      $akt_datum = date('Y-m-d H:i:s');
      $sql = "
			  select * from ".MOTOR_OLDALAK."
				where mo_cim<>''
					  and mo_felettes=$felettes
					  and mo_aktiv=1
					  and mo_pubdate<'$akt_datum'
					  and mo_unpubdate>'$akt_datum'
					  and mo_jogok like '".$this->pagejogok."'
				order by mo_sorrend;
			";
      $oldalak = $conn->query($sql); 
      if ($oldalak->rowCount() != 0) {
        $ki = '<ul class="menu'.$melyseg;
        if ($melyseg == 1)
          $ki .= ' sf-menu';
        $ki .= '">';
        while ($oldal = $oldalak->fetch(PDO::FETCH_ASSOC)) {
          if ($melyseg == 1)
            $link = $oldal["mo_alias"];
          else
            $link = $elotag.'/'.$oldal["mo_alias"];
          $ki .= '<li class="menuitem"><a href="?q='.$link.'">'.$oldal["mo_cim"].'</a>';
          $ki .= $this->MenuRekurziv($oldal["mo_id"], $link, $melyseg + 1);
          $ki .= '</li>';
        }
        $ki .= '</ul>';
        return $ki;
      } else {
        return "";
      }
    }
    
    public function GetPageMenu() {
     return $this->MenuRekurziv(0, "", 1);
    }
    
    private function LinkKeszit($oldalID) {
			global $conn;
      $sql = "
			  select *
				from ".MOTOR_OLDALAK."
				where mo_id=$oldalID
			";
      $oldalak  = $conn->query($sql);
	  $oldal    = $oldalak->fetch(PDO::FETCH_ASSOC);
      $kiir     = $oldal["mo_alias"];
      $felettes = $oldal["mo_felettes"];
      $cim      = $oldal["mo_cim"];
      $hiba = false;
      while ($felettes != 0 and !$hiba) {
        $akt_datum = date('Y-m-d H:i:s');
        $sql = "
				  select *
					from ".MOTOR_OLDALAK."
					where mo_id=$felettes
						  and mo_aktiv=1
						  and mo_cim<>''
						  and mo_jogok like '".$this->pagejogok."'
						  and mo_pubdate<'$akt_datum'
						  and mo_unpubdate>'$akt_datum';
				";
        $oldalak2 = $conn->query($sql);
        if ($oldalak2->rowCount() == 0) {
          $hiba = true;
        } else {
		  $oldal2   = $oldalak2->fetch(PDO::FETCH_ASSOC);
          $kiir     = $oldal2["mo_alias"]."/".$kiir;
          $felettes = $oldal2["mo_felettes"];
        }
      }
      if ($hiba) {
        return "";
      } else {
        $kiir = "<li><a href=\"?q=$kiir\">$cim</a></li>";
        return $kiir;
      }
    }
    
    public function GetSidebarMenu() {
			global $conn;
      $sql = "
			  select *
				from ".MOTOR_BLOKKOK."
				where mb_jogok like '".$this->pagejogok."'
				order by mb_sorrend;
			";
      $blokkok = $conn->query($sql);
      $kiir = "";
      $akt_datum = date('Y-m-d H:i:s');
      while ($blokk = $blokkok->fetch(PDO::FETCH_ASSOC)) {
        //egy blokk elkészítése
        $mb_id = $blokk["mb_id"];
        $sql2 = "
				  select *
					from ".MOTOR_OLDALAK."
					where mo_fk_blokkid=$mb_id
						  and mo_aktiv=1
						  and mo_cim<>''
						  and mo_jogok like '".$this->pagejogok."'
						  and mo_pubdate<'$akt_datum'
						  and mo_unpubdate>'$akt_datum'
					order by mo_bsorrend;
				";
        $oldalak = $conn->query($sql2);
        if ($oldalak->rowCount() != 0) {
          $ki2 = "";
          while ($oldal = $oldalak->fetch(PDO::FETCH_ASSOC)) {
            $ki2 .= $this->LinkKeszit($oldal["mo_id"]);
          }
          if ($ki2 != "") {
            $ki2 = "<h2>".$blokk["mb_cim"]."</h2><ul>".$ki2."</ul>";
            $kiir .= "<li>".$ki2."</li>";
          }
        }
      }
      return $kiir;
    }
  }
?>