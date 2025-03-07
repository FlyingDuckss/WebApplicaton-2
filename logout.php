<?php
/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    Depreceated file
*/
session_start();
session_unset();
session_destroy();
header("Location: logout.htm");
exit;
?>
