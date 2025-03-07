<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    Remove the hold goods from goods.xml
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

$itemNumber = $_POST['itemNumber'];
if (!$itemNumber) {
    echo json_encode(['status' => 'error', 'message' => 'Item number is missing']);
    exit;
}

foreach ($xml->item as $item) {
    if ((string) $item->itemNumber === $itemNumber) {
        $item->quantityOnHold = max(0, intval($item->quantityOnHold) - 1);
        $item->quantityAvailable = intval($item->quantityAvailable) + 1;
        $xml->asXML($goodsFilePath);
        echo json_encode(['status' => 'success']);
        exit;
    }
}
echo json_encode(['status' => 'error', 'message' => 'Item not found']);
?>
