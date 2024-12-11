<?php
include "./view/home/sideheader.php";
if (is_array($loadphong1)) {
    extract($loadphong1);
}
$sql_rap = "SELECT id, tenrap FROM rap";
$rap_list = pdo_query($sql_rap);
?>

<!-- Content Body Start -->
<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Phòng <span>/ Sửa phòng</span></h3>
            </div>
        </div>
    </div>

    <!-- Add or Edit Product Start -->
    <div class="col-lg-12 col-12 mb-30">
        <div class="box">
            <div class="box-head">
                <h4 class="title">Sửa phòng chiếu</h4>
            </div>
            <div class="box-body">
                <form action="index.php?act=updatephong" method="POST">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    
                    <div class="row">
                        <div class="col-md-8 mb-30">
                            <div class="form-group">
                                <label class="title">Tên phòng</label>
                                <input class="form-control" type="text" name="name" value="<?=$name?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-30">
                            <div class="form-group">
                                <label class="title">Rạp</label>
                                <select class="form-control select2" name="rap_id" disabled style="width: 100%;">
                                    <option value="">Chọn rạp</option>
                                    <?php
                                    foreach($rap_list as $rap) {
                                        $selected = ($rap['id'] == $rap_id) ? 'selected' : '';
                                        echo "<option value='{$rap['id']}' {$selected}>{$rap['tenrap']}</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="rap_id" value="<?= $rap_id ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-30">
                            <div class="form-group">
                                <label class="title">Số hàng</label>
                                <input class="form-control" type="number" name="so_hang" value="<?=$so_hang?>" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-30">
                            <div class="form-group">
                                <label class="title">Số cột (ghế mỗi hàng)</label>
                                <input class="form-control" type="number" name="so_cot" value="<?=$so_cot?>" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-30">
                            <button class="button button-outline button-primary" type="submit" name="capnhat">
                                Cập nhật
                            </button>
                        </div>
                    </div>

                    <?php if(isset($error) && $error != ""): ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="alert alert-danger">
                                    <?php echo $error; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom CSS để làm đẹp form */
.box {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.box-head {
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-control {
    height: 45px;
    border-radius: 5px;
    border: 1px solid #ddd;
    width: 100%;
    padding: 8px 15px;
}

.form-control:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 5px rgba(76,175,80,0.2);
}

select.form-control {
    width: 100% !important;
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1em;
}

.button {
    padding: 12px 25px;
    font-size: 14px;
    font-weight: 600;
}

.alert {
    padding: 15px;
    border-radius: 5px;
    margin-top: 20px;
}

.alert-danger {
    background-color: #fff3f3;
    color: #dc3545;
    border: 1px solid #ffcdd2;
}
</style>