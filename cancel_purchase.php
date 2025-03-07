<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    update the data on goods.xml if the customer cancels the purchase
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

foreach ($cartItems as $cartItem) {
    $itemNumber = $cartItem['itemNumber'];
    $quantity = $cartItem['quantity'];
    
    foreach ($xml->item as $item) {
        if ((string) $item->itemNumber === $itemNumber) {
            $item->quantityOnHold = intval($item->quantityOnHold) - $quantity;
            $item->quantityAvailable = intval($item->quantityAvailable) + $quantity;
            break;
        }
    }
}

$xml->asXML($goodsFilePath);

echo json_encode(['status' => 'success']);
