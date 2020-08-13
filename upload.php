<?php
require 'connect.php';
include 'header.php';
require 'Upload.class.php';
header('content-type:text/html;charset=utf-8');

$bucketname = @$_POST['bucketname'];
if ($bucketname){
	$upload  = new Upload('image', './temp');
	$path = './temp/'.$upload->newFileName;
	$file = file_get_contents($path);
	unlink($path);
	$Connection->create_object($bucketname, $upload->newFileName, array(
		'body' => $file,
	));
	header("location: /listBucket.php?bucketname=".$bucketname);
}