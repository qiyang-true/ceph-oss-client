<?php
require 'connect.php';
include 'header.php';

$bucketname = @$_GET['bucketname'];
$force = @$_GET['force'];

if ($bucketname and $force == 'true'){
	$ret = $Connection->delete_bucket($bucketname, 1);
}else if ($bucketname){
	$ret = $Connection->delete_bucket($bucketname);
}else{
	echo 'no parameter';
}
if ($ret->status < 300){
	echo '<b>删除成功</b>';
}else{
	echo '<b>删除失败，bucket not empty.</b>';
}
echo '<pre>';
var_dump($ret);
echo '</pre>';