<?php

/*

	Desenvolvido pela Atualstudio
	www.atualstudio.com
	
	          ##########
	       ################
	    ######          ######
	   #####              #####
	  ####         ....    ####
	 ####        ########  ####
	 ####       ########## ####
	  ####      ########## ####
	  #####       ######## ####
	   #####        ****** ####
	     ######################
	         ################		 
	
	Scripts Version 4.0
	
*/


error_reporting(1);
ini_set('error_reporting', 1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('default_charset', 'UTF-8');
date_default_timezone_set('America/Sao_Paulo');

require('private/params.php');

function getIcon($id, $type=1) {
	
	if(!file_exists("cache")) { @mkdir("cache", 0775, true); @chmod("cache", 0775); }
	if(!file_exists("cache/index.html")) { $secIndexFile = fopen("cache/index.html","w+"); @fclose($secIndexFile); }
	if(!file_exists("cache/.htaccess")) { $secHtacsFile = fopen("cache/.htaccess","w+"); @fwrite($secHtacsFile, "Options -Indexes"); @fclose($secHtacsFile); }
	
	if(empty($id)) {
		return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAIAAAD8GO2jAAAD9UlEQVRIx7VWQYgTVxj+5r2Z7WBTCMLKXJRQqgwKEkorUWKJtFuCW2UpZelhKbmsyOohUOylPYjgImmRXJSglxwUZPGwUCihLTJIuoRiIRRbpnQLAS9hC2UOCo+8eX96eJPMJJvdrpU8Hsn//nnv//7v/+f/5xlClDHNYQJwMut6Ydv26JOhHOvtpJxKyHY6IUd6b91hU3UfwNQBTAAIhV6IEMxg3OCc8b0cFkIwZnFucT7T673QAgAhgsEWx9yLoT0OpaQWeMK9VwUgkkORMUspybmV3DCeA+qT6isAc2ecdrOolWc/mL1146gW2s2cnpVrh8d8J5JEcsgjBhCDiRCMwEGAUBK+H1y57KZT9owJGSKdwupXx8pf/JrNe9m8d+L46+ULGYSgnqSeVKHSk0iK50JP7P4W/dIOkstCftZrbnkb/0TLhVbuRDomESoVKi3sGiKCUlCDPXfrnVo1+xJ5HrWOvdTBnXqnkJ8F4DX/LuQPFE7t13pvPdf6OaZIIVFI2zFG6qAHxk2uCMS4vY9JIAjEI6/72VIGQBCIqzeeVivH9ebGj1uVqg+Ac/1e2hoGgBgYBGAIUU479YiOuQ8ANzk3ebLnjL7MsZ4N+HMOwOJ8vDz9J7nJIdoeyp0GEQCdNqWUAqDU9hC9wmAMRBGVIUaSiokQ4vmAfIriOCKOY7ItI6EnZgMAAwHQP3pHnAP7Jbrpu2/v/z8U9d/HC5n79QKAlle8fjU7fNxuFufOOFq+dOHIynLUHk6fnG08LHTaRT3LF98CUL1+1G8V/Fah0y7eqmT/OweVazHSyvLh0sVWvZa7ffdPAF9+fuzxxlbx0xYAbR1A8f0Dbs4bM2IKAGFA6oWkng0B4FknsCGEwJE3052OCAIhhHDdN4QQ99f+SqcAIJ3C7Tu/63RUq0+1q41HXf9JAYANVGub1domQjGBQb3ul0rub3+Ixxvd9045AM6dPXh+/tD5+UMAvqm07611IpfnnOrXEUv3nUbxQ8fNNibnYGyUSu7pk87qzbZenps/uLzyk5N54GQeLC1mtHJpMdP4oetmG+Ur7V3iPDkH9bq/8JG7ejPWfPvdMy3cW+ssLWaKn3iNh4XLK27yVOP7rt8uYlDrmWwDulXYqVpEx2Dc4AA448pQACzLAkAzM0MrO7WQpH5YB93NhREG1B8UCwEcAKSUlmUhVDCj4lSqB0B/3KHU8Ps71iF2DBH1iRlM9RVHdFJKyV/j0N3J5PqrG8EY8UFlJNLJdgBgBqM+aYzI94izhMlgcoSKMLw6WCCKuh1jlLzpbAMQA/ftZKykHNgyOUJCSPqExiBIObxqEoESvSuciDWdMXUAY9rX938Bq9jPLO9RDfAAAAAASUVORK5CYII=';
	}
	
	$type = intval($type);
	$id = (vCode($id) == 'noicon' ? 'noicon' : intval($id));
	
	if($type == '2') {
		$ref = 'skills';
	} else {
		$ref = 'itens';
	}
	
	if(file_exists('icons/'.$ref.'/'.$id.'.png')) {
		
		return 'icons/'.$ref.'/'.$id.'.png';
		
	} else if(file_exists('cache/'.$ref.'_'.$id.'.png')) {
		
		return 'cache/'.$ref.'_'.$id.'.png';
		
	}

	if($id == 'noicon') {
		return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAIAAAD8GO2jAAAD9UlEQVRIx7VWQYgTVxj+5r2Z7WBTCMLKXJRQqgwKEkorUWKJtFuCW2UpZelhKbmsyOohUOylPYjgImmRXJSglxwUZPGwUCihLTJIuoRiIRRbpnQLAS9hC2UOCo+8eX96eJPMJJvdrpU8Hsn//nnv//7v/+f/5xlClDHNYQJwMut6Ydv26JOhHOvtpJxKyHY6IUd6b91hU3UfwNQBTAAIhV6IEMxg3OCc8b0cFkIwZnFucT7T673QAgAhgsEWx9yLoT0OpaQWeMK9VwUgkkORMUspybmV3DCeA+qT6isAc2ecdrOolWc/mL1146gW2s2cnpVrh8d8J5JEcsgjBhCDiRCMwEGAUBK+H1y57KZT9owJGSKdwupXx8pf/JrNe9m8d+L46+ULGYSgnqSeVKHSk0iK50JP7P4W/dIOkstCftZrbnkb/0TLhVbuRDomESoVKi3sGiKCUlCDPXfrnVo1+xJ5HrWOvdTBnXqnkJ8F4DX/LuQPFE7t13pvPdf6OaZIIVFI2zFG6qAHxk2uCMS4vY9JIAjEI6/72VIGQBCIqzeeVivH9ebGj1uVqg+Ac/1e2hoGgBgYBGAIUU479YiOuQ8ANzk3ebLnjL7MsZ4N+HMOwOJ8vDz9J7nJIdoeyp0GEQCdNqWUAqDU9hC9wmAMRBGVIUaSiokQ4vmAfIriOCKOY7ItI6EnZgMAAwHQP3pHnAP7Jbrpu2/v/z8U9d/HC5n79QKAlle8fjU7fNxuFufOOFq+dOHIynLUHk6fnG08LHTaRT3LF98CUL1+1G8V/Fah0y7eqmT/OweVazHSyvLh0sVWvZa7ffdPAF9+fuzxxlbx0xYAbR1A8f0Dbs4bM2IKAGFA6oWkng0B4FknsCGEwJE3052OCAIhhHDdN4QQ99f+SqcAIJ3C7Tu/63RUq0+1q41HXf9JAYANVGub1domQjGBQb3ul0rub3+Ixxvd9045AM6dPXh+/tD5+UMAvqm07611IpfnnOrXEUv3nUbxQ8fNNibnYGyUSu7pk87qzbZenps/uLzyk5N54GQeLC1mtHJpMdP4oetmG+Ur7V3iPDkH9bq/8JG7ejPWfPvdMy3cW+ssLWaKn3iNh4XLK27yVOP7rt8uYlDrmWwDulXYqVpEx2Dc4AA448pQACzLAkAzM0MrO7WQpH5YB93NhREG1B8UCwEcAKSUlmUhVDCj4lSqB0B/3KHU8Ps71iF2DBH1iRlM9RVHdFJKyV/j0N3J5PqrG8EY8UFlJNLJdgBgBqM+aYzI94izhMlgcoSKMLw6WCCKuh1jlLzpbAMQA/ftZKykHNgyOUJCSPqExiBIObxqEoESvSuciDWdMXUAY9rX938Bq9jPLO9RDfAAAAAASUVORK5CYII=';
	}
	
	if($id < 1000) {
		$variation = '1-999';
	} else {
		$idLeng = strlen($id);
		$idMult = substr($id, 0, ($idLeng-3));
		$variation = $idMult.'000-'.$idMult.'999';
	}
	
	$extractURL = 'http://dev.atualstudio.com/ucp_icons/'.$ref.'/'.$variation.'/'.$id.'.png';
	
	$result = @imagecreatefrompng($extractURL);
	if(!is_resource($result)) {
		
		unset($result);
		
		$result = @imagecreatefrompng($extractURL);
		if(!is_resource($result)) {
			
			unset($result);
			
			return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAIAAAD8GO2jAAAD9UlEQVRIx7VWQYgTVxj+5r2Z7WBTCMLKXJRQqgwKEkorUWKJtFuCW2UpZelhKbmsyOohUOylPYjgImmRXJSglxwUZPGwUCihLTJIuoRiIRRbpnQLAS9hC2UOCo+8eX96eJPMJJvdrpU8Hsn//nnv//7v/+f/5xlClDHNYQJwMut6Ydv26JOhHOvtpJxKyHY6IUd6b91hU3UfwNQBTAAIhV6IEMxg3OCc8b0cFkIwZnFucT7T673QAgAhgsEWx9yLoT0OpaQWeMK9VwUgkkORMUspybmV3DCeA+qT6isAc2ecdrOolWc/mL1146gW2s2cnpVrh8d8J5JEcsgjBhCDiRCMwEGAUBK+H1y57KZT9owJGSKdwupXx8pf/JrNe9m8d+L46+ULGYSgnqSeVKHSk0iK50JP7P4W/dIOkstCftZrbnkb/0TLhVbuRDomESoVKi3sGiKCUlCDPXfrnVo1+xJ5HrWOvdTBnXqnkJ8F4DX/LuQPFE7t13pvPdf6OaZIIVFI2zFG6qAHxk2uCMS4vY9JIAjEI6/72VIGQBCIqzeeVivH9ebGj1uVqg+Ac/1e2hoGgBgYBGAIUU479YiOuQ8ANzk3ebLnjL7MsZ4N+HMOwOJ8vDz9J7nJIdoeyp0GEQCdNqWUAqDU9hC9wmAMRBGVIUaSiokQ4vmAfIriOCKOY7ItI6EnZgMAAwHQP3pHnAP7Jbrpu2/v/z8U9d/HC5n79QKAlle8fjU7fNxuFufOOFq+dOHIynLUHk6fnG08LHTaRT3LF98CUL1+1G8V/Fah0y7eqmT/OweVazHSyvLh0sVWvZa7ffdPAF9+fuzxxlbx0xYAbR1A8f0Dbs4bM2IKAGFA6oWkng0B4FknsCGEwJE3052OCAIhhHDdN4QQ99f+SqcAIJ3C7Tu/63RUq0+1q41HXf9JAYANVGub1domQjGBQb3ul0rub3+Ixxvd9045AM6dPXh+/tD5+UMAvqm07611IpfnnOrXEUv3nUbxQ8fNNibnYGyUSu7pk87qzbZenps/uLzyk5N54GQeLC1mtHJpMdP4oetmG+Ur7V3iPDkH9bq/8JG7ejPWfPvdMy3cW+ssLWaKn3iNh4XLK27yVOP7rt8uYlDrmWwDulXYqVpEx2Dc4AA448pQACzLAkAzM0MrO7WQpH5YB93NhREG1B8UCwEcAKSUlmUhVDCj4lSqB0B/3KHU8Ps71iF2DBH1iRlM9RVHdFJKyV/j0N3J5PqrG8EY8UFlJNLJdgBgBqM+aYzI94izhMlgcoSKMLw6WCCKuh1jlLzpbAMQA/ftZKykHNgyOUJCSPqExiBIObxqEoESvSuciDWdMXUAY9rX938Bq9jPLO9RDfAAAAAASUVORK5CYII=';
			
		}
		
	}
	
	@imagepng($result, 'cache/'.$ref.'_'.$id.'.png');
	@chmod('cache/'.$ref.'_'.$id.'.png', 0775);
	
	return 'cache/'.$ref.'_'.$id.'.png';
	
}


session_name(md5($_SERVER['HTTP_USER_AGENT'].$uniqueKey));
session_cache_expire(60);
session_start();

function vCode($content) {
	return addslashes(htmlentities(trim(utf8_decode($content)), ENT_QUOTES, 'ISO-8859-1'));
}

function atualAlert($msg, $msg_link='') {
	$filterBR = array('&lt;br /&gt;' => '<br />', '&lt;br&gt;' => '<br />', '&lt;b&gt;' => '<b>', '&lt;/b&gt;' => '</b>', '\\n' => '<br />');
	return "<script>atualAlert('".strtr(addslashes(htmlentities(trim($msg), ENT_QUOTES, 'ISO-8859-1')), $filterBR)."', '".$msg_link."');</script>";
}

function fim($msg='', $act='', $url='') {
	if(isset($_POST['isJS'])) {
	    die(json_encode(array('msg' => $msg, 'act' => $act, 'url' => $url)));
	} else {
		if(!empty($msg)) { $_SESSION['aAlert_msg'] = $msg; $_SESSION['aAlert_act'] = $act; }
		echo "<script type='text/javascript'>".(!empty($url) ? "document.location.replace('".$url."');" : "history.back();")."</script>";
	}
	exit;
}

require('private/configs.php');
$server_url = trim($server_url); $dir_gallery = trim($dir_gallery); $dir_banners = trim($dir_banners); $dir_newsimg = trim($dir_newsimg); 
if(substr($server_url, 0, 7) == 'http://') { $server_url = substr($server_url, 7); } if(substr($server_url, 0, 8) == 'https://') { $server_url = substr($server_url, 8); } if(substr($server_url, -1) == '/') { $server_url = substr($server_url, 0, -1); }
if(substr($dir_gallery, -1) != '/') { $dir_gallery .= '/'; }
if(substr($dir_banners, -1) != '/') { $dir_banners .= '/'; }
if(substr($dir_newsimg, -1) != '/') { $dir_newsimg .= '/'; }
$asideRankCount = (!empty($asideRankCount) ? intval($asideRankCount) : 3);


if(isset($_GET['changelang'])) {
	switch(strtolower(vCode($_GET['changelang']))) {
		case 'pt': $language = 'pt'; break;
		case 'es': $language = 'es'; break;
		default: $language = 'en';
	}
	setcookie('atualstudio_language', $language, time()+2592000, '/');
	$url = urldecode(addslashes(trim($_GET['url'])));
	if(!empty($url) && strpos($url, 'changelang') === false) {
	    header('Location: '.$url);
	} else {
		header('Location: ./');
	}
	exit;
}

$cookieLang = (!empty($_COOKIE['atualstudio_language']) ? strtolower(vCode($_COOKIE['atualstudio_language'])) : '');
if($cookieLang == 'pt' || $cookieLang == 'en' || $cookieLang == 'es') {
	$language = $cookieLang;
} else {
	switch(strtolower(trim($defaultLang))) {
		case 'pt': $defaultLang = 'pt'; break;
		case 'es': $defaultLang = 'es'; break;
		default: $defaultLang = 'en';
	}
	$nativeLang = strlen(trim($_SERVER["HTTP_ACCEPT_LANGUAGE"])) > 1 ? strtolower(substr(trim($_SERVER["HTTP_ACCEPT_LANGUAGE"]), 0, 2)) : '';
	if(!empty($nativeLang)) {
		switch(strtolower(vCode($nativeLang))) {
			case 'pt': $language = 'pt'; break;
			case 'es': $language = 'es'; break;
			case 'en': $language = 'en'; break;
			default: $language = $defaultLang;
		}
	} else {
		$language = $defaultLang;
	}
	setcookie('atualstudio_language', $language, time()+2592000, '/');
}

require('lang/'.$language.'.php');


$atualMin = date('i');
if(!isset($_SESSION['minAccess'][$atualMin])) {
	$_SESSION['minAccess'][$atualMin] = 0;
} else if(count($_SESSION['minAccess']) > 1) {
	unset($_SESSION['minAccess']);
	$_SESSION['minAccess'][$atualMin] = 0;
}
if($_SESSION['minAccess'][$atualMin] > 30) {
	echo '<h1>SECURITY BLOCK</h1>'.$LANG[30506].' #001';
	exit;
}
$_SESSION['minAccess'][$atualMin] += 1;


if(!isset($_SESSION['lastAccess'])) { $_SESSION['lastAccess'] = 0; }
if($_SESSION['lastAccess'] > (time() - 3)){
	if(empty($_SESSION['countAccess'])){
		$_SESSION['countAccess'] = 1;
	} elseif($_SESSION['countAccess'] < 5){
		$_SESSION['countAccess'] += 1;
	} elseif($_SESSION['countAccess'] >= 5){
		echo '<h1>SECURITY BLOCK</h1>'.$LANG[30506].' #002';
		exit;
	}
} else {
	$_SESSION['countAccess'] = 1;
}
$_SESSION['lastAccess'] = time();


require('private/classes/DB.php');
new DB($conMethod, $host, $user, $pass, $dbnm);

$logged=0;
if(!empty($_SESSION['acc']) && !empty($_SESSION['ses'])) {
	if(vCode($_SESSION['ses']) === vCode(md5($_SERVER['HTTP_USER_AGENT'].$uniqueKey.'logged'))){
		$_SESSION['acc'] = vCode($_SESSION['acc']);
		$logged=1;
	} else {
		require('private/classes/classAccess.php');
		Access::logout();
	}
}


$indexing=1;


$recacheFile = 'cache/recacheall.xml';
if(!file_exists($recacheFile)) {
	$recacheNew = 1;
} else {
	$xml = simplexml_load_file($recacheFile);
	$configs = $xml->configs;
	$updated = intval($configs->updated);
	$delay = 20;
	if(($updated+($delay*60)) < time()) {
		$recacheNew = 1;
	}
}
if(isset($recacheNew)) {
	require("private/recacheall.php");
}


$p = isset($_GET['page']) ? vCode($_GET['page']) : 'index';

if(isset($_GET['engine'])) {
	$p = vCode($_GET['engine']);
	$isEngine=1;
}

if(!preg_match("/^[a-zA-Z0-9_-]{1,25}$/", $p)) { $p = '404'; }

$m = isset($_GET['module']) ? vCode($_GET['module']) : '';
if(!empty($m)) {
	if(preg_match("/^[a-zA-Z0-9_-]{1,25}$/", $m)) {
		$m = $m.'/';
	} else {
		$m = '';
	}
}

if(!isset($isEngine)) {
	
	if(file_exists('pages/'.$m.$p.'.php')) {
		$p = $m.$p;
	} else {
		$p = '404';
	}
	
} else {
	
	if(file_exists('engine/'.$m.$p.'.php')) {
		require('engine/'.$m.$p.'.php');
		exit;
	} else {
		$p = '404';
	}

}

require('layout.php');

@DB::close();
