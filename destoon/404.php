<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2016 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
require 'common.inc.php';
if(strpos($_SERVER['QUERY_STRING'], '404;') !== false) {
	$DT_URL = str_replace('404;', '', $_SERVER['QUERY_STRING']);
	$DT_URL = str_replace(':80', '', $DT_URL);
}
if($DT['log_404'] && strpos($DT_URL, '/404.php') === false) {
	require DT_ROOT.'/file/config/robot.inc.php';
	$url = addslashes(dhtmlspecialchars($DT_URL));
	$refer = addslashes(dhtmlspecialchars($DT_REF));
	$time = $DT_TIME - 86400;
	$r = $db->get_one("SELECT itemid FROM {$DT_PRE}404 WHERE addtime>$time AND url='$url'");
	if(!$r) $db->query("INSERT INTO {$DT_PRE}404 (url,refer,robot,username,ip,addtime) VALUES ('$url','$refer','".get_robot()."','$_username','$DT_IP','$DT_TIME')");
}
if($DT_BOT) dhttp(404, $DT_BOT);
$head_title = '404 Not Found';
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].'404.php';
include template('404', 'message');
?>