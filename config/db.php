<?php
function get_db()
{
    try {
        $db = new PDO('mysql:host=mysql;dbname=course', 'root', '123456789');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Database connection failed", "detail" => $e->getMessage()]);
    }
}
