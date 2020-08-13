<?php include 'header.php';?>
<form action="upload.php" enctype="multipart/form-data" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
	<input type="hidden" name="bucketname" value="<?php if($_GET['bucketname']){echo $_GET['bucketname'];}?>">
	<input type="file" name="image" />
	<input type="submit" />
</form>