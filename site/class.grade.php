<!-- Lop nay chua ham cap nhat diem !-->

<?php
class grade {
  //Ham tinh diem tong cua sinh vien
  public function total_grade($diem_gk,$diem_ck,$diem_th,$diem_c) {
    $diem_tong = $diem_gk + $diem_ck + $diem_th + $diem_c;
    return $diem_tong;
  }

  //Ham cap nhat diem cho sinh vien , thuoc mot nhom hoc phan nao do
  public function update_grade($con,$ma_sv,$ma_nhom,$ma_hp,$ma_hk,$ma_nh,
          $diem_gk,$diem_ck,$diem_th,$diem_c) {
     $diem = $this->total_grade($diem_gk,$diem_ck,$diem_th,$diem_c);
     $sql = "UPDATE sinhvien_hp SET Diem = $diem, Diem_GK = $diem_gk, Diem_CK = $diem_ck,
             Diem_TH = $diem_th, Diem_C = $diem_c
             WHERE Ma_SV = '$ma_sv' AND Ma_Nhom = '$ma_nhom' AND Ma_HP = '$ma_hp'
             AND Ma_HK = '$ma_hk' AND Ma_NH = '$ma_nh'";
    return $sql;
  }


}
 ?>
