<?
$filename ="d.png";
$index=null;
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
function CC_rand(){
$mass = array('1','2','3','4','5','6','7','8','9','0','q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','z','x','c','v','b','n','m');
$_result = $mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))].$mass[rand(0,count($mass))];
	
	return $_result;
}
function addReq($url,$id,$filename){
	$qq=array();
	if(file_exists($filename)){
		$qq=json_decode(decryptIt(file_get_contents($filename, true)));
		if($qq == null){$qq=array();}
		array_push($qq,array("url"=>encryptIt($url),"id"=>$id));
	}else{
		$qq=array(array("url"=>encryptIt($url),"id"=>$id));
	}
	fwrite(fopen($filename,"w"),encryptIt(json_encode($qq))); 
}
function findId($id,$filename){
	if(!file_exists($filename)){fclose(fopen($filename, "w"));}
	$qq=json_decode(decryptIt(file_get_contents($filename, true)));
	for($i=0;$i<=sizeof($qq)-1;$i++){
		if($qq[$i]->id == $id){return decryptIt($qq[$i]->url);};
	}
	return false;
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
function showList($filename){
	if(file_exists($filename)){
		$qq=json_decode(decryptIt(file_get_contents($filename, true)));
		for($i=0;$i<=sizeof($qq)-1;$i++){
		echo ($i+1)."| ".$qq[$i]->id." | ".decryptIt($qq[$i]->url)."</br>";
		}
	}
}
function selfURL(){
	
	/* $arr = str_split($_SERVER[PHP_SELF]);
	$counter = sizeof($arr);
	$result = $_SERVER[HTTP_HOST];
	while($arr[$counter-1]!= '/'){$counter--;}
	for($i = 0;$i<=$counter-1;$i++){$result = $result.$arr[$i];}
	return $result; */
	return substr($_SERVER[HTTP_HOST].$_SERVER[PHP_SELF],0,-9);
}
if($_GET['show']=="all"){
	showList($filename);
}
if($_GET['id']==null){
echo'<head><title>URL Shorter</title></head><body bgcolor="#202225"><form style="margin-top:20%;margin-left:35%;" method="post" action="#"><h1 style="color:#515151;">URL Shorter by '.$_SERVER[HTTP_HOST].'</h1><p><input style="margin-right:10px;padding-left:1%;border-radius:10px 10px 10px 10px;width:25%;" type="text" placeholder="LongURL" name="url" /><input style="margin-top:20px;padding-left:3px;width:80px;margin-right:10px;border-radius:10px 10px 10px 10px;" type="text" value='.CC_rand().' placeholder="ShortURL" name="id" /><input style="margin-top:20px;padding:5px;color:#a8927d;border:none;background-color:#32363c;border-radius:10px;" type="submit" value=GENERATE /></p></form></body>';
}
if($_POST['id']!=null and $_POST['url']!=null){
	$obj=findId($_POST['id'],$filename);
	if($obj==false){
		addReq($_POST['url'],$_POST['id'],$filename);
		echo'<p style=text-align:center;padding:5px;margin-left:35%;width:max-content;background:#32363c;border-radius:10px 10px 10px 10px;padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:10px;font-size:14px;font-color:#839496;color:#839496;><a style="border-radius: 10px 0 0 10px;padding:5px;margin-right:5px;margin-left:-5px;background-color:#515151;">URL</a><a href=http://'.selfURL().$_POST['id'].' style=color:#6d6e71;text-decoration:none;left:auto; >'.selfURL().$_POST['id'].'</a></p>';
	}else{
		echo'<head><title>URL Shorter</title></head><body bgcolor=#202225 ><form style="margin-top:20%;margin-left:35%;" method=post action=# ><h1 style="color:white;">URL Shorter by '.$_SERVER[HTTP_HOST].'</h1><b style=color:red; > ERROR 500:12 - Link reserved</b><p><input style=margin-right:10px;padding-left:1%;border-radius:10px 10px 10px 10px;width:25%; type=text placeholder="LongURL" name=url /><input style=margin-top:20px;padding-left:3px;width:80px;margin-right:10px;border-radius:10px 10px 10px 10px; type=text value='.CC_rand().' placeholder="ShortURL" name=id /><input style=margin-top:20px;padding:5px;color:#202225;border:none;background-color:#474a4f;border-radius:10px; type=submit value=GENERATE /></p></form></body>';
	}
}	
if($_GET['id']!=null){
	if(findId($_GET['id'],$filename)!=false){
		echo'<html><head><title>Redirect...</title><meta http-equiv="refresh" content="0;url='.httpcheck(findId($_GET['id'],$filename)).'"></head><body/><html/>';
	}else{
		echo'<head><title>URL Shorter</title></head><body bgcolor=#202225 ><form style="margin-top:20%;margin-left:35%;" method=post action=# ><h1 style="color:white;">URL Shorter by '.$_SERVER[HTTP_HOST].'</h1><b style=color:red; > ERROR 404 - Link not found</b><p><input style=margin-right:10px;padding-left:1%;border-radius:10px 10px 10px 10px;width:25%; type=text placeholder="LongURL" name=url /><input style=margin-top:20px;padding-left:3px;width:80px;margin-right:10px;border-radius:10px 10px 10px 10px; type=text value='.CC_rand().' placeholder="ShortURL" name=id /><input style=margin-top:20px;padding:5px;color:#202225;border:none;background-color:#474a4f;border-radius:10px; type=submit value=GENERATE /></p></form></body>';
	}
}
?>
