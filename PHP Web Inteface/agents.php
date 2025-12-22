<?php
include 'db.php';

$sql = "SELECT * FROM Agent";

$result = $conn->query($sql);

$agents = [];
while ($row = $result->fetch_assoc()) {
    $agents[] = $row;
}

// Return success + data so the client can detect an empty result vs. query failure
echo json_encode($agents);
$conn->close();
?>