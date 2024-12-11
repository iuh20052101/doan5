<?php
/**
 * Mở kết nối đến CSDL sử dụng PDO
 */
function pdo_get_connection(){
    $dburl = "mysql:host=localhost;dbname=tiam;charset=utf8";
    $username = 'root';
    $password = '';

    $conn = new PDO($dburl, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}

function pdo_query_one($sql){
    $sql_args = array_slice(func_get_args(), 1);
    try{
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    catch(PDOException $e){
        throw $e;

    }
    finally{
        unset($conn);
    }
}

// Khai báo biến global $conn
global $conn;
$conn = pdo_get_connection();

// Thêm các hàm xử lý transaction
function pdo_begin_transaction() {
    global $conn;
    if ($conn === null) {
        $conn = pdo_get_connection();
    }
    $conn->beginTransaction();
}

function pdo_commit() {
    global $conn;
    if ($conn !== null) {
        $conn->commit();
    }
}

function pdo_rollback() {
    global $conn;
    if ($conn !== null) {
        $conn->rollBack();
    }
}

// Các hàm pdo_execute, pdo_query... giữ nguyên
function pdo_execute($sql) {
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        return true;
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}

function pdo_query($sql){
    $sql_args = array_slice(func_get_args(), 1);
    try{
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $rows = $stmt->fetchAll();
        return $rows;
    }
    catch(PDOException $e){
        throw $e;
    }
    finally{
        unset($conn);
    }
}
function deleteExpiredPromotions() {
    try {
        $conn = pdo_get_connection();
        $today = date('Y-m-d');
        $sql = "DELETE FROM khuyen_mai WHERE ngay_ket_thuc < :today";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':today', $today);
        $stmt->execute();
        return $stmt->rowCount(); // Trả về số record đã xóa
    } catch(PDOException $e) {
        error_log("Lỗi xóa khuyến mãi hết hạn: " . $e->getMessage());
        return false;
    }
}



?>