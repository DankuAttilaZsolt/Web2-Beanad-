<?php
  class User {
    private $userid;
    private $jogmaszk;
    
    public function __construct() {
      //konstruktor
      global $conn;
      $this->userid = 0;
      $this->jogmaszk = "1__";
      if (isset($_SESSION["userid"]) and isset($_SESSION["jogmaszk"])){
        //belépett felhasználó
        $this->userid   = $_SESSION["userid"];
        $this->jogmaszk = $_SESSION["jogmaszk"];
      } else {
        if (isset($_POST["fnev"]) and isset($_POST["pw"])){
          //ellenőrzés az adatbázisban
          $fnev = $_POST["fnev"];
          $pw   = $_POST["pw"];
          $sql  = "
            select fh_id, fh_szint
            from ".MOTOR_FELHASZNALOK."
            where fh_fnev = :fnev
                  and fh_jelszo = sha1(:pw);
          "; 
          $stmt = $conn->prepare($sql);
          $stmt->execute(Array(':fnev' => $fnev, ':pw' => $pw));
          if ($stmt->rowCount() != 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->userid = $row['fh_id'];
            if ($row['fh_szint'] == 2) $this->jogmaszk = "_1_";
            if ($row['fh_szint'] == 3) $this->jogmaszk = "__1";
            $_SESSION["userid"]   = $this->userid;
            $_SESSION["jogmaszk"] = $this->jogmaszk;
          }
        } 
      }
    }
    
    public function Belepve() {
      if ($this->userid == 0)
        return false;
      else
        return true;
    }
    
    public function GetUserid () {
      return $this->userid;
    }
    
    public function GetJogmaszk() {
      return $this->jogmaszk;
    }
    
    public function GetTeljesnev() {
      if ($this->userid != 0) {
        $sql = "
          select *
          from ".MOTOR_FELHASZNALOK."
          where fh_id=".$this->userid;
        $userek = $conn->query($sql);
        $user   = $userek->fetch_array(MYSQLI_ASSOC);
        $tnev   = $user["fh_tnev"];
      }
      else
        $tnev = "";
      return $tnev;
    }
    
    public function Kilepes() {
      unset($_SESSION["userid"]);
      unset($_SESSION["jogmaszk"]);
      $this->userid = 0;
      $this->jogmaszk = "1__";
    }
  }   
  
  
?>