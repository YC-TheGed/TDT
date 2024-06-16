<?php
//👋
require_once 'aweber_api/aweber_api.php';

// Get email from the client
$email = $_POST['email'];

// Aweber API Credentials
$consumerKey = 'o99QrHIckb8g78oKwynxOwCsETvNVOc2';
$consumerSecret = 'rn1b96dQayCsUIKvjbJXwhI4FXFLXjFP';
$acessToken = AwberAPI::getDataFromAweberID($consumerKey, $consumerSecret);

//Create an Aweber API Object
$aweber = new AweberAPI($acessToken['access_token'], $acessToken['access_token_secret']);

//Store email to the list👋
$account = $aweber -> getAccount();
$list = $account -> loadFromUrl('/account/' . $account->entries[0]->id. '/list/awlist6721092');
$subscriber = $list->subscribers->create(array(
    'email' => $email;
));

if ($subscriber->status === 'success'){
    echo 'Success! Email address added to the list!';
} else {
    echo 'Error: ' . $subscriber->message;
}