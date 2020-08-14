<?php
include 'header.php';
$settings = parse_ini_file('settings.ini', true);
$name = $_GET['update'] ? $_GET['update'] : 'base';

echo '<table>';
echo '<tr><td>当前配置：</td><td>base</td></tr>';
echo '<tr><td>hostname：</td><td>'.$settings['base']['hostname'].'</td></tr>';
echo '<tr><td>secret：</td><td>'.$settings['base']['secret'].'</td></tr>';
echo '<tr><td>port：</td><td>'.$settings['base']['port'].'</td></tr>';
echo '</table>';

echo '<table border="1" cellspacing="0" cellpadding="1" >';
foreach($settings as $key => $value) {
	if ($key == 'base'){
		continue;
	}
	echo '<tr>';
	echo '<td>'.$key.'</td>';
	echo '<td>'.$settings[$key]['hostname'].'</td>';
	echo '<td>'.$settings[$key]['port'].'</td>';
	echo '<td>'.$settings[$key]['key'].'</td>';
	echo '<td>'.$settings[$key]['port'].'</td>';
	echo '<td><a href="settings.php?type=choice-config&config='.$key.'">切换</a></td>';
	echo '<td><a href="settings.php?update='.$key.'">修改</a></td>';
	echo '<td><a href="settings.php?delete='.$key.'">删除</a></td>';
	echo '</tr>';
}
echo '</table>';

if ($_POST['type'] == 'add-config'){
	$conf = $_POST;
	$new_config = [
		$conf['config_name'] => [
			'key'		=> $conf['config_key'],
			'secret'	=> $conf['config_secret'],
			'hostname'	=> $conf['config_hostname'],
			'port'		=> $conf['config_port'],
		]
	];
	add_config($new_config);
	header("location: /settings.php");
}else 
if ($_GET['type'] == 'choice-config'){
	$conf = $_GET['config'];
	$config = parse_ini_file('settings.ini', true);
	$base = ['base' => $config[$conf]];
	add_config($base);
	header("location: /settings.php");
}else
if ($_GET['delete']){
	delete_config($_GET['delete']);
	header("location: /settings.php");
}


/*
* param $key string 要删除的配置段名称
*/
function delete_config($key){
	$conf = parse_ini_file('settings.ini', true);
	unset($conf[$key]);
	file_put_contents('settings.ini', convert_array_to_ini($conf));
}


/*
* param $config array 添加配置段到配置文件
*/
function add_config($config){
	$conf = parse_ini_file('settings.ini', true);
	foreach($config as $key => $value){
		$conf[$key] = $value;
	}
	$conf = convert_array_to_ini($conf);
	file_put_contents('settings.ini', $conf);
}


/*
* param $settings array 数组转ini格式的配置
* return string
*/
function convert_array_to_ini($settings){
	foreach($settings as $key => $value){
		$config .= "[".$key."]\n";
		foreach($value as $k => $v){
			$config .= $k .' = '.$v."\n";
		}
	}
	return $config;
}
?>
<br>
<table>
<form action="settings.php" method="post">
<input type="hidden" name="type" value="add-config"/>
<tr>
	<td>name:</td>
	<td><input type="text" name="config_name" value="<?php echo $name;?>"/></td>
</tr>
<tr>
	<td>key:</td>
	<td><input type="text" name="config_key" value="<?php echo $settings[$name]['key'];?>"/></td>
</tr>
<tr>
	<td>secret:</td>
	<td><input type="text" name="config_secret" value="<?php echo $settings[$name]['secret'];?>"/></td>
<tr>
	<td>hostname:</td>
	<td><input type="text" name="config_hostname" value="<?php echo $settings[$name]['hostname'];?>"/></td>
</tr>
<tr>
	<td>port:</td>
	<td><input type="text" name="config_port" value="<?php echo $settings[$name]['port'];?>"/></td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" value="添加/修改"/></td>
</tr>
</form>
</table>