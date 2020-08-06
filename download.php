<?php
include 'connect.php';

$bucketname = $_GET['bucketname'];
$key = $_GET['key'];


$pos = strrpos($key, '/');
$filename = substr($key, $pos+1);

$FileHandle = fopen('/var/www/html/download/'.$filename, 'w+');
$Connection->get_object($bucketname, $key, array('fileDownload' => $FileHandle));

if(!file_exists('./download/'.$filename)){
	echo 'file download failer';
}else{
	header('Content-Disposition: attachment; filename='.$filename);
	readfile('./download/'.$filename);
	unlink('./download/'.$filename);
}
