<?php
//存储数据的文件
$filename = 'sinetxt-xiwangly.txt';
if(!file_exists($filename)){
	die($filename.'数据文件不存在');
}
else{
	//读取资源文件
	$giturlArr = @file($filename);
}
$giturlData = [];
//将资源文件写入数组
foreach($giturlArr as $key => $value){
	$value = trim($value);
	if(!empty($value)){
		$giturlData[] = trim($value);
	}
}
$randKey = rand(0,count($giturlData));
$imgurl = 'https://tva1.sinaimg.cn/large/'.$giturlData[$randKey];
//json格式
$returnType = $_REQUEST['return'];
switch($returnType){
	//浏览器直接输出图片
	case 'img':
		$img = @file_get_contents($imgurl,true);
		header('Content-Type: image/jpeg;');
		echo($img);
		break;
	//随机JSON输出10张图片
	case 'jsonpro':
		$randKeys = array_rand($giturlData,10);
		$imgurls = [];
		foreach ($randKeys as $key) {
			$imgurls[] = 'https://tva1.sinaimg.cn/large/'.$giturlData[$key];
		}
		header('Content-type:text/json');
		$json['imgurls'] = $imgurls;
		echo(json_encode($json,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
		break;
	//JSON格式输出
	case 'json':
		$json['code'] = '200';
		$json['imgurl'] = $imgurl;
		$imageInfo = getimagesize($imgurl);
		$json['width'] = "$imageInfo[0]";
		$json['height'] = "$imageInfo[1]";
		$json['mime'] = "$imageInfo[mime]";
		header('Content-type:text/json');
		echo(json_encode($json,JSON_UNESCAPED_SLASHES));
		break;
		//直接跳转
	default:
		header('Location:' . $imgurl);
		break;
}
?>
