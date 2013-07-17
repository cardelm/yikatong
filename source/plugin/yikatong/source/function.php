<?php

//这是为了杜绝不小心覆盖文件而专门用于github同步的程序
//实际操作过程中，因为github的pro中的文件夹与本地的wordpress、discuz文件夹名称相同，有几次将文件覆盖错，故以下代码为配合github专用，目的就是修改github中的代码，同时自动更新本地的代码，达到调试的作用
$this_dir = dirname(__FILE__);
//var_dump($this_dir);
if ($this_dir == 'C:\wamp\www\discuzdemo\dz3gbk\source\plugin\yikatong'){
	$source_dir = 'C:\GitHub\yikatong';
	define('SERVER_URL', 'http://localhost/discuzdemo/dz3gbk/');
	check_dz_update();
}elseif($this_dir == 'D:\web\wamp\www\demo\dz3gbk\source\plugin\yikatong'){
	check_homedz_update();
	define('SERVER_URL', 'http://localhost/demo/dz3gbk/');
}
//采用递归方式，自动更新discuz文件
function check_dz_update($path=''){
	clearstatcache();
	if($path=='')
		$path = 'C:\GitHub\yikatong';//本地的GitHub的discuz文件夹

	$out_path = 'C:\wamp\www\discuzdemo\dz3gbk'.str_replace("C:\GitHub\yikatong","",$path);//本地的wamp的discuz文件夹

	if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {

			if ($file != "." && $file != "..") {
				if (is_dir($path."/".$file)) {
					if (!is_dir($out_path."/".$file)){
						dmkdir($out_path."/".$file);
					}
					check_dz_update($path."/".$file);
				}else{
					if (filemtime($path."/".$file)  > filemtime($out_path."/".$file)){//GitHub文件修改时间大于wamp时
						file_put_contents ($out_path."/".$file,diconv(file_get_contents($path."/".$file),"UTF-8", "GBK//IGNORE"));
					}
				}
			}
		}
	}
}//func end
//采用递归方式，自动更新discuz文件
function check_homedz_update($path=''){
	clearstatcache();
	if($path=='')
		$path = 'C:\GitHub\yikatong';//本地的GitHub的discuz文件夹

	$out_path = 'D:\web\wamp\www\demo\dz3gbk'.str_replace("C:\GitHub\yikatong","",$path);//本地的wamp的discuz文件夹

	if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {

			if ($file != "." && $file != "..") {
				if (is_dir($path."/".$file)) {
					if (!is_dir($out_path."/".$file)){
						dmkdir($out_path."/".$file);
					}
					check_homedz_update($path."/".$file);
				}else{
					if (filemtime($path."/".$file)  > filemtime($out_path."/".$file)){//GitHub文件修改时间大于wamp时
						file_put_contents ($out_path."/".$file,diconv(file_get_contents($path."/".$file),"UTF-8", "GBK//IGNORE"));
					}
				}
			}
		}
	}
}//func end
/////////以上部分在正式的文件中，必须删除，仅在进行GitHub调试时使用///////////////

?>