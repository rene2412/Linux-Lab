<?php
// Allow cross-origin requests if needed
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Get the JSON data sent from JavaScript
$requestData = json_decode(file_get_contents('php://input'), true);

// Validate the data
if (!isset($requestData['section']) || !isset($requestData['lesson'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Load the current user data
$userDataPath = './userInfo.json';
$userData = json_decode(file_get_contents($userDataPath), true);

// Update the user data (assuming user 0 for simplicity)
$userData[0]['section'] = $requestData['section'];
$userData[0]['lesson'] = $requestData['lesson'];

// Write the updated data back to the file
if (file_put_contents($userDataPath, json_encode($userData, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'User data updated']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to write user data']);
}
?>