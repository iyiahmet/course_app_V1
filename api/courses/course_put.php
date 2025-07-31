<?php
include "db.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");


if ($_SERVER["REQUEST_METHOD"] != "PUT") {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed"));
    exit;
} else {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data || !isset($data['id']) || !isset($data['new_course_name'])) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid request"));
        exit;
    } else {
        $id = $data['id'];
        $new_course_name = $data['new_course_name'];

        $putquery = $db->prepare("UPDATE courses SET course_name = :new_course_name WHERE id = :id");

        if ($putquery->execute(array(
            ":new_course_name" => $new_course_name,
            ":id" => $id
        ))) {
            $course_table = $db->prepare("SELECT * FROM courses")->fetchAll();
            http_response_code(200);
            echo json_encode(array("message" => "Course updated successfully", "course_table" => $course_table));
        }
    }
}
