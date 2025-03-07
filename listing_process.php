<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    
*/
session_start();

$goodsFilePath = '../../data/goods.xml';

if (!file_exists($goodsFilePath)) {
    $emptyXml = '<?xml version="1.0" encoding="UTF-8"?><goods></goods>';
    file_put_contents($goodsFilePath, $emptyXml);
    chmod($goodsFilePath, 0644); // Set permissions to make the file readable by all
}

$xml = simplexml_load_file($goodsFilePath);
$itemName = trim($_POST['itemName']);
$unitPrice = trim($_POST['unitPrice']);
$quantityAvailable = trim($_POST['quantityAvailable']);
$description = trim($_POST['description']);

if (empty($itemName) || empty($unitPrice) || empty($quantityAvailable) || empty($description)) {
    echo "All fields are required!";
    exit;
}
$itemNumber = 'ITM' . time() . rand(100, 999);
$newItem = $xml->addChild('item');
$newItem->addChild('itemNumber', $itemNumber);
$newItem->addChild('name', htmlspecialchars($itemName));
$newItem->addChild('description', htmlspecialchars($description));
$newItem->addChild('price', number_format((float)$unitPrice, 2, '.', ''));
$newItem->addChild('quantityAvailable', intval($quantityAvailable));
$newItem->addChild('quantityOnHold', 0);
$newItem->addChild('quantitySold', 0);
$xml->asXML($goodsFilePath);

echo "The item has been listed in the system, and the item number is: " . $itemNumber;
echo "<br><a href='listing.htm'>Add another item</a>";
?>

<br><a href="#" id="logoutLink">Logout</a>

<script>
    document.getElementById('logoutLink').addEventListener('click', function(e) {
        e.preventDefault();
        const managerId = localStorage.getItem('managerId');
        if (managerId) {
            window.location.href = `logout.php?managerId=${encodeURIComponent(managerId)}`;
        } else {
            window.location.href = 'logout.php';
        }
    });
</script>
