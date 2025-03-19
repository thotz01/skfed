<?php

require_once '../sql/sql.php';

header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method. Use POST.'
    ]);
    exit;
}


$barangay_name = $_POST['barangay_name'] ?? '';
$coordinates = $_POST['coordinates'] ?? '';

$coordinates = $_POST['coordinates'];



if (empty($barangay_name) || empty($coordinates) || !is_array(json_decode($coordinates))) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required fields.'
    ]);
    exit;
}

$coords_array = json_decode($coordinates, true);
$latitude = $_POST['latitude'] ?? '';
$longitude = $_POST['longitude'] ?? '';
$first_point = $coords_array[0];
$latitude = $first_point[0];
$longitude = $first_point[1];

$sql = "INSERT INTO barangay (barangay_name, longitude, latitude, coordinates, created_at) 
        VALUES (?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Preparation failed: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("ssss", $barangay_name, $longitude, $latitude, $coordinates);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Polygon saved successfully!'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Execution failed: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
