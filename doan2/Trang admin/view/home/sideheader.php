<!-- Side Header Start -->
<div class="side-header show">

    <button class="side-header-close"><i class="zmdi zmdi-close"></i></button>
    <!-- Side Header Inner Start -->
    <div class="side-header-inner custom-scroll">

        <nav class="side-header-menu" id="side-header-menu">
            <ul>

                <li><a href="index.php?act=home"><i class="fa fa-institution"></i> <span>Trang chủ</span></a></li>
                <!-- Staff -->
                <?php if (isset($_SESSION['user1']) && ($_SESSION['user1']['vai_tro'] == 1 || $_SESSION['user1']['vai_tro'] == 2)): ?>
                    <li><a href="index.php?act=QLloaiphim"><i class="fa fa-tag"></i> <span>Quản Lý Loại Phim</span></a></li>
                    <li><a href="index.php?act=QLphim"><i class="fa fa-film"></i> <span>Quản Lý Phim</span></a></li>
                    <li class="has-sub-menu"><a href="#"><i class="ti-shopping-cart"></i> <span>Quản Lý Vé Xem Phim</span></a>
                        <ul class="side-header-sub-menu">
                            <li><a href="index.php?act=ve"><i class="zmdi zmdi-local-movies zmdi-hc-fw"></i> <span>Vé</span></a></li>
                            <!-- <li><a href="index.php?act=ct_ve"><i class="zmdi zmdi-local-movies zmdi-hc-fw"></i> <span>chi tiết vé</span></a></li> -->
                        </ul>
                    </li>
                    <li class="has-sub-menu"><a href="#"><i class="zmdi zmdi-tv-alt-play zmdi-hc-fw"></i> <span>Quản Lý Lịch Chiếu</span></a>
                        <ul class="side-header-sub-menu">
                            <li><a href="index.php?act=QLlichchieu"><i class="zmdi zmdi-tv-alt-play zmdi-hc-fw"></i><span>Lịch Chiếu</span></a></li>
                            <li><a href="index.php?act=thoigian"><i class="zmdi zmdi-tv-alt-play zmdi-hc-fw"></i><span>Suất Chiếu </span></a></li>
                        </ul>
                    </li>
                    <li><a href="index.php?act=khuyenmai"><i class="fa fa-tags"></i> <span>Quản Lý khuyến mãi</span></a></li>
                    <li><a href="index.php?act=QLfeed&&sotrang=1"><i class="fa fa-comments"></i> <span>Quản Lý Feedback</span></a></li>
                <?php endif; ?>
                <!-- End Staff -->

                <!-- Manager -->
                <?php if (isset($_SESSION['user1']) && ($_SESSION['user1']['vai_tro'] == 3 || $_SESSION['user1']['vai_tro'] == 2)): ?>
                <li><a href="index.php?act=rap"><i class="fa fa-video-camera"></i> <span>Quản Lý rạp</span></a></li>
                <li><a href="index.php?act=phong"><i class="fa fa-building"></i> <span>Quản Lý Phòng</span></a></li>
                <li><a href="#"><i class="fa fa-user"></i> <span>Quản Lý Tài Khoản</span></a>
                    <ul class="side-header-sub-menu">
                        <?php if ($_SESSION['user1']['vai_tro'] == 2) { ?>
                        <?php } ?>
                        <li><a href="index.php?act=QTkh"><i class="fa fa-users"></i> <span>Khách Hàng</span></a></li>
                        <li><a href="index.php?act=QTvien"><i class="fa fa-users"></i> <span>Nhân Viên</span></a></li> <!-- Dòng mới -->
                    </ul>
                </li>
                <li>
                    <a href="index.php?act=lichlamviec"><i class="fa fa-calendar"></i> <span>Quản Lý Lịch Làm Việc</span></a>
                    <!-- <ul class="side-header-sub-menu">
                                <li><a href="index.php?act=lich"><i class="zmdi zmdi-tv-alt-play zmdi-hc-fw"></i><span>Lịch làm việc</span></a></li>
                                <li><a href="index.php?act=themthongtin"><i class="zmdi zmdi-tv-alt-play zmdi-hc-fw"></i><span>Thêm thông tin </span></a></li>
                    </ul> -->
                </li>
                <li class="has-sub-menu"><a href="#"><i class="fa fa-tasks"></i> <span>Quản Lý chấm công</span></a>
                    <ul class="side-header-sub-menu">

                        <li><a href="index.php?act=chamcong_quanly"><i class="fa fa-tasks"></i><span>Chấm công quản lý</span></a></li>
                        <li><a href="index.php?act=chamcong_nhanvien"><i class="fa fa-tasks"></i><span>Chấm công nhân viên </span></a></li>
                        <li><a href="index.php?act=bangluong"><i class="fa fa-tasks"></i><span>Bảng lương </span></a></li>

                    </ul>
                </li>
                <?php endif; ?>
                <!-- End Manager -->

                <?php if (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 2): ?>
                    <li class="has-sub-menu"><a href="#"><i class="fa fa-line-chart"></i> <span>Theo Dõi Danh Thu</span></a>
                        <ul class="side-header-sub-menu">
                            <!-- Sửa lại thành -->
                            <li><a href="index.php?act=DTrap&trang=1"><i class="fa fa-line-chart"></i><span>Doanh Thu Theo Rạp</span></a></li>
                            <li><a href="index.php?act=DTphim&trang=1"><i class="fa fa-line-chart"></i><span>Danh Thu Phim</span></a></li>
                            <!-- <li><a href="index.php?act=DTngay&&trang=1"><i class="fa fa-line-chart" ></i><span>Danh Thu Theo Ngày</span></a></li> -->
                            <li><a href="index.php?act=DTtuan&&trang=1"><i class="fa fa-line-chart"></i><span>Danh Thu Theo Tuần</span></a></li>
                            <li><a href="index.php?act=DTthang&&trang=1"><i class="fa fa-line-chart"></i><span>Danh Thu Theo Tháng</span></a></li>
                        </ul>
                    </li>
                    <li class="has-sub-menu">
                        <a href="#"><i class="fas fa-chart-line"></i> <span>Báo Cáo & Thống Kê</span></a>
                        <ul class="side-header-sub-menu">
                            <li>
                                <a href="index.php?act=baocao">
                                    <i class="fas fa-chart-pie"></i> Tổng Quan Doanh Thu
                                </a>
                            </li>
                            <li>
                                <a href="index.php?act=baocao_ngay">
                                    <i class="fas fa-calendar-day"></i> Báo Cáo Theo Ngày
                                </a>
                            </li>
                            <li>
                                <a href="index.php?act=baocao_tuan">
                                    <i class="fas fa-calendar-week"></i> Báo Cáo Theo Tuần
                                </a>
                            </li>
                            <li>
                                <a href="index.php?act=baocao_thang">
                                    <i class="fas fa-calendar-alt"></i> Báo Cáo Theo Tháng
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

    </div><!-- Side Header Inner End -->
</div><!-- Side Header End -->