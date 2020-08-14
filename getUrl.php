<?php
include 'connect.php';
include 'header.php';

$bucketname = $_GET['bucketname'];
$key = $_GET['key'];
echo $Connection->get_object_url($bucketname, $key);
echo $Connection->get_object_url($bucketname, $key, '3 hour');
