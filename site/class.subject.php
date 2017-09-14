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
  }
 ?>
