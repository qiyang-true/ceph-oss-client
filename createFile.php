<?php
require 'connect.php';
include 'header.php';
if (@$_GET['bucketname']) { ?>
<form action="createFile.php" method="post">
bucket：<input type="text" name="bucketname" value="<?php echo $_GET['bucketname'];?>" readonly><br>
文件名：<input type="text" name="filename" value="<?php echo date('Y-m-d-H-i-s').'.txt';?>"><br>
内容：<br>
<textarea rows="30" cols="50" name="content">This is content.</textarea>
<input type="submit" value="create">
</form>
<?php } ?>
<?php
$bucketname = @$_POST['bucketname'];
$filename = @$_POST['filename'];
$content = @$_POST['content'];

if ($bucketname and $filename and $content){
	$ret = $Connection->create_object($bucketname, $filename, array(
		'body' => $content,
	));
	echo '<pre>';
	var_dump($ret);
	echo '</pre>';
	header("location: /listBucket.php?bucketname=".$bucketname);
}