<?php
require 'connect.php';
include 'header.php';
?>
<form action="index.php" method="post">
<input type="text" name="bucketname" value="">
<input type="submit" value="create new bucket">
</form>
<?php
$bucketname = @$_POST['bucketname'];
if($bucketname){
	$ret = $Connection->create_bucket($bucketname, '');
	header("location: /index.php");
}

$ListResponse = $Connection->list_buckets();
$Buckets = $ListResponse->body->Buckets->Bucket;
if (!$Buckets){
	echo 'ERROR: The bucket is empty, please check the configuration.';
	exit();
}

echo '<table>';
echo '<tr>';
echo '<th>Bucket</th>';
echo '<th>Create time</th>';
echo '<th>Action</th>';
echo '</tr>';
foreach ($Buckets as $Bucket) {
	echo '<tr>';
	echo '<td><a href="listBucket.php?bucketname='.$Bucket->Name.'">'.$Bucket->Name.'</a></td>';
	echo '<td>'.$Bucket->CreationDate.'</td>';
	echo '<td><a href="deleteBucket.php?bucketname='.$Bucket->Name.'">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<a href="deleteBucket.php?bucketname='.$Bucket->Name.'&force=true">强制删除</a></td>';
	echo '</tr>';
}
echo '</table>';