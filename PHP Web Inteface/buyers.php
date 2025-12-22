<?php
include 'db.php';

$sql = "SELECT * FROM Buyer";

$result = $conn->query($sql);

$buyers = [];
while ($row = $result->fetch_assoc()) {
    $buyers[] = $row;
}

echo json_encode($buyers);
$conn->close();
?>