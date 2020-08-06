<form action="index.php" method="get">
<input type="text" name="bucketname" value="">
<input type="submit" value="create new bucket">
</form>
<?php
include 'connect.php';

$bucketname = @$_GET['bucketname'];
if($bucketname){
	// $ret = $Connection->create_bucket($bucketname, 's3-soho1-fat');
}

// 获取bucket名称
$ListResponse = $Connection->list_buckets();
$Buckets = $ListResponse->body->Buckets->Bucket;

echo '<table>';
foreach ($Buckets as $Bucket) {
	echo '<tr>';
	echo '<td><a href="listBucket.php?bucketname='.$Bucket->Name.'">'.$Bucket->Name.'</a></td>';
	echo '<td>'.$Bucket->CreationDate.'</td>';
	echo '</tr>';
}
echo '</table>';