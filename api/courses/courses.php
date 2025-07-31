<?php
include "db.php";
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");



$sql = "SELECT * FROM courses";

$query = $db->query($sql);
$result = array();

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
}
echo json_encode($result);
