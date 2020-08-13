<?php
include 'connect.php';
include 'header.php';

echo $bucketname = $_GET['bucketname'];
echo $key = $_GET['key'];
if ($bucketname and $key){
	$ret = $Connection->delete_object($bucketname, $key);
	echo '<pre>';
	var_dump($ret);
	echo '</pre>';
}