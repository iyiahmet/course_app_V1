<?php
require_once "../../config/db.php";
require_once "../../helpers/response.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");


if ($_SERVER["REQUEST_METHOD"] != "PUT") {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed"));
    exit;
} else {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data || !isset($data['id']) || !isset($data['courseName'])) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid request"));
        exit;
    } else {
        $id = $data['id'];
        $courseName = $data['courseName'];
        $db = get_db();

        $putquery = $db->prepare("UPDATE courses SET course_name = :courseName WHERE id = :id");

        if ($putquery->execute(array(
            ":courseName" => $courseName,
            ":id" => $id
        ))) {

            http_response_code(200);
            sendjson(array("message" => "Course updated successfully"));
        }
    }
}
