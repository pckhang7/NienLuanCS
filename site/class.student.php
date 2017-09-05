<?php
class student {
  private $Ma_SV;
  private $Ho;
  private $Ten;
  private $Dia_Chi;
  private $Email;
  private $Sdt;
  private $Ma_Nganh;


  public function __construct($Ma_SV,$Ho,$Ten,$Dia_Chi,$Email,$Sdt,$Ma_Nganh) {
    $this->Ma_SV = $Ma_SV;
    $this->Ho = $Ho;
    $this->Ten = $Ten;
    $this->Dia_Chi = $Dia_Chi;
    $this->Email = $Email;
    $this->Sdt = $Sdt;
    $this->Ma_Nganh = $Ma_Nganh;
  }
  public function getMaSV() {
    return $this->Ma_SV;
  }
  public function getHo() {
    return $this->Ho;
  }
  public function getTen() {
    return $this->Ten;
  }

  
}



 ?>
