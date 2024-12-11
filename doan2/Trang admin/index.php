<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

ob_start();
session_start();
if (isset($_SESSION['user1'])) {

    include "./model/pdo.php";
    include "./model/loai_phim.php";
    include "./model/phim.php";
    include "./model/taikhoan.php";
    include "./model/lichchieu.php";
    include "./model/phong.php";
    include "./model/thongke.php";
    include "./model/ve.php";
    include "./model/khunggio.php";
    include "./model/binhluan.php";
    include "./model/rap.php";
    include "./model/lichlamviec.php";
    include "./model/khuyenmai.php";
    include "model/chamcong.php";
    $loadphim = loadall_phim();
    $loadloai = loadall_loaiphim();
    $loadtk = loadall_taikhoan();
    $loadrap = loadall_rap();
    $loadlichlamviec = loadall_lichlamviec();
    $loadkhuyenmai = loadall_khuyenmai();
    $loadbangchamcong = getBangChamCong(date('m'), date('Y'));


    include "./view/home/header.php";

    if (isset($_GET['act']) && ($_GET['act'] != "")) {
        $act = $_GET['act'];
        switch ($act) {
            case "QLloaiphim":
                include "./view/loaiphim/QLloaiphim.php";
                break;
            case "themloai":
                if (isset($_POST['gui'])) {

                    if (!isset($_POST['name']) || empty($_POST['name'])) {
                        $error = "Tên thể loại không được để trống";
                    }

                    if (!isset($error)) {
                        $name = $_POST['name'];
                        them_loaiphim($name);
                        $suatc = "THÊM THÀNH CÔNG";
                    }
                }

                include "./view/loaiphim/them.php";
                break;
            case "sualoai":
                if (isset($_GET['idsua'])) {
                    $loadone_loai = loadone_loaiphim($_GET['idsua']);
                }
                include "./view/loaiphim/sua.php";
                break;
            case "xoaloai":
                if (isset($_GET['idxoa'])) {
                    xoa_loaiphim($_GET['idxoa']);
                    $loadloai = loadall_loaiphim();
                    include "./view/loaiphim/QLloaiphim.php";
                } else {
                    include "./view/loaiphim/QLloaiphim.php";
                }
                break;
            case "updateloai":

                if (isset($_POST['capnhat'])) {
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    if ($name == '') {
                        $error = "Vui lòng điền đầy đủ thông tin";
                        $loadone_loai = loadone_loaiphim($id);
                        include "./view/loaiphim/sua.php";
                        break;
                    } else {
                        update_loaiphim($id, $name);
                        $suatc = "SỬA THÀNH CÔNG";
                    }
                }
                $loadloai = loadall_loaiphim();

                include "./view/loaiphim/QLloaiphim.php";
                break;
            case "QLphim":
                if (isset($_POST['tk1']) && ($_POST['tk1'])) {
                    $searchName1 = $_POST['ten'];
                    $searchLoai = $_POST['loai'];
                } else {
                    $searchName1 = "";
                    $searchLoai = "";
                }
                $loadphim = loadall_phim($searchName1, $searchLoai);
                include "./view/phim/QLphim.php";
                break;
            case "themphim":
                if (isset($_POST['gui'])) {
                    $tieu_de = $_POST['tieu_de'];
                    $gia_ve = $_POST['gia_ve'];  // Đm bảo biến này được lấy từ form
                    $daodien = $_POST['daodien'];
                    $dienvien = $_POST['dienvien'];
                    $quoc_gia = $_POST['quoc_gia'];
                    $gia_han_tuoi = $_POST['gia_han_tuoi'];
                    $thoiluong = $_POST['thoiluong'];
                    $date = $_POST['date'];
                    $id_loai = $_POST['id_loai'];
                    $mo_ta = $_POST['mo_ta'];
                    $link = $_POST['link'];

                    // Xử lý upload ảnh
                    if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                        $img = $_FILES['anh']['name'];
                        $target_dir = "../Trang người dùng/imgavt/";
                        move_uploaded_file($_FILES["anh"]["tmp_name"], $target_dir . $img);
                    } else {
                        $img = '';
                    }

                    // Kiểm tra dữ liệu
                    if (
                        $tieu_de == '' || $gia_ve == '' || $daodien == '' || $dienvien == '' ||
                        $quoc_gia == '' || $gia_han_tuoi == '' || $img == '' || $mo_ta == '' ||
                        $thoiluong == '' || $date == '' || $id_loai == ''
                    ) {
                        $error = "Vui lòng không để trống";

                        // Gọi hàm thêm phim với đúng thứ tự tham số
                        include "./view/phim/them.php";
                        break;
                    } else {
                        them_phim($tieu_de, $gia_ve, $daodien, $dienvien, $img, $mo_ta, $thoiluong, $quoc_gia, $gia_han_tuoi, $date, $id_loai, $link);
                        $suatc = "Thêm thành công";
                    }
                }

                $loadphim = loadall_phim();
                include "./view/phim/them.php";
                break;





            case "updatephim":
                if (isset($_POST['capnhat'])) {
                    $id = $_POST['id'];
                    $tieu_de = $_POST['tieu_de'];
                    $gia_ve = $_POST['gia_ve'];
                    $daodien = $_POST['daodien'];
                    $dienvien = $_POST['dienvien'];
                    $quoc_gia = $_POST['quoc_gia'];
                    $gia_han_tuoi = $_POST['gia_han_tuoi'];
                    $thoi_luong = $_POST['thoiluong'];
                    $date = $_POST['date'];
                    $id_loai = $_POST['id_loai'];
                    $mo_ta = $_POST['mo_ta'];

                    // Xử lý ảnh
                    $img = $_FILES['anh']['name'];
                    $target_dir = "../Trang người dùng/imgavt/";
                    $target_file = $target_dir . basename($_FILES['anh']['name']);

                    if (move_uploaded_file($_FILES['anh']['tmp_name'], $target_file)) {
                        echo "Bạn đã upload ảnh thành công";
                    } else {
                        echo "Upload ảnh không thành công";
                    }

                    // Kiểm tra dữ liệu
                    if ($tieu_de == '' || $gia_ve == '' || $daodien == '' || $dienvien == '' || $quoc_gia == '' || $gia_han_tuoi == ''  || $mo_ta == '' || $thoi_luong == '' || $date == '' || $id_loai == '') {
                        $error = "Vui lòng không để trống";

                        $loadone_phim = loadone_phim($id);

                        include "./view/phim/sua.php";
                        break;
                    } else {
                        sua_phim($id, $tieu_de, $gia_ve, $img, $mo_ta, $thoi_luong, $date, $id_loai);
                        $suatc = "Cập nhật thành công";
                    }
                }

                $loadphim = loadall_phim();
                include "./view/phim/QLphim.php";
                break;


            case "sualichchieu":
                if (isset($_GET['idsua'])) {
                    $loadone_lc = loadone_lichchieu($_GET['idsua']);
                }
                include "./view/suatchieu/sua.php";
                break;

            case "themlichchieu":
                $loadphim = loadall_phim();
                $loadrap = loadall_rap();

                if (isset($_POST['them'])) {
                    $id_phim = $_POST['id_phim'];
                    $rap_id = $_POST['id_rap'];
                    $ngay_chieu_arr = $_POST['ngay_chieu'];

                    $success = true;
                    $error_messages = array();

                    // Kiểm tra từng ngày chiếu
                    foreach ($ngay_chieu_arr as $ngay_chieu) {
                        $result = them_lichchieu($id_phim, $rap_id, $ngay_chieu);
                        if (!$result['status']) {
                            $success = false;
                            $error_messages[] = $result['message'];
                        }
                    }

                    if ($success) {
                        $error = array(
                            'status' => true,
                            'message' => 'Thêm tất cả lịch chiếu thành công!'
                        );
                        echo "<script>
                            setTimeout(function() {
                                window.location.href='index.php?act=QLlichchieu';
                            }, 1500);
                        </script>";
                    } else {
                        $error = array(
                            'status' => false,
                            'message' => implode('<br>', $error_messages)
                        );
                    }
                }

                include "./view/suatchieu/them.php";
                break;



            case "xoaphim":
                if (isset($_GET['idxoa'])) {
                    xoa_phim($_GET['idxoa']);
                    $loadphim = loadall_phim();
                    include "./view/phim/QLphim.php";
                }
                break;
            case "suaphim":
                if (isset($_GET['idsua'])) {
                    $loadone_phim = loadone_phim($_GET['idsua']);
                }
                include "./view/phim/sua.php";
                break;
            case "updatelichchieu":
                $loadphim = loadall_phim();
                $loadphong = load_phong();
                if (isset($_POST['capnhat'])) {

                    $id = $_POST['id'];
                    $id_phim = $_POST['id_phim'];
                    $ngay_chieu = $_POST['nc'];
                    $rap_id = $_POST['id_rap'];
                    if ($id == '' || $id_phim == '' || $ngay_chieu == '' || $rap_id == '') {
                        $error = "vui lòng không để trống";
                        $loadone_lc = loadone_lichchieu($id);
                        include "./view/suatchieu/sua.php";
                        break;
                    } else {
                        sua_lichchieu($id, $id_phim, $rap_id, $ngay_chieu);
                        $suatc = "SỬA THÀNH CÔNG";
                    }
                }
                $loadlich = loadall_lichchieu();
                include "./view/suatchieu/QLlichchieu.php";
                break;

            case 'QLlichchieu':
                $loadrap = loadall_rap();

                // Load lịch chiếu theo rạp được chọn
                if (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 1) {
                    $rap_id = $_SESSION['user1']['rap_id'];
                    $loadlich = loadall_lichchieu($rap_id);
                } else {
                    $loadlich = loadall_lichchieu();
                }

                include "./view/suatchieu/QLlichchieu.php";
                break;



            case "QLcarou":
                include "./view/phim/sua.php";
                break;

            case "khachhang":

                include "./view/user/khachhang.php";
                break;
                // Các case xem doanh thu
            case "DTphim":
                $loadrap = loadall_rap();
                $rap_id = isset($_GET['rap_id']) ? $_GET['rap_id'] : null;

                // Xử lý phân trang
                $page = isset($_GET['trang']) ? $_GET['trang'] : 1;
                $limit = 5; // Số bản ghi trên mỗi trang
                $offset = ($page - 1) * $limit;

                // Load dữ liệu thng kê
                $dtt = load_thongke_doanhthu1($rap_id, $limit, $offset);  // Dữ liệu có phân trang
                $dtt1 = load_thongke_doanhthu($rap_id);  // Tổng dữ liệu để tính số trang

                include "./view/danhthu/DTphim.php";
                break;

            case "DTngay":
                $loadrap = loadall_rap();
                $rap_id = isset($_GET['rap_id']) ? $_GET['rap_id'] : null;
                $dtt = load_doanhthu_ngay1($rap_id);
                $dtt1 = load_doanhthu_ngay($rap_id);
                include "./view/danhthu/DTngay.php";
                break;

            case "DTtuan":
                $loadrap = loadall_rap();
                $rap_id = isset($_GET['rap_id']) ? $_GET['rap_id'] : null;
                $dtt = load_doanhthu_tuan1($rap_id);
                $dtt1 = load_doanhthu_tuan($rap_id);
                include "./view/danhthu/DTtuan.php";
                break;

            case "DTthang":
                $loadrap = loadall_rap();
                $rap_id = isset($_GET['rap_id']) ? $_GET['rap_id'] : null;
                $dtt = load_doanhthu_thang1($rap_id);
                $dtt1 = load_doanhthu_thang($rap_id);
                include "./view/danhthu/DTthang.php";
                break;

            case 'DTrap':
                // Load dữ liệu rạp
                $loadrap = loadall_rap();

                // Lấy rap_id từ GET nếu có
                $rap_id = isset($_GET['rap_id']) ? $_GET['rap_id'] : null;

                // Load dữ liệu thống kê
                $dtt = load_doanhthu_rap($rap_id);  // Dữ liệu có phân trang
                $dtt1 = load_doanhthu_rap($rap_id); // Tổng dữ liệu để tính số trang

                // Include view
                include "./view/danhthu/DTrap.php";
                break;
            case "timeline":
                include "./view/voucher/timeline.php";
                break;
            case "chitiethoadon":
                include "./view/vephim/chitiethoadon.php";
                break;



            case "QLfeed":
                $listbl =  loadall_bl();
                $tong = count($listbl);
                $loadtk = loadall_taikhoan();
                $loadloai = loadall_loaiphim();

                $loadphim = load_all_phim();

                // Xử lý phân trang
                $page = isset($_GET['sotrang']) ? $_GET['sotrang'] : 1;
                $items_per_page = 5;

                // Lọc theo phim nếu có
                $id_phim = isset($_GET['id_phim']) ? $_GET['id_phim'] : 0;

                // Load bình luận và tổng số bình luận
                $listbl = loadall_binhluan($id_phim, $page, $items_per_page);
                $tong = count_binhluan($id_phim);
                $sotrang = ceil($tong / $items_per_page);

                include "./view/feedblack/QLfeed.php";
                break;
                include "./view/feedblack/QLfeed.php";
                break;



            case "xoabl":
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    delete_binhluan($id);
                }
                $listbl =  loadall_bl();
                include "./view/feedblack/QLfeed.php";
                break;



            case 'thoigian':
                $loadrap = loadall_rap();

                // Load suất chiếu theo rạp v phòng được chọn
                if (isset($_GET['id_phong']) && $_GET['id_phong'] > 0) {
                    // Nếu có chọn phòng cụ thể
                    $id_phong = $_GET['id_phong'];
                    $loadkgc = loadall_khunggiochieu_by_phong($id_phong);
                } else if (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 1) {
                    $rap_id = $_SESSION['user1']['rap_id'];
                    $loadkgc = loadall_khunggiochieu($rap_id);
                } else {
                    // Load tất cả
                    $loadkgc = loadall_khunggiochieu(0);
                }

                include "./view/suatchieu/thoigian/thoigian.php";
                break;



            case "ve":
                if (isset($_POST['tk'])) {
                    $ten = isset($_POST['ten']) ? $_POST['ten'] : "";
                    $tieude = isset($_POST['tieude']) ? $_POST['tieude'] : "";
                    $id_ve = isset($_POST['id_ve']) ? $_POST['id_ve'] : "";
                    $loadvephim = loadall_vephim($ten, $tieude, $id_ve);
                } else {
                    $loadvephim = loadall_vephim();  // Sa từ loadall_vephim1 thành loadall_vephim
                }
                include "./view/vephim/ve.php";
                break;
            case "suavephim":
                if (isset($_GET['idsua'])) {
                    $loadve = loadone_vephim($_GET['idsua']);
                }
                include "./view/vephim/sua.php";
                break;


            case "updatevephim":
                if (isset($_POST['capnhat'])) {
                    $id = $_POST['id'];
                    $trang_thai = $_POST['trang_thai'];
                    if (update_vephim($id, $trang_thai)) {
                        $thongbao = "Cập nhật trạng thái vé thành công!";
                    } else {
                        $error = "Cập nhật trạng thái vé thất bại!";
                    }
                }

                // Xử lý tìm kiếm
                $searchName = isset($_POST['ten']) ? $_POST['ten'] : "";
                $searchTieuDe = isset($_POST['tieude']) ? $_POST['tieude'] : "";
                $searchid = isset($_POST['id_ve']) ? $_POST['id_ve'] : "";

                $loadvephim = loadall_vephim1($searchName, $searchTieuDe, $searchid);
                include "view/vephim/ve.php";
                break;



            case 'phong':
                $loadrap = loadall_rap();
                // Lọc phòng theo rạp nếu có
                if (isset($_GET['rap_id']) && $_GET['rap_id'] > 0) {
                    $rap_id = $_GET['rap_id'];
                    $loadphong = load_phong_by_rap($rap_id);
                } elseif (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 3) {
                    $rap_id = $_SESSION['user1']['rap_id'];
                    $loadphong = load_phong_by_rap($rap_id);
                } else {
                    $loadphong = load_phong();
                }

                include "./view/phong/phong.php";
                break;



            case "xoaphong":
                if (isset($_GET['idxoa'])) {
                    xoa_phong($_GET['idxoa']);
                    $loadphong = load_phong();
                    include "./view/phong/phong.php";
                }
                break;
            case "suaphong":
                if (isset($_GET['ids'])) {
                    $loadphong1 = loadone_phong($_GET['ids']);
                }
                include "./view/phong/sua.php";
                break;

            case "updatephong":

                $loadphong = load_phong();
                if (isset($_POST['capnhat'])) {
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $rap_id = $_POST['rap_id'];
                    $so_hang = $_POST['so_hang'];
                    $so_cot = $_POST['so_cot'];
                    if ($id == '' || $name == '' || $rap_id == '' || $so_hang == '' || $so_cot == '') {
                        $error = "vui lòng không để trống";
                        $loadphong1 = load_phong($id);
                        include "./view/phong/sua.php";
                        break;
                    } else {
                        update_phong($id, $name, $rap_id, $so_hang, $so_cot);
                        $suatc = "sửa thành công";
                    }
                }
                $loadphong = load_phong();
                include "./view/phong/phong.php";
                break;
            case 'themphong':
                if (isset($_POST['len'])) {
                    $name = $_POST['name'];
                    $rap_id = $_POST['rap_id'];
                    $so_hang = $_POST['so_hang'];
                    $so_cot = $_POST['so_cot'];

                    // Validate dữ liệu
                    if (empty($name) || empty($rap_id) || empty($so_hang) || empty($so_cot)) {
                        $error = "Vui lòng điền đầy đủ thông tin!";
                    } else {
                        try {
                            // Thêm phòng mà không tạo ghế
                            them_phong($name, $rap_id, $so_hang, $so_cot);

                            // Thông báo thành công
                            $suatc = "Thêm phòng thành công!";
                        } catch (Exception $e) {
                            $error = "Lỗi: " . $e->getMessage();
                        }
                    }
                }
                $sql_rap = "SELECT id, tenrap FROM rap";
                $rap_list = pdo_query($sql_rap);
                include "view/phong/them.php";
                break;

            case "updatethoigian":
                $loadlc = loadall_lichchieu();
                $loadphong = load_phong();
                if (isset($_POST['capnhat'])) {
                    $id = $_POST['id'];
                    $id_lc = $_POST['id_lc'];
                    $id_phong = $_POST['id_phong'];
                    $thoi_gian_chieu = $_POST['tgc'];
                    sua_kgc($id, $id_lc, $id_phong, $thoi_gian_chieu);
                }
                $loadkgc = loadall_khunggiochieu();
                include "./view/suatchieu/thoigian/thoigian.php";
                break;


            case 'themthoigian':
                $loadrap = loadall_rap();
                $loadlc = loadall_lichchieu();
                $error = "";

                if (isset($_POST['them'])) {
                    $id_lc = $_POST['id_lc'];
                    $id_phong = $_POST['id_phong'];
                    $tgc_array = $_POST['tgc'];

                    if (empty($id_lc)) {
                        $error .= "Vui lòng chọn lịch chiếu<br>";
                    }
                    if (empty($id_phong)) {
                        $error .= "Vui lòng chọn phòng chiếu<br>";
                    }
                    if (empty($tgc_array)) {
                        $error .= "Vui lòng chọn ít nhất một giờ chiếu<br>";
                    }

                    // Lấy thông tin lịch chiếu và các suất chiếu hiện có
                    if (!empty($id_lc) && !empty($id_phong)) {
                        $lich_chieu = get_lich_chieu($id_lc);
                        $existing_times = get_suatchieu_trong_ngay($id_phong, $lich_chieu['ngay_chieu']);

                        foreach ($tgc_array as $tgc) {
                            if (empty($tgc)) continue;
                            $new_time = strtotime($tgc);

                            foreach ($existing_times as $existing) {
                                $existing_time = strtotime($existing['thoi_gian_chieu']);
                                $time_diff = abs($new_time - $existing_time) / 3600;

                                if ($time_diff < 3) {
                                    $error .= "Suất chiếu " . date('H:i', $new_time) .
                                        " không hợp lệ - phải cách suất " . date('H:i', $existing_time) .
                                        " ít nhất 3 tiếng<br>";
                                    break;
                                }
                            }
                        }
                    }

                    if (empty($error)) {
                        // Thêm suất chiếu và tạo ghế
                        them_kgc($id_lc, $id_phong, $tgc_array);

                        $_SESSION['success'] = "Thêm suất chiếu và ghế thành công";
                        header("Location: index.php?act=thoigian");
                        exit();
                    }
                }

                include "./view/suatchieu/thoigian/them.php";
                break;







                // Thêm case này sau case "themthoigian"
            case "thoigian":
                $loadkgc = loadall_khunggiochieu();
                include "./view/suatchieu/thoigian/thoigian.php";
                break;

                $loadkgc = loadall_khunggiochieu();
                include "./view/suatchieu/thoigian/them.php";
                break;
            case "suathoigian":
                $loadlich = loadall_lichchieu();
                $loadphong = load_phong();
                if (isset($_GET['ids'])) {
                    $load1kgc = loadone_khung_gio_chieu($_GET['ids']);
                }
                include "./view/suatchieu/thoigian/sua.php";
                break;
            case "xoathoigian":
                if (isset($_GET['idxoa']) && ($_GET['idxoa'] > 0)) {
                    xoa_kgc($_GET['idxoa']);
                }
                $loadkgc = loadall_khunggiochieu();
                include "./view/suatchieu/thoigian/thoigian.php";
                break;
            case "xoalichchieu":
                if (isset($_GET['idxoa']) && ($_GET['idxoa'] > 0)) {
                    xoa_lc($_GET['idxoa']);
                }
                $loadlich = loadall_lichchieu();
                include "./view/suatchieu/QLlichchieu.php";
                break;


            case "QTkh":
                $loadall_kh1 = loadall_taikhoan();
                include "./view/user/khachhang.php";
                break;

            case 'QTvien':
                $loadrap = load_all_rap(); // Load danh sách rạp
                if (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 3) {
                    $rap_id = $_SESSION['user1']['rap_id'];
                    $listtaikhoan = loadall_taikhoan_nv($rap_id); // Load nhân viên theo rạp
                } else {
                    $listtaikhoan = loadall_taikhoan_nv(); // Load nhân viên theo rạp
                }
                include "./view/user/QTvien.php";
                break;

            case "suatk":
                if (isset($_GET['idsua'])) {
                    $loadtk = loadone_taikhoan($_GET['idsua']);
                }
                include "./view/user/sua.php";
                break;
            case "themuser":
                if (isset($_POST['them'])) {
                    if (empty($_POST['name'])) {
                        $error = " không được để trống";
                    }
                    if (empty($_POST['user'])) {
                        $error = " không được để trống";
                    }
                    if (empty($_POST['email'])) {
                        $error = " không được để trống";
                    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        $error = "Email không đúng định dạng";
                    }
                    if (empty($_POST['phone'])) {
                        $error = " không được để trống";
                    }
                    if (empty($_POST['dia_chi'])) {
                        $error = " không được để trống";
                    }
                    if (!isset($error)) {
                        $name = $_POST['name'];
                        $user = $_POST['user'];
                        $email = $_POST['email'];
                        $phone = $_POST['phone'];
                        $dia_chi = $_POST['dia_chi'];
                        insert_taikhoan($email, $user, $pass, $name, $phone, $dia_chi);
                        $suatc = "Thêm thành công";
                    }
                }
                $loadall_kh = loadall_taikhoan();
                include "./view/user/them.php";
                break;

            case "updateuser":
                if (isset($_POST['capnhat'])) {
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $user = $_POST['user'];
                    $pass = $_POST['pass'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];
                    $dia_chi = $_POST['dia_chi'];
                    if ($id == '' || $name == '' || $email == '' || $pass == '' || $user == '' || $phone == '' || $dia_chi == '') {
                        $error = "vui lòng không để trống";
                        $loadkgc = loadall_khunggiochieu();
                        include "./view/user/sua.php";
                        break;
                    } else {
                        sua_tk($id, $name, $user, $pass, $email, $phone, $dia_chi);
                        $suatc = "Sửa thành công";
                    }
                }

                $loadalltk = loadall_taikhoan_nv();
                include "./view/user/QTvien.php";
                break;
            case "xoatk":
                if (isset($_GET['idxoa'])) {
                    $id = $_GET['idxoa'];
                    xoa_tk($id);

                    $loadall_kh = loadall_taikhoan();
                    include "./view/user/QTvien.php";
                } else {
                    include "./view/user/QTvien.php";
                }
                break;
            case "dangxuat":
                unset($_SESSION['user1']);
                header('location: login.php');
                exit;
            case "home":
                $best_combo = best_combo();
                $tong_tuan = tong_week();
                $tong_thang = tong_thang();
                $tong_day = tong_day();
                $tpdc = tong_phimdc();
                $tpsc = tong_phimsc();
                $tong = tong();
                include "./view/home.php";
                break;
            case "ctve":
                if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                    $loadone_ve =  loadone_vephim($_GET['id']);
                }
                include "view/vephim/ct_ve.php";
                break;
            case "capnhat_tt_ve":
                if (isset($_POST['tk']) && ($_POST['tk'])) {
                    $searchName = $_POST['ten'];
                    $searchTieuDe = $_POST['tieude'];
                } else {
                    $searchName = "";
                    $searchTieuDe = "";
                }

                include "./view/vephim/ve.php";
                if (isset($_POST['capnhat'])) {
                    capnhat_tt_ve();
                }
                $loadvephim = loadall_vephim1($searchName, $searchTieuDe, $searchid);
                include "./view/user/QTvien.php";
                break;

            case "themthongtin":
                if (isset($_GET['act']) && $_GET['act'] == 'themthongtin') {
                    include "./view/lichlamviec/themthongtin.php"; // Đảm bảo file được gọi đúng
                }
            case "rap":
                if (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 3) {
                    $rap_id = $_SESSION['user1']['rap_id'];
                    $loadrap = loadall_rap($rap_id);
                } else {
                    $loadrap = loadall_rap();
                }
                include "./view/rap/rap.php";
                break;
            case "xoarap":
                if (isset($_GET['idxoa'])) {
                    xoa_rap($_GET['idxoa']);
                    $loadrap = loadall_rap();
                    include "./view/rap/rap.php";
                }
                break;
            case "suarap":
                if (isset($_GET['ids'])) {
                    $loadrap1 = loadone_rap($_GET['ids']);
                }
                include "./view/rap/sua.php";
                break;

            case "updaterap":

                $loadrap = load_rap();
                if (isset($_POST['capnhat'])) {
                    $id = $_POST['id'];
                    $tenrap = $_POST['tenrap'];
                    $diachi = $_POST['diachi'];
                    $sdt = $_POST['sdt'];
                    $email_rap = $_POST['email_rap'];


                    if ($id == '' || $tenrap == '' || $diachi == '' || $sdt == '' || $email_rap == '') {
                        $error = "vui lòng không để trống";
                        $loadrap1 = loadone_rap($id);
                        include "./view/rap/sua.php";
                        break;
                    } else {
                        update_rap($id, $tenrap, $diachi, $sdt, $email_rap);
                        $suatc = "sửa thành công";
                    }
                }
                $loadrap = load_rap();
                include "./view/rap/rap.php";
                break;
            case "themrap":
                $loadrap = load_rap();
                if (isset($_POST['len'])) {
                    //  $id = $_POST['id'];
                    $tenrap = $_POST['tenrap'];
                    $diachi = $_POST['diachi'];
                    $sdt = $_POST['sdt'];
                    $email_rap = $_POST['email_rap'];
                    if ($tenrap == '' || $diachi == '' || $sdt == '' || $email_rap == '') {
                        $error = "vui lòng không để trống";
                        $loadrap1 = loadone_rap($id);
                        include "./view/rap/them.php";
                        break;
                    } else {
                        them_rap($tenrap, $diachi, $sdt, $email_rap);
                        $suatc = "Thêm thành công";
                    }
                }
                $loadrap = load_rap();
                include "./view/rap/them.php";
                break;


            case "lichlamviec":
                // Lấy thông tin rạp
                $dsrap = getAllRap();

                // Lấy thông tin rạp được chọn
                if (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 1) {
                    $rap_id = $_SESSION['user1']['rap_id'];
                }
                $selected_rap = isset($_GET['rap_id']) ? $_GET['rap_id'] : '';

                // Lấy thông tin tuần đ��ợc chọn 
                $current_week = isset($_GET['week']) ? $_GET['week'] : date('Y-m-d');
                $week_start = date('Y-m-d', strtotime('monday this week', strtotime($current_week)));
                $week_end = date('Y-m-d', strtotime('sunday this week', strtotime($current_week)));

                // Load lịch làm việc
                $loadlichlamviec = loadall_lichlamviec($selected_rap, $week_start, $week_end);

                // Include view
                include "./view/lichlamviec/lichlamviec.php";
                break;

            case "themvitriquanly":
                if (isset($_POST['len'])) {
                    $id_taikhoan = $_POST['id_taikhoan'];
                    $id_rap = $_POST['id_rap'];
                    $ten_cong_viec = $_POST['ten_cong_viec'];
                    $thang_lam = $_POST['ngay_lam_viec'];

                    if ($id_taikhoan == '' || $id_rap == '' || $ten_cong_viec == '' || $thang_lam == '') {
                        $error = "Vui lòng không để trống";
                    } else {
                        try {
                            // Lấy ngày đầu và cuối của tháng để kiểm tra
                            $first_day = date('Y-m-01', strtotime($thang_lam));
                            $last_day = date('Y-m-t', strtotime($thang_lam));

                            // Kiểm tra xem đã có lịch trong tháng này chưa
                            $sql_check = "SELECT COUNT(*) as count FROM lichlamviec 
                            WHERE id_taikhoan = ? 
                            AND id_rap = ? 
                            AND ngay_lam_viec BETWEEN ? AND ?";

                            $count = pdo_query($sql_check, $id_taikhoan, $id_rap, $first_day, $last_day)[0]['count'];

                            if ($count > 0) {
                                throw new Exception("Quản lý đã có lịch làm việc trong tháng này");
                            }

                            // Thêm lịch làm việc
                            them_lich_quanly($id_taikhoan, $id_rap, $thang_lam, $ten_cong_viec);
                            
                            // Cập nhật rap_id trong bảng taikhoan
                            update_rap_id($id_taikhoan, $id_rap);

                            echo "<script>
                                alert('Thêm vị trí quản lý thành công!');
                                window.location.href='index.php?act=lichlamviec';
                            </script>";
                            exit;
                        } catch (Exception $e) {
                            $error = $e->getMessage();
                        }
                    }
                }
                include "./view/lichlamviec/them_quanly.php";
                break;




            case "themlichnhanvien":
                if (isset($_POST['len'])) {
                    $ten_nhanvien = $_POST['ten_nhanvien'];
                    $id_rap = $_POST['id_rap'];
                    $ngay_lam_viec = $_POST['ngay_lam_viec'];
                    $ca_lam_viec = $_POST['ca_lam_viec'];
                    $ten_cong_viec = $_POST['ten_cong_viec'];

                    // Debug để xem giá trị
                    echo "<pre>";
                    echo "ten_nhanvien: " . $ten_nhanvien . "\n";
                    echo "id_rap: " . $id_rap . "\n";
                    echo "ngay_lam_viec: " . $ngay_lam_viec . "\n";
                    echo "ca_lam_viec: " . $ca_lam_viec . "\n";
                    echo "ten_cong_viec: " . $ten_cong_viec . "\n";
                    echo "</pre>";

                    // Kiểm tra từng điều kiện riêng biệt
                    if (empty($ten_nhanvien)) echo "ten_nhanvien trống<br>";
                    if (empty($id_rap)) echo "id_rap trống<br>";
                    if (empty($ngay_lam_viec)) echo "ngay_lam_viec trống<br>";
                    if (empty($ca_lam_viec)) echo "ca_lam_viec trống<br>";
                    if (empty($ten_cong_viec)) echo "ten_cong_viec trống<br>";

                    if (
                        $ten_nhanvien == '' || $id_rap == '' || $ngay_lam_viec == '' ||
                        $ca_lam_viec == '' || $ten_cong_viec == ''
                    ) {
                        $error = "Vui lòng không để trống";
                        include "./view/lichlamviec/them_nhanvien.php";
                        break;
                    } else {
                        them_lich_nhanvien($ten_nhanvien, $id_rap, $ngay_lam_viec, $ca_lam_viec, $ten_cong_viec);
                        $suatc = "Thêm lịch nhân viên thành công";
                        $loadlichlamviec = loadall_lichlamviec();
                        include "./view/lichlamviec/lichlamviec.php";
                        break;
                    }
                }
                include "./view/lichlamviec/them_nhanvien.php";
                break;



            case "updatequanly":
                if (isset($_GET['ten']) && isset($_GET['rap'])) {
                    $ten = urldecode($_GET['ten']);
                    $rap_id = $_GET['rap'];

                    if (isset($_POST['capnhat'])) {
                        try {
                            $id_taikhoan = $_POST['id_taikhoan'];
                            $id_rap = $_POST['id_rap'];
                            $ten_cong_viec = $_POST['ten_cong_viec'];

                            // Debug: In ra dữ liệu POST
                            error_log("POST data received: " . print_r($_POST, true));

                            // Đảm bảo working_days là mảng
                            $working_days = isset($_POST['working_days']) ? $_POST['working_days'] : [];

                            // Debug
                            error_log("Working days before processing: " . print_r($working_days, true));

                            $current_date = date('Y-m-d');

                            // Lấy tất cả lịch làm việc hiện tại từ ngày mai
                            $sql_get_current = "SELECT * FROM lichlamviec 
                                                                      WHERE id_taikhoan = ? 
                                                                      AND id_rap = ? 
                                                                      AND ngay_lam_viec > ?";
                            $current_schedule = pdo_query($sql_get_current, $id_taikhoan, $id_rap, $current_date);

                            // Xóa những ngày không được chọn
                            foreach ($current_schedule as $schedule) {
                                if (!in_array($schedule['ngay_lam_viec'], $working_days)) {
                                    $sql_delete = "DELETE FROM lichlamviec WHERE id = ?";
                                    pdo_execute($sql_delete, $schedule['id']);
                                    error_log("Deleted schedule for date: " . $schedule['ngay_lam_viec']);
                                }
                            }

                            // Thêm những ngày mới được chọn
                            $existing_days = array_column($current_schedule, 'ngay_lam_viec');
                            foreach ($working_days as $ngay) {
                                if (!in_array($ngay, $existing_days) && $ngay > $current_date) {
                                    $sql_insert = "INSERT INTO lichlamviec 
                                                                         (id_taikhoan, id_rap, ngay_lam_viec, ca_lam_viec, ten_cong_viec, trang_thai_cham_cong)
                                                                         VALUES (?, ?, ?, 'Full time', ?, 'chưa chấm công')";
                                    pdo_execute($sql_insert, $id_taikhoan, $id_rap, $ngay, $ten_cong_viec);
                                    error_log("Inserted new schedule for date: " . $ngay);
                                }
                            }

                            $_SESSION['success_msg'] = "Cập nhật lịch làm việc thành công!";
                            header("Location: index.php?act=lichlamviec");
                            exit;
                        } catch (Exception $e) {
                            error_log("Error in updatequanly: " . $e->getMessage());
                            $_SESSION['error_msg'] = "Lỗi: " . $e->getMessage();
                        }
                    }

                    $lichlamviec = loadLichQuanLyByTenRap($ten, $rap_id);
                    $list_rap = loadall_rap();
                    include "./view/lichlamviec/sua_quanly.php";
                } else {
                    header("Location: index.php?act=lichlamviec");
                    exit;
                }
                break;







            case "updatenhanvien":
                if (isset($_POST['capnhat'])) {
                    try {
                        // Lấy thông tin cơ bản
                        $ten_nhanvien = $_POST['ten_nhanvien'];
                        $id_rap = $_POST['id_rap'];
                        $ngay_bat_dau = $_POST['ngay_bat_dau'];
                        $so_tuan = $_POST['so_tuan'];
                        $ten_cong_viec = $_POST['ten_cong_viec'];
                        $lich_lam = isset($_POST['lich']) ? $_POST['lich'] : array();

                        // Lấy danh sách các ngày trong khoảng thời gian được chọn
                        $ngay_ket_thuc = date('Y-m-d', strtotime($ngay_bat_dau . ' + ' . ($so_tuan * 7 - 1) . ' days'));

                        // Lấy lịch làm việc hiện tại từ ngày mai
                        $sql = "SELECT * FROM lichlamviec 
                   WHERE ten_nhanvien = ? 
                   AND id_rap = ? 
                   AND ngay_lam_viec >= CURDATE()";
                        $lich_hien_tai = pdo_query($sql, $ten_nhanvien, $id_rap);

                        // Xóa những ca không được chọn
                        foreach ($lich_hien_tai as $lich) {
                            $ngay = $lich['ngay_lam_viec'];
                            $thu = date('w', strtotime($ngay));

                            // Lấy số ca từ tên ca (ví dụ: "Ca 1 (8:00-12:00)" -> 1)
                            preg_match('/Ca (\d+)/', $lich['ca_lam_viec'], $matches);
                            $so_ca = $matches[1];

                            // Kiểm tra xem ca này có được chọn trong form không
                            if (!isset($lich_lam[$thu][$so_ca])) {
                                // Nếu không được chọn thì xóa
                                $sql_delete = "DELETE FROM lichlamviec 
                                 WHERE id = ?";
                                pdo_execute($sql_delete, $lich['id']);
                            }
                        }

                        // Thêm các ca mới được chọn
                        foreach ($lich_lam as $thu => $ca_trong_ngay) {
                            foreach ($ca_trong_ngay as $ca => $value) {
                                if ($value) {
                                    $ngay = date('Y-m-d', strtotime($ngay_bat_dau . ' + ' . $thu . ' days'));

                                    // Kiểm tra xem ca này đã tồn tại chưa
                                    $sql_check = "SELECT id FROM lichlamviec 
                                    WHERE ten_nhanvien = ? 
                                    AND id_rap = ? 
                                    AND ngay_lam_viec = ? 
                                    AND ca_lam_viec = ?";
                                    $ca_lam = "Ca " . $ca . " (" . get_ca_lam_text($ca) . ")";
                                    $exists = pdo_query_one($sql_check, $ten_nhanvien, $id_rap, $ngay, $ca_lam);

                                    if (!$exists) {
                                        // Nếu chưa tồn tại thì thêm mới
                                        $sql_insert = "INSERT INTO lichlamviec(
                                ten_nhanvien, 
                                id_rap, 
                                ngay_lam_viec, 
                                ca_lam_viec, 
                                ten_cong_viec,
                                trang_thai_cham_cong
                            ) VALUES (?, ?, ?, ?, ?, 'chưa chấm công')";

                                        pdo_execute(
                                            $sql_insert,
                                            $ten_nhanvien,
                                            $id_rap,
                                            $ngay,
                                            $ca_lam,
                                            $ten_cong_viec
                                        );
                                    }
                                }
                            }
                        }

                        // Đặt flag thành công
                        $_SESSION['success_msg'] = "Cập nhật lịch làm việc thành công!";

                        // Chuyển hướng về trang danh sách
                        header("Location: index.php?act=lichlamviec");
                        exit();
                    } catch (Exception $e) {
                        $_SESSION['error_msg'] = "Lỗi cập nhật lịch: " . $e->getMessage();
                        header("Location: index.php?act=lichlamviec");
                        exit();
                    }
                }
                include "view/lichlamviec/sua_nhanvien.php";
                break;





            case "xoalichlamviec":
                if (isset($_GET['idxoa'])) {
                    try {
                        xoa_lichlamviec($_GET['idxoa']);
                        echo "<script>alert('Xóa thành công!');</script>";
                    } catch (Exception $e) {
                        echo "<script>alert('Không thể xóa! Lỗi: " . $e->getMessage() . "');</script>";
                    }
                    $loadlichlamviec = loadall_lichlamviec();
                    include "./view/lichlamviec/lichlamviec.php";
                }
                break;





            case "khuyenmai":
                $loadkhuyenmai = loadall_khuyenmai();
                include "./view/khuyenmai/khuyenmai.php";
                break;
            case "xoakhuyenmai":
                if (isset($_GET['idxoa'])) {
                    xoa_khuyenmai($_GET['idxoa']);
                    $loadkhuyenmai = loadall_khuyenmai();
                    include "./view/khuyenmai/khuyenmai.php";
                }
                break;
                // case 'suakhuyenmai':
                //     if(isset($_GET['id'])) {
                //         $id = $_GET['id'];
                //         $km = loadone_khuyenmai($id);
                //         include "./view/khuyenmai/sua.php";
                //     }
                //     break;

                // case 'updatekhuyenmai':
                //     if(isset($_POST['capnhat'])) {
                //         $id = $_POST['id'];
                //         $ten_km = $_POST['ten_km'];
                //         $gia_tri = $_POST['gia_tri'];
                //         $ngay_ket_thuc = $_POST['ngay_ket_thuc'];
                //         $mota = $_POST['mota'];

                //         update_khuyenmai($id, $ten_km, $gia_tri, $ngay_ket_thuc, $mota);
                //         header("Location: index.php?act=khuyenmai");
                //     }

                //         $loadkhuyenmai= load_khuyenmai();
                //         include "./view/khuyenmai/khuyenmai.php";
                //         break;



            case "suakhuyenmai":
                if (isset($_GET['ids'])) {
                    $loadkhuyenmai1 = loadone_khuyenmai($_GET['ids']);
                }
                include "./view/khuyenmai/sua.php";
                break;

            case "updatekhuyenmai":

                $loadkhuyenmai = load_khuyenmai();
                if (isset($_POST['capnhat'])) {
                    $id = $_POST['id'];
                    $ten_km = $_POST['ten_km'];
                    $gia_tri = $_POST['gia_tri'];
                    $ngay_ket_thuc = $_POST['ngay_ket_thuc'];
                    $mota = $_POST['mota'];


                    if ($id == '' || $ten_km == '' || $gia_tri == '' || $ngay_ket_thuc == '' || $mota == '') {
                        $error = "vui lòng không để trống";
                        $loadkhuyenmai1 = loadone_khuyenmai($id);
                        include "./view/khuyenmai/sua.php";
                        break;
                    } else {
                        update_khuyenmai($id, $ten_km, $gia_tri, $ngay_ket_thuc, $mota);
                        $suatc = "sửa thành công";
                    }
                }
                $loadkhuyenmai = load_khuyenmai();
                include "./view/khuyenmai/khuyenmai.php";
                break;

            case "themkhuyenmai":
                if (isset($_POST['len'])) {
                    $ten_km = $_POST['ten_km'];
                    $gia_tri = $_POST['gia_tri'];
                    $ngay_ket_thuc = $_POST['ngay_ket_thuc'];
                    $mota = $_POST['mota'];

                    if ($ten_km == '' || $gia_tri == '' || $ngay_ket_thuc == '') {
                        $error = "Vui lòng không để trống";
                    } else {
                        them_khuyenmai($ten_km, $gia_tri, $ngay_ket_thuc, $mota);
                        echo "<script>
                                                            alert('Thêm thành công!');
                                                            window.location.href='index.php?act=khuyenmai';
                                                          </script>";
                        exit();
                    }
                }
                include "./view/khuyenmai/them.php";
                break;
                // ... code hiện tại của bạn ...\





                // case "chamcong":
                //     // Include model chấm công
                //     include "model/chamcong.php";

                //     // Kiểm tra đăng nhập và quyền quản lý
                //     if (!isset($_SESSION['user1']) || $_SESSION['user1']['vai_tro'] != 2) {
                //         echo "<script>
                //                 alert('Bạn không có quyền truy cập!');
                //                 window.location.href='index.php';
                //               </script>";
                //         exit();
                //     }
                //     // Lấy tháng năm từ request
                //     $thang = isset($_GET['thang']) ? $_GET['thang'] : date('m');
                //     $nam = isset($_GET['nam']) ? $_GET['nam'] : date('Y');

                //     // Lấy danh sách lịch làm việc hôm nay
                //     $dsLichLamViec = getLichLamViecAll();

                //     // Lấy bảng chấm công
                //     $bangChamCong = getBangChamCong($thang, $nam);

                //     include "./view/chamcong/chamcong.php";
                //     break;

                //     case "xu-ly-cham-cong":
                //         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //             $id_lichlamviec = $_POST['id_lichlamviec'];
                //             $trang_thai = $_POST['trang_thai'];

                //             // Kiểm tra giá trị hợp lệ
                //             $trang_thai_hop_le = ['chưa chấm công', 'đúng giờ', 'đi trễ', 'vắng'];
                //             if (!in_array($trang_thai, $trang_thai_hop_le)) {
                //                 echo "<script>
                //                         alert('Trạng thái không hợp lệ!');
                //                         window.location.href='chamcong.php?act=chamcong';
                //                       </script>";
                //                     exit();
                //                 }

                //                 try {
                //                     $conn = pdo_get_connection();
                //                     $sql = "UPDATE lichlamviec 
                //                            SET trang_thai_cham_cong = :trang_thai 
                //                            WHERE id = :id";

                //                     $stmt = $conn->prepare($sql);
                //                     $stmt->bindValue(':trang_thai', $trang_thai);
                //                     $stmt->bindValue(':id', $id_lichlamviec);

                //                     if($stmt->execute()) {
                //                         echo "<script>
                //                                 alert('Cập nhật trạng thái chấm công thành công!');
                //                                 window.location.href='chamcong.php?act=chamcong';
                //                               </script>";
                //                     } else {
                //                         echo "<script>
                //                                 alert('Không thể cập nhật trạng thái!');
                //                                 window.location.href='chamcong.php?act=chamcong';
                //                               </script>";
                //                     }
                //                 } catch(PDOException $e) {
                //                     echo "<script>
                //                             alert('Có lỗi xảy ra: " . $e->getMessage() . "');
                //                             window.location.href='chamcong.php?act=chamcong';
                //                           </script>";
                //                 }
                //             }
                //             break;


            case 'chamcong_nhanvien':
                include_once "model/lichlamviec.php";  // Thêm dòng này nếu chưa có

                $thang = isset($_GET['thang']) ? date('m', strtotime($_GET['thang'])) : date('m');
                $nam = isset($_GET['thang']) ? date('Y', strtotime($_GET['thang'])) : date('Y');
                $ngay = isset($_GET['ngay']) ? $_GET['ngay'] : date('Y-m-d');
                $rap_id = isset($_GET['rap']) ? $_GET['rap'] : null;

                $dsRap = getAllRap();  // Sử dụng function từ lichlamviec.php
                $dsLichLamViec = getLichLamViecNhanVien($ngay, $rap_id);
                $thongKe = getThongKeNhanVienChiTiet($thang, $nam, $rap_id);


                include "view/chamcong/chamcong_nhanvien.php";
                break;

            case 'chamcong_quanly':
                // Lấy tham số
                $rap_id = isset($_GET['rap_id']) ? $_GET['rap_id'] : null;
                $thang = isset($_GET['thang']) ? $_GET['thang'] : date('m');
                $nam = isset($_GET['nam']) ? $_GET['nam'] : date('Y');

                // Lấy danh sách rạp để filter
                $dsRap = getAllRap();

                // Lấy danh sách quản lý làm việc hôm nay
                $dsQuanLyHomNay = getQuanLyLamViecHomNay($rap_id);

                // Lấy thống kê theo tháng
                $thongKeThang = getThongKeQuanLyTheoThang($thang, $nam, $rap_id);

                // Load view
                include "view/chamcong/chamcong_quanly.php";
                break;

            case 'xu_ly_chamcong':
                if (isset($_POST['id_lichlamviec']) && isset($_POST['trang_thai'])) {
                    if (chamCong($_POST['id_lichlamviec'], $_POST['trang_thai'])) {
                        $_SESSION['success_msg'] = "Cập nhật trạng thái chấm công thành công!";
                    } else {
                        $_SESSION['error_msg'] = "Có lỗi xảy ra khi cập nhật trạng thái!";
                    }
                }
                $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'chamcong_nhanvien';
                header("Location: index.php?act=$redirect");
                break;







                // case 'sodo':
                //     if(isset($_GET['id']) && $_GET['id'] > 0) {
                //         $loadphong1 = loadone_phong($_GET['id']);
                //     }
                //     include "view/phong/sodo.php";
                //     break;



            case "baocao":
                $loadrap = loadall_rap();
                $rap_id = isset($_GET['rap_id']) ? $_GET['rap_id'] : null;
                include "./view/baocao/baocao.php";  // Sửa đường dẫn từ danhthu thành baocao
                break;

            case "baocao_ngay":
                $loadrap = loadall_rap();
                $rap_id = isset($_GET['rap_id']) ? $_GET['rap_id'] : null;
                $thongke_phim = thongke_phim_theo_ngay(date('Y-m-d'), $rap_id);
                include "./view/baocao/baocao_ngay.php";
                break;

            case "baocao_tuan":
                $loadrap = loadall_rap();
                $rap_id = isset($_GET['rap_id']) ? $_GET['rap_id'] : null;
                $week = date('YW');
                $thongke_phim = thongke_phim_theo_tuan($week, $rap_id);
                include "./view/baocao/baocao_tuan.php";
                break;

            case "baocao_thang":
                $loadrap = loadall_rap();
                $rap_id = isset($_GET['rap_id']) ? $_GET['rap_id'] : null;

                // Lấy tháng năm được chọn từ form
                $selected_month = isset($_GET['thang']) ? $_GET['thang'] : date('m');
                $selected_year = isset($_GET['nam']) ? $_GET['nam'] : date('Y');

                // Cập nhật biến current_month và current_year
                $current_month = $selected_month;
                $current_year = $selected_year;

                // Lấy thống kê theo tháng và năm đã chọn
                $thongke_phim = thongke_phim_theo_thang($current_month, $current_year, $rap_id);
                include "./view/baocao/baocao_thang.php";
                break;





            case 'bangluong':
                include "view/chamcong/bangluong.php";
                break;

            case 'bangluong_quanly':
                // Lấy tháng năm từ request, mặc định là tháng hiện tại
                $thang = isset($_GET['thang']) ? date('m', strtotime($_GET['thang'])) : date('m');
                $nam = isset($_GET['thang']) ? date('Y', strtotime($_GET['thang'])) : date('Y');

                // Lấy danh sách quản lý và tính lương
                $dsQuanLy = getAllQuanLy();
                $luongQuanLy = [];

                foreach ($dsQuanLy as $ql) {
                    $luongQuanLy[] = [
                        'thong_tin' => $ql,
                        'luong' => tinhLuongQuanLy($ql['id'], $thang, $nam)
                    ];
                }

                include "view/chamcong/bangluong_quanly.php";
                break;

            case 'bangluong_nhanvien':
                // Lấy tháng năm từ request, mặc định là tháng hiện tại
                $thang = isset($_GET['thang']) ? date('m', strtotime($_GET['thang'])) : date('m');
                $nam = isset($_GET['thang']) ? date('Y', strtotime($_GET['thang'])) : date('Y');

                // Lấy danh sách rạp để lọc
                $dsRap = getAllRap();
                $rap_id = isset($_GET['rap']) ? $_GET['rap'] : null;

                // Lấy danh sách nhân viên và tính lương
                $dsNhanVien = getAllNhanVien($rap_id);
                $luongNhanVien = [];

                foreach ($dsNhanVien as $nv) {
                    $luongNhanVien[] = [
                        'thong_tin' => $nv,
                        'luong' => tinhLuongNhanVien($nv['ten_nhanvien'], $thang, $nam)
                    ];
                }

                include "view/chamcong/bangluong_nhanvien.php";
                break;




            case 'get_chitiet_chamcong':
                $loai = $_POST['loai'] ?? '';
                $id = $_POST['id'] ?? '';
                $thang = $_POST['thang'] ?? date('m');
                $nam = $_POST['nam'] ?? date('Y');

                $chitiet = [];
                $thongke = [
                    'so_lan_vang' => 0,
                    'so_lan_tre' => 0
                ];

                if ($loai == 'ql') {
                    // Lấy chi tiết chấm công quản lý
                    $sql = "SELECT ngay_lam_viec, trang_thai_cham_cong 
                                                                                        FROM lichlamviec 
                                                                                        WHERE id_taikhoan = ? 
                                                                                        AND MONTH(ngay_lam_viec) = ?
                                                                                        AND YEAR(ngay_lam_viec) = ?
                                                                                        ORDER BY ngay_lam_viec ASC";
                    $chitiet = pdo_query($sql, $id, $thang, $nam);
                } else {
                    // Lấy chi tiết chấm công nhân viên
                    $sql = "SELECT ngay_lam_viec, ca_lam_viec, ten_cong_viec, trang_thai_cham_cong
                                                                                        FROM lichlamviec 
                                                                                        WHERE ten_nhanvien = ? 
                                                                                        AND MONTH(ngay_lam_viec) = ?
                                                                                        AND YEAR(ngay_lam_viec) = ?
                                                                                        ORDER BY ngay_lam_viec ASC, ca_lam_viec ASC";
                    $chitiet = pdo_query($sql, $id, $thang, $nam);
                }

                if ($chitiet) {
                    foreach ($chitiet as $item) {
                        if ($item['trang_thai_cham_cong'] == 'vắng') $thongke['so_lan_vang']++;
                        if ($item['trang_thai_cham_cong'] == 'đi trễ') $thongke['so_lan_tre']++;
                    }
                }

                include "./view/chamcong/modal_chitiet.php";
                break;
        }
    } else {
        $best_combo = best_combo();
        $tong_tuan = tong_week();
        $tong_thang = tong_thang();
        $tong_day = tong_day();
        $tpdc = tong_phimdc();
        $tpsc = tong_phimsc();
        $tong = tong();
        include "./view/home.php";
    }

    include "./view/home/footer.php";
} else {
    header('location: login.php');
}
