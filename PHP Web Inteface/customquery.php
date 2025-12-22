<?php
include 'db.php';
header("Content-Type: application/json");

$input = json_decode(file_get_contents('php://input'), true);
$sql = $input['sql'] ?? '';

if (!$sql) {
    echo json_encode(["error" => "No SQL query provided"]);
    exit;
}

$result = $conn->query($sql);
if (!$result) {
    echo json_encode(["error" => $conn->error]);
    exit;
}

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
$conn->close();
?>
