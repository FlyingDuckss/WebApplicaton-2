<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    This file will update the available quantity in goods.xml
*/
session_start();
$goodsFilePath = '/home/students/accounts/s104659862/cos80021/www/data/goods.xml';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $itemNumber = $_POST['itemNumber'] ?? null;
    $quantity = intval($_POST['quantity'] ?? 0);
    if (file_exists($goodsFilePath)) {
        $xml = simplexml_load_file($goodsFilePath);
        foreach ($xml->item as $item) {
            if ((string)$item->itemNumber == $itemNumber) {
                if ($action == 'add') {
                    $quantityAvailable = intval($item->quantityAvailable);
                    if ($quantityAvailable >= $quantity) {
                        $item->quantityAvailable = $quantityAvailable - $quantity;
                        $item->quantityOnHold = intval($item->quantityOnHold) + $quantity;
                    }
                }
            }
        }

        if ($action == 'clear') {
            foreach ($xml->item as $item) {
                $quantityOnHold = intval($item->quantityOnHold);
                if ($quantityOnHold > 0) {
                    $item->quantityAvailable = intval($item->quantityAvailable) + $quantityOnHold;
                    $item->quantityOnHold = 0;
                }
            }
        }
        $xml->asXML($goodsFilePath);
        echo "Success";
    } else {
        echo "Goods data not found!";
        exit;
    }
} else {
    echo "Invalid request method!";
    exit;
}
?>
