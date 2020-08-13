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

// 获取bucket名称
$ListResponse = $Connection->list_buckets();
$Buckets = $ListResponse->body->Buckets->Bucket;

echo '<table>';
echo '<tr>';
echo '<th>Bucket</th>';
echo '<th>create time</th>';
echo '<th></th>';
echo '</tr>';
foreach ($Buckets as $Bucket) {
	echo '<tr>';
	echo '<td><a href="listBucket.php?bucketname='.$Bucket->Name.'">'.$Bucket->Name.'</a></td>';
	echo '<td>'.$Bucket->CreationDate.'</td>';
	echo '<td><a href="uploadFile.php?bucketname='.$Bucket->Name.'">上传文件</a></td>';
	echo '<td><a href="createFile.php?bucketname='.$Bucket->Name.'">创建文件</a></td>';
	echo '<td><a href="deleteBucket.php?bucketname='.$Bucket->Name.'">删除</a></td>';
	echo '<td><a href="deleteBucket.php?bucketname='.$Bucket->Name.'&force=true">强制删除</a></td>';
	echo '</tr>';
}
echo '</table>';