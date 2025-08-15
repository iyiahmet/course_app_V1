<?php
require_once "../../config/db.php";
require_once "../../helpers/response.php";

header("Access-Control-Allow-Origin");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json");
if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
    http_response_code(405);
    echo "Method not allowed";
} else {
    $rawdata = file_get_contents('php://input');
    $data = json_decode($rawdata, true);

    if (!$data || !isset($data["id"])) {
        http_response_code(400);
        echo json_encode(array("error" => "Invalid request"));
    }
    $id = intval($data["id"]);
    $db = get_db();
    $coursedel = $db->prepare("DELETE from courses where id = ?");
    $coursedel->bindParam(1, $id, PDO::PARAM_INT);

    if ($coursedel->execute()) {
        http_response_code(200);
        sendjson(array("message" => "Course deleted successfully", "id" => $id));
    } else {
        http_response_code(500);
        sendjson(array("error" => "Failed to delete course"));
    }
}
