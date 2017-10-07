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
    $sql = "SELECT SUM(b1.diem*hp.So_TC)/SuM(hp.So_TC)
            FROM (
                  SELECT DISTINCT b.Ma_SV, b.Ma_HP, sv_hp.Ma_HK, sv_hp.Ma_NH , b.diem
	                FROM(
                    	SELECT Ma_SV , Ma_HP , MAX(Diem_4) AS diem
                    	FROM sinhvien_hp
                    	WHERE Ma_SV = 'B1401051'
                    	GROUP BY Ma_SV, Ma_HP) as b
	                    , sinhvien_hp AS sv_hp
	                WHERE b.Ma_SV = sv_hp.Ma_SV AND b.Ma_HP = sv_hp.Ma_HP AND b.diem = sv_hp.Diem_4
                  ) as b1 , hocphan AS hp
             WHERE b1.Ma_HP = hp.Ma_HP AND b1.Ma_HK <= '$ma_hk' AND b1.Ma_NH <= '$ma_nh'";
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
  /*Hàm cập nhật điểm trung bình tich lũy tới học kì hiện tại
    +Lấy điểm lớn nhất của tất cả các môn không trùng nhau (trường hợp học lại môn)
    +Tính điểm TBTL tới hk hiện tại = TBTL(học kì hiện năm hiện tại vs năm trước đó)
  */
  public function update_grade_tbtl($ma_sv,$ma_hk,$ma_nh) {
    $sql = "UPDATE diem
            INNER JOIN
            (
              SELECT b.Ma_SV,sum(b.max*hp.So_TC)/sum(hp.So_TC) as diem_tbtl, sum(hp.So_TC) as tong_tctl
              FROM hocphan AS hp ,
                (
                SELECT Ma_SV , Ma_HK, Ma_NH, Ma_HP, MAX(Diem_4) as max
                FROM sinhvien_hp
                GROUP BY Ma_SV , Ma_HK, Ma_NH, Ma_HP
                HAVING max >= 1
                ) as b
              WHERE (b.Ma_HP = hp.Ma_HP AND b.Ma_HK <= '$ma_hk' AND b.Ma_NH = '$ma_nh' AND b.Ma_SV = '$ma_sv')
                  OR (b.Ma_HP = hp.Ma_HP AND b.Ma_NH < '$ma_nh' AND b.Ma_SV = '$ma_sv')
              GROUP By b.Ma_SV
            ) as b1
            ON b1.Ma_SV = diem.Ma_SV
            SET diem.DiemTBTL = b1.diem_tbtl , diem.Tong_TCTL = b1.tong_tctl
            WHERE diem.Ma_HK = '$ma_hk' AND diem.Ma_NH = '$ma_nh'";
    return $sql;
  }

  /*Ham tinh diem trung binh học kì
    +Tính điểm trung bình học kì của mỗi học kì mỗi năm học
  */
  public function update_grade_tbhk($ma_sv,$ma_hk,$ma_nh) {
    $sql = "UPDATE diem
            INNER JOIN
              (
                SELECT sv_hp.Ma_SV, sv_hp.Ma_HK, sv_hp.Ma_NH,sum(sv_hp.Diem_4*hp.So_TC)/sum(hp.So_TC) as diem_tbhk,
                       sum(hp.So_TC) as tong_tctlhk
                FROM hocphan AS hp , sinhvien_hp AS sv_hp
                WHERE sv_hp.Ma_HP = hp.Ma_HP
                AND sv_hp.Ma_HK = '$ma_hk' AND sv_hp.Ma_NH = '$ma_nh' AND sv_hp.Ma_SV = '$ma_sv'
                GROUP BY sv_hp.Ma_SV, sv_hp.Ma_HK, sv_hp.Ma_NH
              ) as b1
            ON b1.Ma_SV = diem.Ma_SV AND b1.Ma_HK = diem.Ma_HK AND b1.Ma_NH = diem.Ma_NH
            SET diem.DiemTBHK = b1.diem_tbhk , diem.Tong_TCTLHK = b1.tong_tctlhk
            ";
    return $sql;
  }
}
 ?>
