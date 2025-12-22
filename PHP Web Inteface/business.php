<?php
include 'db.php';

header("Content-Type: application/json");

// Get query parameters with defaults
$minPrice = isset($_GET['minPrice']) && $_GET['minPrice'] !== '' ? (int)$_GET['minPrice'] : 0;
$maxPrice = isset($_GET['maxPrice']) && $_GET['maxPrice'] !== '' ? (int)$_GET['maxPrice'] : 999999999;

$minSize = isset($_GET['minSize']) && $_GET['minSize'] !== '' ? (int)$_GET['minSize'] : 0;
$maxSize = isset($_GET['maxSize']) && $_GET['maxSize'] !== '' ? (int)$_GET['maxSize'] : 999999999;

$type = isset($_GET['type']) && $_GET['type'] !== '' ? $_GET['type'] : null;

// Base SQL using Listings
$sql = "SELECT l.mlsNumber, l.dateListed, p.address, p.ownerName, p.price,
               b.type, b.size,
               a.name AS agentName, a.phone AS agentPhone, f.name AS firmName
        FROM Listings l
        JOIN Property p ON l.address = p.address
        JOIN BusinessProperty b ON l.address = b.address
        JOIN Agent a ON l.agentId = a.agentId
        JOIN Firm f ON a.firmId = f.id
        WHERE p.price BETWEEN $minPrice AND $maxPrice
          AND b.size BETWEEN $minSize AND $maxSize";

// Optional filter: type
if ($type !== null) {
    $safeType = $conn->real_escape_string($type);
    $sql .= " AND b.type = '$safeType'";
}

// Run query
$result = $conn->query($sql);

$business = [];
while ($row = $result->fetch_assoc()) {
    $business[] = $row;
}

echo json_encode($business);
$conn->close();
?>
