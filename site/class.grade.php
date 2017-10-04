<!-- Lop nay chua ham cap nhat diem !-->

<?php
class grade {
  //Ham tinh diem tong cua sinh vien
  public function total_grade($diem_gk,$diem_ck,$diem_th,$diem_c) {
    $diem_tong = $diem_gk + $diem_ck + $diem_th + $diem_c;
    return $diem_tong;
  }
  //Ham doi diem 10 sang 4
  public function chage_grade_10_4($diem) {
    if(10>=$diem && $diem>=9) {
      return 4;
    }
    else if (9>$diem && $diem>=8){
      return 3.5;
    }
    else if (8>$diem && $diem>=7){
      return 3;
    }
    else if (7>$diem && $diem>=6){
      return 2.5;
    }
    else if (6>$diem && $diem>=5){
      return 2;
    }
    else if (5>$diem && $diem>=4.5){
      return 1.5;
    }
    else if (4.5>$diem && $diem>=4){
      return 1;
    }
    else {
      return 0;
    }
  }

  //Ham cap nhat diem cho sinh vien , thuoc mot nhom hoc phan nao do
  public function update_grade($con,$ma_sv,$ma_nhom,$ma_hp,$ma_hk,$ma_nh,
          $diem_gk,$diem_ck,$diem_th,$diem_c) {
     $diem = $this->total_grade($diem_gk,$diem_ck,$diem_th,$diem_c);
     $diem_4 = $this->chage_grade_10_4($diem);
     $sql = "UPDATE sinhvien_hp SET Diem = $diem, Diem_GK = $diem_gk, Diem_CK = $diem_ck,
             Diem_TH = $diem_th, Diem_C = $diem_c, Diem_4 = $diem_4
             WHERE Ma_SV = '$ma_sv' AND Ma_Nhom = '$ma_nhom' AND Ma_HP = '$ma_hp'
             AND Ma_HK = '$ma_hk' AND Ma_NH = '$ma_nh'";
    return $sql;
  }


  //Hàm lấy bảng điểm cúa sinh viên học kì nào đó
  public function get_all_grade($ma_sv,$ma_hk,$ma_nh) {
    $sql = "SELECT * FROM sinhvien_hp AS sv_hp , hocphan AS hp
            WHERE sv_hp.Ma_SV = '$ma_sv' AND sv_hp.Ma_HK = '$ma_hk' AND sv_hp.Ma_NH = '$ma_nh'
            AND sv_hp.Ma_HP = hp.Ma_HP";
    return $sql;
  }

  //Hàm tính điểm trung bình học kì của sinh viên nào đó
  public function average_grade($ma_sv,$ma_hk,$ma_nh) {
    $sql = "SELECT SUM(sv_hp.Diem_4*hp.So_TC)/SUM(hp.So_TC) FROM sinhvien_hp as sv_hp , hocphan AS hp
            WHERE sv_hp.Ma_HP = hp.Ma_HP AND sv_hp.Ma_HK = '$ma_hk'
            AND sv_hp.Ma_NH = '$ma_nh' AND Ma_SV = '$ma_sv'";
    return $sql;
  }

  //Hàm tính điểm trung bình tích lũy của sinh viên nào đó, và luôn tính tới thòi điểm học
  public function average_grade_all($ma_sv,$ma_hk,$ma_nh) {
    //Cắt lấy phàn tử cuối của học kì
    $hk = substr($ma_hk,strlen($ma_hk)-1,1);
    $sql = "SELECT SUM(b1.diem * hp.So_TC)/SUM(hp.So_TC)
            FROM hocphan AS hp,
                (
                  SELECT Ma_SV , Ma_HP, Ma_NH, Ma_HK, MAX(Diem_4) AS diem
                  FROM sinhvien_hp
                  WHERE Ma_SV = '$ma_sv'
                  GROUP BY Ma_SV, Ma_HP, Ma_NH, Ma_HK ) as b1
            WHERE b1.Ma_HP = hp.Ma_HP AND b1.Ma_NH <= $ma_nh AND RIGHT(b1.Ma_HK,1) <= $hk";
    return $sql;
  }

  //Hàm đổi thang điểm 10 sang chữ
  public function change_grade_number_text($diem_so10) {
    switch(true) {
      case (10>=$diem_so10 && $diem_so10>=9):
        return 'A';
        break;
      case (9>$diem_so10 && $diem_so10>=8):
        return 'B+';
        break;
      case (8>$diem_so10 && $diem_so10>=7):
        return 'B';
        break;
      case (7>$diem_so10 && $diem_so10>=6):
        return 'C+';
        break;
      case (6>$diem_so10 && $diem_so10>=5):
        return 'C';
        break;
      case (5>$diem_so10 && $diem_so10>=5.5):
        return 'D+';
        break;
      case (5.5>$diem_so10 && $diem_so10>=4):
        return 'D';
        break;
      default:
        return 'F';
        break;
    }
  }
  //Hàm cập nhật điểm trung bình học kì mỗi sinh sinh
  public function update_grade_term($con,$ma_sv,$ma_hk,$ma_nh) {
    $sql = "UPDATE diem
            SET diem.DiemTBHK = b1.diem_tbhk
            FROM (
                SELECT b.Ma_SV, b.Ma_HK, b.Ma_NH,sum(b.max*hp.So_TC)/sum(hp.So_TC) as diem_tbhk
                FROM hocphan AS hp ,
                    (
                    SELECT Ma_SV , Ma_HK, Ma_NH, Ma_HP, MAX(Diem_4) as max
                    FROM sinhvien_hp
                    GROUP BY Ma_SV , Ma_HK, Ma_NH, Ma_HP
                    ) as b
                WHERE b.Ma_HP = hp.Ma_HP
                AND b.Ma_HK = '$ma_hk' AND b.Ma_NH = '$ma_nh' AND b.Ma_SV = '$ma_sv'
                GROUP By b.Ma_SV,b.Ma_HK, b.Ma_NH
              ) as b1
            WHERE b1.Ma_SV = diem.Ma_SV AND b1.Ma_HK = diem.Ma_HK AND b1.Ma_NH = diem.Ma_NH
              ";
    return $sql;
  }
}
 ?>
