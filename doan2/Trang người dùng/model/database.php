<?php
function pdo_begin_transaction() {
    global $conn;
    $conn->beginTransaction();
}

function pdo_commit() {
    global $conn;
    $conn->commit();
}

function pdo_rollback() {
    global $conn;
    $conn->rollBack();
} 
?>