<?php
require_once 'pdo.php';

function loadall_taikhoan() {
    $sql = "SELECT 
    t.id, 
    t.name, 
    IFNULL(COUNT(ve.id), 0) AS so_ve, 
    t.user, 
    t.pass, 
    t.email, 
    t.phone, 
    t.dia_chi, 
    t.vai_tro
FROM 
    taikhoan t
LEFT JOIN 
    ve ON ve.id_tk = t.id AND ve.trang_thai IN (1, 2, 4)
WHERE 
    t.vai_tro = 0
GROUP BY 
    t.id, t.name, t.user, t.pass, t.email, t.phone, t.dia_chi, t.vai_tro
ORDER BY 
    t.id DESC;

;
";

    $re = pdo_query($sql);
    return $re;
}


function check_tk($user, $pass) {
    $sql = "SELECT * FROM taikhoan WHERE user=? AND pass=?";
    return pdo_query_one($sql, $user, $pass);
}
function dang_xuat(){
    unset($_SESSION['user']);
}

function insert_taikhoan($email,$user,$pass,$name,$sdt,$dc, $rap_id){
    $sql="INSERT INTO `taikhoan` ( `email`, `user`, `pass`,`dia_chi`,`phone`,`name`,`vai_tro`, `rap_id`) VALUES ( '$email', '$user','$pass','$dc','$sdt','$name','1','$rap_id'); ";
    pdo_execute($sql);
}

function sua_tk($id,$name,$user,$pass,$email,$sdt,$dc){
    $sql = "update taikhoan set name ='".$name."', user ='".$user."',pass ='".$pass."',email ='".$email."',phone ='".$sdt."',dia_chi ='".$dc."' where id=".$id;

    pdo_execute($sql);
}
function xoa_tk($id)
{
    $sql = "delete from taikhoan where id=" . $id;
    pdo_execute($sql);
}
function loadone_taikhoan($id){
    $sql = "select * from taikhoan where id =".$id;
    $result = pdo_query_one($sql);
    return $result;
}
function loadall_taikhoan_nv($id_rap = 0) {
    try {
        $sql = "SELECT DISTINCT t.id, t.name, t.user, t.pass, t.email, t.phone, t.dia_chi, t.vai_tro, r.tenrap
                FROM taikhoan t
                LEFT JOIN lichlamviec llv ON t.id = llv.id_taikhoan
                LEFT JOIN rap r ON llv.id_rap = r.id 
                WHERE t.vai_tro = 1";
        
        $params = [];
        if ($id_rap > 0) {
            $sql .= " AND llv.id_rap = ?";
            $params[] = $id_rap;
        }
        
        $sql .= " ORDER BY t.name";
        
        $result = pdo_query($sql, ...$params);
        return $result ? $result : [];
        
    } catch (Exception $e) {
        error_log("Error in loadall_taikhoan_nv: " . $e->getMessage());
        return [];
    }
}

function load_all_rap() {
    $sql = "SELECT DISTINCT r.* FROM rap r ORDER BY r.tenrap";
    return pdo_query($sql);
}