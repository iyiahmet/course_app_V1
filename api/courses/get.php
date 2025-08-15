<?php
require_once "../../config/db.php";
require "../../helpers/response.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
$db = get_db();

$data = json_decode(file_get_contents("php://input"));
$query = $db->query("select * from courses")->fetchAll();

sendjson(["all_courses" => $query, "message" => "api başarılı"], 200);
