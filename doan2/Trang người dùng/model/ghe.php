<?php



function load_ghe_by_lichchieu($id_lichchieu) {
    $sql = "SELECT g.*, p.gia_ve 
            FROM ghe g 
            JOIN lichchieu l ON g.id_lichchieu = l.id 
            JOIN phim p ON l.id_phim = p.id 
            WHERE g.id_lichchieu = ? 
            ORDER BY g.hang, g.so_ghe";
    return pdo_query($sql, $id_lichchieu);
}
