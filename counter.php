<?php
// Simple tracker to log clicks
$ip = $_SERVER['REMOTE_ADDR'];
$time = date("Y-m-d H:i:s");
$upi = isset($_POST['upi']) ? $_POST['upi'] : 'none';

$log = "Time: $time | IP: $ip | UPI: $upi" . PHP_EOL;

// This saves the log to a file named log.txt in your folder
file_put_contents("log.txt", $log, FILE_APPEND);

echo "success";
?>