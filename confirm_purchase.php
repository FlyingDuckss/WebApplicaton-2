<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    confirm purchase and update the goods.xml
*/
header('Content-Type: application/json');
$goodsFilePath = '../../data/goods.xml';
if (!file_exists($goodsFilePath)) {
    echo json_encode(['status' => 'error', 'message' => 'File not found']);
    exit;
}

$xml = simplexml_load_file($goodsFilePath);
if ($xml === false) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to load goods.xml']);
    exit;
}
$cartItems = json_decode($_POST['cart'], true);
$totalAmountDue = 0;

foreach ($cartItems as $cartItem) {
    $itemNumber = $cartItem['itemNumber'];
    $quantity = $cartItem['quantity'];
    foreach ($xml->item as $item) {
        if ((string) $item->itemNumber === $itemNumber) {
            $item->quantityOnHold = intval($item->quantityOnHold) - $quantity;
            $item->quantitySold = intval($item->quantitySold) + $quantity;
            $totalAmountDue += floatval($item->price) * $quantity;
            break;
        }
    }
}

$xml->asXML($goodsFilePath);

echo json_encode(['status' => 'success', 'totalAmountDue' => $totalAmountDue]);
