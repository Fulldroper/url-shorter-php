<?
    $host ='localhost';
    $username='root';
    $pass='';
    $bd = 'cc';
    $from = 'from';
    $to = 'to';
    $ip = 'ip';
    $table='url';
	$index=null;
function selfURL(){
return $_SERVER[HTTP_HOST].$_SERVER[PHP_SELF];
}
function install($table,$from,$to,$ip,$bd){
$code='CREATE DATABASE '.$bd.';USE '.$bd.';CREATE TABLE IF NOT EXISTS `'.$table.'` ( `id` int(11) NOT NULL AUTO_INCREMENT,`'.$from.'` varchar(255) NOT NULL,`'.$to.'` varchar(255) NOT NULL,`'.$ip.'` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;';return $code;}
function selectBD($bd,$host,$username,$pass){
 $link = mysql_connect($host, $username, $pass);if (!$link) {die('oшибка соединени¤: ' . mysql_error());}mysql_select_db($bd) or die('Не удалось выбрать базу данных selectBD('.$bd.')');}
function encryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}
function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}
function reqSQL($string,$err){
	if($string != null){
		$result = mysql_query($string) or die($err.mysql_error());
		if($err != null){
			$line = mysql_fetch_array($result, MYSQL_BOTH);
			return $line;
		}
	}else{return "lib.reqSQL:empty args";}
}
function httpcheck($string){
	$arr1 = str_split($string);
	$http=$arr1[0].$arr1[1].$arr1[2].$arr1[3];
	if($http != 'http'){
		$string1= 'http://'.$string;
		return $string1;
	}else{
		return $string;
	}					
}
function CC_rand(){
$mass = array('1','2','3','4','5','6','7','8','9','0','q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','z','x','c','v','b','n','m','Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M');
$_result = $mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))];
	
	return $_result;
}
//install table
if($_GET['install']==1){
selectBD($bd,$host,$username,$pass);
reqSQL(install($table,$from,$to,$ip,$bd),null);
mysql_close();
}
//redirect
if($_GET['o']!=null){
selectBD($bd,$host,$username,$pass);
$line = reqSQL("SELECT * FROM `".$table."` WHERE `".$to."` = '".$_GET['o']."' ","err:1");
if($line['to']!=null){
	$line = reqSQL("SELECT * FROM `".$table."` WHERE `".$to."` = '".$_GET['o']."' ","err:2");
	mysql_close();
	echo'<html><head><title>Redirect...</title><meta http-equiv="refresh" content="0;url='.httpcheck(decryptIt($line[$from])).'"></head><body/><html/>';}else{
	echo'<head><title>URL Shorter</title></head><body bgcolor=#202225 ><form style="margin-top:20%;margin-left:35%;" method=post action=# ><h1 style="color:white;">URL Shorter by '.$_SERVER[HTTP_HOST].'</h1><b style=color:red; > ERROR 404 - Link not found</b><p><input style=margin-right:10px;padding-left:1%;border-radius:10px 10px 10px 10px;width:25%; type=text placeholder="LongURL" name=to /><input style=margin-top:20px;padding-left:3px;width:80px;margin-right:10px;border-radius:10px 10px 10px 10px; type=text value='.CC_rand().' placeholder="ShortURL" name=from /><input style=margin-top:20px;padding:5px;color:#202225;border:none;background-color:#474a4f;border-radius:10px; type=submit value=GENERATE /></p></form></body>';}
}						
//index page
if($_GET['o']==null){
echo'<head><title>URL Shorter</title></head><body bgcolor=#202225 ><form style="margin-top:20%;margin-left:35%;" method=post action=# ><h1 style="color:white;">URL Shorter by '.$_SERVER[HTTP_HOST].'</h1><p><input style=margin-right:10px;padding-left:1%;border-radius:10px 10px 10px 10px;width:25%; type=text placeholder="LongURL" name=to /><input style=margin-top:20px;padding-left:3px;width:80px;margin-right:10px;border-radius:10px 10px 10px 10px; type=text value='.CC_rand().' placeholder="ShortURL" name=from /><input style=margin-top:20px;padding:5px;color:#202225;border:none;background-color:#474a4f;border-radius:10px; type=submit value=GENERATE /></p></form></body>';
}	
//reg linc
if($_POST['to']!=null){
	
selectBD($bd,$host,$username,$pass);	
$line = reqSQL("SELECT * FROM `".$table."` WHERE `".$to."` = '".$_POST['from']."' ","err:3");
if($_POST['from'] != $line['to'] and $_POST['to']!=null){	
	reqSQL("INSERT INTO `".$table."`(`".$from."`, `".$to."`,`".$ip."`) VALUES ('".encryptIt($_POST['to'])."','".$_POST['from']."','".$_SERVER[REMOTE_ADDR]."')",null);
	echo'<p style=padding:5px;margin-left:35%;width:320px;background:#32363c;border-radius:10px 10px 10px 10px;padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:10px;font-size:14px;font-color:#839496;color:#839496;><a href=http://'.selfURL().'?o='.$_POST['from'].' style=color:#6d6e71;text-decoration:none;left:auto; >http://'.selfURL().'?o='.$_POST['from'].'</a></p>';
}mysql_close();}	
?>