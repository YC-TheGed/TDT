<?php
header('Content-Type: application/json');

// Get email and first name from the POST data
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);

// HubSpot API Credentials
$access_token = 'pat-na1-0f82d7e1-1c51-454a-939a-86e84dce50f7';
$hubspot_api_url = 'https://api.hubapi.com/crm/v3/objects/contacts';

// Prepare the contact properties
$properties = [
    'email' => $email,
    'firstname' => $firstName
];

// Prepare the request data
$request_body = json_encode([
    'properties' => $properties
]);

// Set up cURL request
$ch = curl_init($hubspot_api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);

// Execute the request
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Check the response
if ($http_code == 201) {
    echo json_encode(['status' => 'success', 'message' => 'Contact added to HubSpot!']);
} else {
    $error_message = json_decode($response, true);
    echo json_encode(['status' => 'error', 'message' => $error_message['message'] ?? 'Failed to add contact']);
}
