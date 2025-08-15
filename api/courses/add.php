<?php
require_once "../../config/db.php";
require_once "../../helpers/response.php";
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$data = json_decode(file_get_contents("php://input"));

$db = get_db();
$add = $db->prepare("INSERT INTO courses (course_name) VALUES (:course_name)");
$exec = $add->execute(array(
    ':course_name' => $data->courseName
));
if ($exec) {
    sendjson(["message" => "Successfuly added course"]);
} else {
    sendjson(["error" => "Failed to add course"], 400);
}
