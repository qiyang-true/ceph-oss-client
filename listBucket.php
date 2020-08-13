<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<title>后台</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
</head>
<body>
<?php
require 'connect.php';
include 'header.php';
echo "Current Bucket：".$bucketname = $_GET['bucketname'];
echo ' <a href="uploadFile.php?bucketname='.$bucketname.'">上传文件</a> <a href="createFile.php?bucketname='.$bucketname.'">创建文件</a>';
if($bucketname){
	$ObjectsListResponse = $Connection->list_objects($bucketname);
	$Objects = $ObjectsListResponse->body->Contents;
	echo '<table>';
	echo '<tr>';
	echo '<th>num</th>';
	echo '<th>Bucket</th>';
	echo '<th>size</th>';
	echo '<th>create time</th>';
	echo '<th></th>';
	echo '</tr>';
	$i = 0;
	foreach ($Objects as $Object) {
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$Object->Key.'</td>';
		echo '<td>'.$Object->Size.'</td>';
		echo '<td>'.$Object->LastModified.'</td>';
		echo '<td><a href="download.php?bucketname='.$bucketname.'&key='.$Object->Key.'">下载</a></td>';
		echo '<td><a href="getUrl.php?bucketname='.$bucketname.'&key='.$Object->Key.'">获取地址</a></td>';
		if($url = getImageUrl($Connection, $bucketname, $Object->Key)){
			echo '<td><img style="max-width:20px;max-height:20px;" class="img" src="'.$url.'"></td>';
		}else{
			echo '<td></td>';
		}
		echo '<td><a href="setACL.php?bucketname='.$bucketname.'&key='.$Object->Key.'&status=public">设置为共有</a></td>';
		echo '<td><a href="setACL.php?bucketname='.$bucketname.'&key='.$Object->Key.'&status=private">设置为私有</a></td>';
		echo '<td><a href="deleteObject.php?bucketname='.$bucketname.'&key='.$Object->Key.'">删除</a></td>';
		echo '</tr>';
		$i++;
	}
	echo '</table>';
}


/*
* 判断是否是图片
*/
function getImageUrl($Connection, $bucketname, $key){
	$url = $Connection->get_object_url($bucketname, $key, '3 hour');
	$ext = substr($url, strrpos($url, '.')+1, 3);
	$ext = strtolower($ext);
	if(in_array($ext, ['jpg','png','bmp','jpe'])){
		return $url;
	}else{
		return false;
	}
}
?>
<script src="https://www.scriptjc.com/Public/js/jquery-1.8.0.min.js"></script>
<script>
//图像查看,在图片元素或图片的上一级元素上添加class="img" <img class="img">
$('.img').live("mouseover mouseout",function(event){
	if(event.type == "mouseover"){
		var img = document.createElement("img");
		img.src = $(this).children('img').prop('src') || $(this).prop('src');
		img.id = 'showimg';
		width = img.width;
		height = img.height;
		if(height > width){
			height = (height > 500) ? 500 : height;
			img.style.height = height+'px';
		}else{
			width = (width > 600)? 600 : width;
			img.style.width = width+'px';
		}
		img.style.position = 'fixed';
		img.style.left = event.clientX+30+'px';
		if(window.innerHeight-height-event.clientY < 0){
			img.style.bottom = '10px';
		}else{
			img.style.top = event.clientY+-30+'px';
		}
		document.body.appendChild(img);
	}else if(event.type == "mouseout"){
		if(img = document.getElementById('showimg')){
			img.remove();
		}
	}
});
</script>
</body>
</html>