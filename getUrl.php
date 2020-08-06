<?php
include 'connect.php';

$bucketname = $_GET['bucketname'];
$key = $_GET['key'];

// $plans_url = $Connection->get_object_url($bucketname, $key);
// echo $plans_url . "<br>";
$secret_url = $Connection->get_object_url($bucketname, $key, '3 hour');
echo $secret_url . "<br>";