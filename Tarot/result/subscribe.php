<?php
header('Content-Type: application/json');
require_once 'aweber_api/aweber_api.php';

// Get email and first name from the POST data
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);

// Aweber API Credentials
$consumerKey = 'o99QrHIckb8g78oKwynxOwCsETvNVOc2';
$consumerSecret = 'rn1b96dQayCsUIKvjbJXwhI4FXFLXjFP';
$listId = 'awlist6721092';

try {
    $accessToken = AweberAPI::getDataFromAweberID($consumerKey, $consumerSecret);

    //Create an Aweber API Object
    $aweber = new AweberAPI($accessToken['access_token'], $accessToken['access_token_secret']);

    //Store email and first name to the list
    $account = $aweber->getAccount();
    $listUrl = "/accounts/{$account->id}/lists/{$listId}";
    $list = $account->loadFromUrl($listUrl);
    
    $subscriber = $list->subscribers->create([
        'email' => $email,
        'name' => $firstName
    ]);

    if ($subscriber->status == 'subscribed') {
        echo json_encode(['status' => 'success', 'message' => 'Subscriber added to the list!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $subscriber->error_message]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}