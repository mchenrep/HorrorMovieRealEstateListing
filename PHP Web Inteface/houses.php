<?php
include 'db.php';

header("Content-Type: application/json");

// Get query parameters, set defaults if empty
$minPrice = isset($_GET['minPrice']) && $_GET['minPrice'] !== '' ? (int)$_GET['minPrice'] : 0;
$maxPrice = isset($_GET['maxPrice']) && $_GET['maxPrice'] !== '' ? (int)$_GET['maxPrice'] : 999999999;
$bedrooms = isset($_GET['bedrooms']) && $_GET['bedrooms'] !== '' ? (int)$_GET['bedrooms'] : null;
$bathrooms = isset($_GET['bathrooms']) && $_GET['bathrooms'] !== '' ? (int)$_GET['bathrooms'] : null;

// Base SQL query using Listings
$sql = "SELECT l.mlsNumber, l.dateListed, p.address, p.ownerName, p.price,
               h.bedrooms, h.bathrooms, h.size,
               a.name AS agentName, a.phone AS agentPhone, f.name AS firmName
        FROM Listings l
        JOIN Property p ON l.address = p.address
        JOIN House h ON l.address = h.address
        JOIN Agent a ON l.agentId = a.agentId
        JOIN Firm f ON a.firmId = f.id
        WHERE p.price BETWEEN $minPrice AND $maxPrice";

// Optional filters
if ($bedrooms !== null) {
    $sql .= " AND h.bedrooms = $bedrooms";
}

if ($bathrooms !== null) {
    $sql .= " AND h.bathrooms = $bathrooms";
}

// Execute query
$result = $conn->query($sql);

$houses = [];
while ($row = $result->fetch_assoc()) {
    $houses[] = $row;
}

echo json_encode($houses);
$conn->close();
?>
