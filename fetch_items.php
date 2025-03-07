<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    fetch data groom goods.xml and popoulate in table
*/

$goodsFilePath = '../../data/goods.xml';

if (!file_exists($goodsFilePath)) {
    echo "<p>Error: The goods.xml file does not exist.</p>";
    exit;
}

$xml = simplexml_load_file($goodsFilePath);
if ($xml === false) {
    echo "<p>Error: Failed to load goods.xml.</p>";
    exit;
}

$output = '';
foreach ($xml->item as $item) {
    $itemNumber = htmlspecialchars($item->itemNumber);
    $itemName = htmlspecialchars($item->name);
    $description = htmlspecialchars($item->description);
    $price = htmlspecialchars($item->price);
    $quantityAvailable = intval($item->quantityAvailable);

    if ($quantityAvailable > 0) {
        $output .= "
        <tr>
            <td>{$itemNumber}</td>
            <td>{$itemName}</td>
            <td>{$description}</td>
            <td>\${$price}</td>
            <td>{$quantityAvailable}</td>
            <td><button onclick=\"addToCart('{$itemNumber}', '{$itemName}', 1, {$price})\">Add to Cart</button></td>
        </tr>
        ";
    }
    
}
echo $output;
?>
