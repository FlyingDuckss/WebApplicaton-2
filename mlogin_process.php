<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    validate and navigate to the customer listing.htm
*/
session_start();
$managerFile = '../../data/manager.txt';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $managerId = trim($_POST['managerId']);
    $password = trim($_POST['password']);

    if (empty($managerId) || empty($password)) {
        echo "Manager ID and Password are required!";
        echo "<br><a href='mlogin.htm'>Go back to Login</a>";
        exit;
    }

    if (file_exists($managerFile)) {
        $fileContents = file($managerFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($fileContents as $line) {
            list($storedManagerName, $storedPassword) = explode(',', $line);
            $storedManagerName = trim($storedManagerName);
            $storedPassword = trim($storedPassword);

            if ($managerId === $storedManagerName && $password === $storedPassword) {
                echo "<script>
                        localStorage.setItem('managerId', '$managerId');
                        window.location.href = 'listing.htm';
                      </script>";
                exit;
            }
        }

        echo "Invalid Manager ID or Password!";
        echo "<br><a href='mlogin.htm'>Try again</a>";
    } else {
        echo "Manager credentials file not found!";
        exit;
    }
} else {
    echo "Invalid request method!";
    exit;
}
?>
