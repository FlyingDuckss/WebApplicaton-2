<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    This populates the data of items which sold quantity is gretaer than 0
*/

$xml = simplexml_load_file('/home/students/accounts/s104659862/cos80021/www/data/goods.xml');

$output = '';
$output .= '<table>';
$output .= '<thead>';
$output .= '<tr>';
$output .= '<th>Item Number</th>';
$output .= '<th>Name</th>';
$output .= '<th>Price</th>';
$output .= '<th>Quantity Available</th>';
$output .= '<th>Quantity On Hold</th>';
$output .= '<th>Quantity Sold</th>';
$output .= '</tr>';
$output .= '</thead>';
$output .= '<tbody>';

foreach ($xml->item as $item) {
    if (intval($item->quantitySold) > 0) {  
        $output .= '<tr>';
        $output .= '<td>' . $item->itemNumber . '</td>';
        $output .= '<td>' . $item->name . '</td>';
        $output .= '<td>' . $item->price . '</td>';
        $output .= '<td>' . $item->quantityAvailable . '</td>';
        $output .= '<td>' . $item->quantityOnHold . '</td>';
        $output .= '<td>' . $item->quantitySold . '</td>';
        $output .= '</tr>';
    }
}

$output .= '</tbody>';
$output .= '</table>';

echo $output;
