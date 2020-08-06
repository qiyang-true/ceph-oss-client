<?php
include 'connect.php';
header('content-type:text/html;charset=utf-8');
echo $bucketname = $_GET['bucketname'];

if($bucketname){
	$ObjectsListResponse = $Connection->list_objects($bucketname);
	$Objects = $ObjectsListResponse->body->Contents;
	echo '<table>';
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
			echo '<td><img style="max-width:20px;max-height:20px;" src="'.$url.'"></td>';
		}else{
			echo '<td></td>';
		}
		echo '</tr>';
		$i++;
	}
	echo '</table>';
}




// 判断是否是图片
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