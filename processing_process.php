<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    This will update the quantity when manager phits process button
*/

session_start();

$xml = simplexml_load_file('/home/students/accounts/s104659862/cos80021/www/data/goods.xml');
foreach ($xml->item as $index => $item) {
    if (intval($item->quantitySold) > 0) {
        $item->quantitySold = 0;
        if (intval($item->quantityAvailable) == 0 && intval($item->quantityOnHold) == 0) {
            unset($xml->item[$index]);
        }
    }
}
$xml->asXML('/home/students/accounts/s104659862/cos80021/www/data/goods.xml');
header("Location: processing.htm");
exit;
?>
