<?php
include 'connect.php';
include 'header.php';
echo $bucketname = $_GET['bucketname'];
echo $key = $_GET['key'];
echo $status = $_GET['status'];
if ($bucketname and $key and $status){
	if ($status == 'public'){
		$ret = $Connection->set_object_acl($bucketname, $key, AmazonS3::ACL_PUBLIC);
	}else if ($status == 'private'){
		$ret = $Connection->set_object_acl($bucketname, $key, AmazonS3::ACL_PRIVATE);
	}
	echo '<pre>';
	var_dump($ret);
	echo '</pre>';
}