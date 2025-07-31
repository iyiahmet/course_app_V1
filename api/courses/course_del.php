<?php
header("Access-Control-Allow-Origin");
// header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json");
if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
    http_response_code(405);
    echo "Method not allowed";
} else {
    include("db.php");
    $rawdata = file_get_contents('php://input');
    $data = json_decode($rawdata, true);

    if (!$data || !isset($data["id"])) {
        http_response_code(400);
        echo json_encode(array("error" => "Invalid request"));
    }
    $id = intval($data["id"]);

    $coursedel = $db->prepare("DELETE from courses where id = ?");
    $coursedel->bindParam(1, $id, PDO::PARAM_INT);

    if ($coursedel->execute()) {
        http_response_code(200);
        echo json_encode(array("message" => "Course deleted successfully", "id" => $id));
    } else {
        http_response_code(500);
        echo json_encode(array("error" => "Failed to delete course"));
    }
    $coursedel = null;
    $db = null;
}
