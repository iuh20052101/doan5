
<?php 
        include "./view/home/sideheader.php";
        ?>
        <!-- Content Body Start -->
        <div class="content-body">
        <!-- <link rel="stylesheet" href="assets/css/stylecolor.css"> -->


            <!-- Page Headings Start -->
            <div class="row justify-content-between align-items-center mb-10">
        
               
                <!-- Page Heading Start -->
                <div class="col-12 col-lg-auto mb-20">
                    <div class="page-heading">
                        <h3>Quản lý rạp  <span>/ rạp chiếu</span></h3>
                    </div>
                </div><!-- Page Heading End -->

            </div><!-- Page Headings End -->
            <?php if(isset($suatc)&&($suatc)!= ""){
        echo'<p  style="color: red; text-align: center;">' .$suatc. '</p>';
    }
    ?> 
            <div class="row">
 <div class="col-12 mb-30">
                <div class="news-item">
                <div class="content">
                <?php if (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 2): ?>
                <div class="categories"><a href="index.php?act=themrap" class="product">Thêm rạp</a></div></div></div>
                <?php endif; ?>
                <!--Order List Start-->
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-vertical-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên rạp</th>
                                    <th>Địa chỉ</th>
                                    <th>Số điện thoại</th>
                                    <th>Email rạp</th>
                                    <th>Quản lý</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($loadrap as $pc){
                                    extract($pc);
                                    $linksua = "index.php?act=suarap&ids=".$id;
                                    $linkxoa = "index.php?act=xoarap&idxoa=".$id;

                                    echo '<tr>
                                    <td>'.$id.'</td>
                                    <td>'.$pc['tenrap'].'</td>
                                    <td>'.$pc['diachi'].'</td>
                                    <td>'.$pc['sdt'].'</td>
                                    <td>'.$pc['email_rap'].'</td>
                                  
                              
                                    <td >
                                        <div class="table-action-buttons">
                                            <a class="edit button button-box button-xs button-info" href="'.$linksua.'"><i class="zmdi zmdi-edit"></i></a>
                                            <a class="delete button button-box button-xs button-danger" href="'.$linkxoa.'"><i class="zmdi zmdi-delete"></i></a>
                                        </div>
                                    </td>
                                </tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Order List End-->

            </div>
            </div>

        </div><!-- Content Body End -->

       