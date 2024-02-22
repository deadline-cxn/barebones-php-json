<?php
session_name("tech.cityxen.net");
session_cache_expire(99999);
session_start();

include("../config.php");
include("../../include/phylactery/lib.mysql.php");
include("../../include/phylactery/lib.file.php");
include("../../include/phylactery/class.email.php");



if (isset($_REQUEST['login'])) {
	if ($_REQUEST['login'] == "true") {
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$r = lib_mysql_query("select * from `users` where `username` = '$username'");
		$user = $r->fetch_object();
		if ($user->password == md5($password)) {
			$_SESSION['loggedin'] = "true";
			$_SESSION['user'] = $user->id;
			goto_page("/");
		} else {
			echo "<center>Invalid login. For access please email <a href=\"mailto://$S_EMAIL_ADMIN\">$S_EMAIL_ADMIN</a><Br><br></center>";
		}
	}
}

function goto_page($x) {
	echo " <script language=\"javascript\" type=\"text/javascript\"> window.location=\"$x\"; </script> <!--// -->";
}


echo "<!DOCTYPE html>";
// <todo_change_this_meta todo_change_this_name="todo_change_this_google-site-verification" content="todo_change_this_tVlHgVIfNgLFAVBhms9VKTg1WDtlBOu5TfxQbOND__A" />
// $which_bg=rand(1,9); system("cp images/background/bg$which_bg.jpg images/background/bg.jpg");
function put_link($url,$words) {  echo " <a href=\"$url\">$words</a> "; }
$a=rand(1,99999999);

$uri=$_SERVER["REQUEST_URI"];
$uri=explode("?",$uri)[0];
$uri=str_replace("/","",$uri);
$uri=str_replace(".php","",$uri);
$uri=strtoupper($uri);
if(!empty($uri)) $uri=" >> ".$uri;

echo "
<html>
<head>
<link rel=\"stylesheet\" type=\"text/css\" href=\"site.css?v=$a\" />
<meta charset=\"UTF-8\">
<link rel=\"icon\" href=\"favicon.ico?v=$a\" />
</head>
<body>
<center>
";

echo "<div id=warn>
<img src=images/logo-cityxen3.png width=20%><br><br>
<img src=images/cia.png width=20%><br><br>
WARNING: ACTIVITES ARE LOGGED<br><br>
<br>";

echo "<form method=post>";
echo "<center><table border=0><tr><td> <input type=hidden name=login value=true> ";
echo "<div id=black>LOGIN</div>";
echo "</td><td>";
echo "<input name=username> ";
echo "</td></tr><tr><td>";
echo "<div id=black>PASSWORD</div>";
echo "</td><td>";
echo "<input name=password type=password> ";
echo "</td></tr><tr><td></td><td>";
echo "<input type=submit> ";
echo "</td></tr></table></center>";
echo "</form>";

echo "</div>



<div id=bottomwarn>

This website, Clicky and Friends AI, artwork, videos, and all other CityXen media, are Intellectual Property of CityXen and are fictional artistic works.
Under no circumstances should any of this be taken seriously.
The story, all names, characters, and incidents portrayed in CityXen production are fictitious.
No identification with actual persons (living or deceased), computers, places, buildings, and products is intended or should be inferred.
No computers were harmed in the making of any CityXen media.

</div>
";

include("footer.php");
