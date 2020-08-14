<?php
require 'connect.php';
include 'header.php';
header('content-type:text/html;charset=utf-8');

$bucketname = @$_POST['bucketname'];
if ($bucketname){
	$UP = $_FILES['image'];
	$ext = '.'.pathinfo($UP['name'], PATHINFO_EXTENSION);
	$newname = date('YmdHis').uniqid().rand().$ext;
	move_uploaded_file($UP['tmp_name'], $UP['tmp_name'].$ext);
	$Connection->create_object($bucketname, $newname, array(
		'fileUpload' => $UP['tmp_name'].$ext,
	));
	header("location: /listBucket.php?bucketname=".$bucketname);
}