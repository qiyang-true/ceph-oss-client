<?php
include 'connect.php';

$bucketname = $_GET['bucketname'];
$key = $_GET['key'];
if (!$key){
	echo 'paramter bucketname cat not empty';
	exit();
}
$pos = strrpos($key, '/');
$filename = substr($key, $pos+1);
$ret = $Connection->get_object($bucketname, $key);

header('Content-Disposition: attachment; filename='.$filename);
echo $ret->body;