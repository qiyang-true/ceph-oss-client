<?php
include 'connect.php';
include 'header.php';

$bucketname = $_GET['bucketname'];
$key = $_GET['key'];
if ($bucketname and $key){
	$ret = $Connection->delete_object($bucketname, $key);
	if ($ret->status == 204 ){
		header("location: ".$_SERVER["HTTP_REFERER"]);
	}else{
		echo 'delete file failed';
	}
}