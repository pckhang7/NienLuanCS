<?php
  /*Lop nhom hoc phan*/
  class subject {
    //Hàm trả lại tất cả truy vấn các nhóm học
    public function get_all() {
      $sql = "SELECT *
              FROM giangvien_hp AS gv_hp, hocphan AS hp, hocki AS hk , namhoc AS nh
              WHERE gv_hp.Ma_HK = hk.Ma_HK AND gv_hp.Ma_NH = nh.Ma_NH AND
              gv_hp.Ma_HP = hp.Ma_HP";
      return $sql;
    }

    //Hàm trả lại tất cả truy vấn các nhóm học phần hiện có trong học kì năm học nào đó
    public function get_all_subject($hk,$nh) {
      $sql = "SELECT *
              FROM giangvien_hp AS gv_hp, hocphan AS hp, hocki AS hk , namhoc AS nh
              WHERE gv_hp.Ma_HK = hk.Ma_HK AND gv_hp.Ma_NH = nh.Ma_NH AND
              gv_hp.Ma_HP = hp.Ma_HP AND
              gv_hp.Ma_HK = '$hk' AND gv_hp.Ma_NH = '$nh'";
      return $sql;
    }

    /*Hàm xóa một nhóm học phần, Nếu thực hiện xoá nhóm học phần đông nghĩa:
      +Xóa nhóm học phần giảng dạy của giảng viên
      +Có thể xóa nhóm học phần được học của sinh viên(nếu có)
    */
    public function delete_subject($con,$id) {
      $sql = "SELECT * FROM giangvien_hp as gv_hp , sinhvien_hp as sv_hp
              WHERE gv_hp.Id = $id AND gv_hp.Ma_Nhom = sv_hp.Ma_Nhom
              AND gv_hp.Ma_HP = sv_hp.Ma_HP AND gv_hp.Ma_HK = sv_hp.Ma_HK
              AND gv_hp.Ma_NH = sv_hp.Ma_NH";
      //Nếu học phần đó có sinh viên học, thì xóa nhóm học phần của GV lẫn SV
      $result = mysqli_query($con,$sql);
      $count = mysqli_num_rows($result);
      if ($count > 0) {
        $sql = "DELETE gv_hp , sv_hp FROM giangvien_hp as gv_hp , sinhvien_hp as sv_hp
                WHERE gv_hp.Id = $id AND gv_hp.Ma_Nhom = sv_hp.Ma_Nhom
                AND gv_hp.Ma_HP = sv_hp.Ma_HP AND gv_hp.Ma_HK = sv_hp.Ma_HK
                AND gv_hp.Ma_NH = sv_hp.Ma_NH";
        return $sql;
      }
      //Ngược lại thì xóa nhóm học phần của giảng viên
      else {
        $sql = "DELETE gv_hp FROM giangvien_hp as gv_hp
                WHERE gv_hp.Id = $id";
        return $sql;
      }
    }

    //hàm insert vào nhóm học phần 
    public function insert_group_subject($con,$ma_nhom,$ma_hp,$ma_hk,$ma_nh) {
      $sql = "INSERT INTO nhom_hp (Ma_Nhom,Ma_HP,Ma_HK,Ma_NH)
              VALUES ('$ma_nhom','$ma_hp','$ma_hk','$ma_nh')";
      return $sql;
    }

    //Hàm insert vào bảng giảng viên_học phần
    public function insert_subject_teacher($con,$ma_nhom,$ma_hp,$ma_hk,$ma_nh,$ma_gv) {
      $sql = "INSERT INTO giangvien_hp (Ma_Nhom,Ma_HP,Ma_HK,Ma_NH,Ma_GV)
              VALUES ('$ma_nhom','$ma_hp','$ma_hk','$ma_nh','$ma_gv')";
      return $sql;
    }
    /*Hàm kiểm tra xem nhóm học phần đã tồn tại hay chưa
      +TRUE : đã tồn tại 
      +FALSE : chưa tồn tại
    */
    public function check_group_subject($con,$ma_nhom, $ma_hp, $ma_hk, $ma_nh) {
      $sql = "SELECT * FROM nhom_hp 
              WHERE Ma_Nhom = '$ma_nhom' AND Ma_HP = '$ma_hp' 
                    AND Ma_HK = '$ma_hk' AND Ma_NH = '$ma_nh'
        ";
      $result = mysqli_query($con,$sql);
      $count = mysqli_num_rows($result);
      if ($count == 1) {
        return TRUE;
      }
      else {
        return FALSE;
      }
    }

    


    /*Hàm kiểm tra xem mã học phần đã tồn tại trong bảng học phần hay không
      +TRUE : là tồn tại
      +FALSE : không tồn tại
    */

    public function check_subject($con,$ma_hp) {
      $sql = "SELECT * FROM hocphan WHERE Ma_HP = '$ma_hp'";
      $result = mysqli_query($con,$sql);
      $count = mysqli_num_rows($result);
      if ($count > 0) {
        return TRUE;
      } 
      else {
        return FALSE;
      }
    }
  }
 ?>
