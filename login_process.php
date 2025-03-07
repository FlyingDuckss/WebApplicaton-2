<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    validate , process and navigate to buying.htm
*/

session_start();
$customerFile = '/home/students/accounts/s104659862/cos80021/www/data/customer.xml';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if (empty($email) || empty($password)) {
        echo "Email and password are required!";
        echo "<br><a href='login.htm'>Go back to Login</a>";
        exit;
    }
    if (file_exists($customerFile)) {
        $xml = simplexml_load_file($customerFile);
        foreach ($xml->customer as $customer) {
            if ((string)$customer->email == $email && (string)$customer->password == $password) {
                $_SESSION['customerId'] = (string)$customer->id;

                echo "<script>localStorage.setItem('customerId', '{$customer->id}'); window.location.href='buying.htm';</script>";
                exit;
            }
        }

        echo "Invalid email or password!";
        echo "<br><a href='login.htm'>Try again</a>";
    } else {
        echo "Customer data not found!";
        exit;
    }
} else {
    echo "Invalid request method!";
    exit;
}
?>
