<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    This save the cust info in xml
*/

$xmlFile = '/home/students/accounts/s104659862/cos80021/www/data/customer.xml';
function isEmailUnique($email, $xml) {
    foreach ($xml->customer as $customer) {
        if ($customer->email == $email) {
            return false;
        }
    }
    return true;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    if (empty($email) || empty($firstName) || empty($lastName) || empty($password) || empty($phone)) {
        echo "All fields are required!";
        exit;
    }
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
    } else {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><customers></customers>');
    }
    if (!isEmailUnique($email, $xml)) {
        echo "Email already exists! Please use a different email.";
        exit;
    }
    $newCustomerId = 'C' . str_pad(count($xml->customer) + 1, 4, '0', STR_PAD_LEFT);
    $newCustomer = $xml->addChild('customer');
    $newCustomer->addChild('id', $newCustomerId);
    $newCustomer->addChild('firstName', htmlspecialchars($firstName));
    $newCustomer->addChild('lastName', htmlspecialchars($lastName));
    $newCustomer->addChild('email', htmlspecialchars($email));
    $newCustomer->addChild('password', htmlspecialchars($password));
    $newCustomer->addChild('phone', htmlspecialchars($phone));

    // Save updated XML back to file
    if ($xml->asXML($xmlFile) === false) {
        echo "Error: Unable to save customer data.";
        exit;
    }
    // Success message
    echo "Registration successful! Your customer ID is: $newCustomerId";
    echo "<br><a href='buyonline.htm'>Back to Home</a>";
} else {
    echo "Invalid request method!";
}
?>
