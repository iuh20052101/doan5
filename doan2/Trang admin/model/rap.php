
<?php
function load_rap(){
    $sql = "select * from rap where 1";
    $re = pdo_query($sql);
    return $re;

}
function loadone_rap($id){
    $sql = "select * from rap where id=".$id;
    $re = pdo_query_one($sql);
    return $re;

}
function xoa_rap($id)
{
    $sql = "delete from rap where id=" . $id;
    pdo_execute($sql);
}

function update_rap($id,$tenrap,$diachi,$sdt,$email_rap){
    $sql = "update rap set `tenrap`='{$tenrap}',`diachi`='{$diachi}',`sdt`='{$sdt}',`email_rap`='{$email_rap}' where `id`=". $id;
    pdo_execute($sql);
}
function them_rap($tenrap,$diachi,$sdt,$email_rap){
    $sql = "insert into `rap`(`tenrap`,`diachi`,`sdt`,`email_rap`) values ('$tenrap','$diachi','$sdt','$email_rap') ";
    pdo_execute($sql);
}
function loadall_rap($rap_id = 0) {
    $sql = "SELECT rap.id, rap.tenrap, rap.diachi, rap.sdt, rap.email_rap FROM rap";
    
    if ($rap_id != 0) {
        $sql .= " WHERE rap.id = ?";
        return pdo_query($sql, $rap_id);
    }

    return pdo_query($sql);
}