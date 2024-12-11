<?php
function loadall_binhluan($id_phim = 0, $page = 1, $items_per_page = 5) {
    $start = ($page - 1) * $items_per_page;
    
    $sql = "SELECT bl.*, tk.name, p.tieu_de 
            FROM binhluan bl
            LEFT JOIN taikhoan tk ON bl.id_user = tk.id
            LEFT JOIN phim p ON bl.id_phim = p.id
            WHERE 1";
    
    if($id_phim > 0) {
        $sql .= " AND bl.id_phim = $id_phim";
    }
    
    $sql .= " ORDER BY bl.ngaybinhluan DESC LIMIT $start, $items_per_page";
    
    return pdo_query($sql);
}

function count_binhluan($id_phim = 0) {
    $sql = "SELECT COUNT(*) as total FROM binhluan WHERE 1";
    
    if($id_phim > 0) {
        $sql .= " AND id_phim = $id_phim";
    }
    
    $result = pdo_query_one($sql);
    return $result['total'];
}

function load_all_phim() {
    $sql = "SELECT id, tieu_de FROM phim ORDER BY tieu_de";
    return pdo_query($sql);
}


 function loadall_bl(){
    if(isset($_GET['sotrang'])){
        $sotrang =$_GET['sotrang'];
    }else{
        $sotrang= 1;
    }
    $bghi = 5;
    $vitri = ($sotrang-1 )*$bghi ;
    $sql = "
        SELECT binhluan.id, binhluan.noidung, taikhoan.name, phim.tieu_de,  binhluan.ngaybinhluan FROM `binhluan` 
        LEFT JOIN taikhoan ON  taikhoan.id=binhluan.id_user
        LEFT JOIN phim ON  phim.id=binhluan.id_phim 
        WHERE phim.id limit $vitri,$bghi;
    ";
    $result =  pdo_query($sql);
    return $result;
 }
function load_binhluan($id_phim = 0){
    $sql = "select * from binhluan where 1";

     if($id_phim > 0){
        $sql .= " and id_phim = $id_phim";
     }

     $sql .= " order by id_phim desc";
    $result = pdo_query($sql);
    return $result;
}
function delete_binhluan($id){
    $sql = "delete from binhluan where id = '$id'";
    pdo_execute($sql);
}


?>