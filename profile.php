<?php
include("header.php");

if(isset($_SESSION["LOGGED_IN"])) $USER_DATA=get_user_data($_SESSION["LOGGED_IN"]);
if(isset($_REQUEST["other_profile"])) $USER_DATA=get_user_data($_REQUEST["other_profile"]);

$name=strtolower($USER_DATA["name"]);

echo "<link rel=\"stylesheet\" href=\"profile.css\" /> ";

$AVATAR_SIZE=150;

echo "<h1>$SITE_PROFILE_HEADER@".strtolower($name)."</h1>";

$EDIT=false;
if(isset($_REQUEST["act"])) {
    if($_REQUEST["act"]=="profile_user_edit"){
        $EDIT=true;
    } 
    if($_REQUEST["act"]=="profile_update") {
        echo "<h3>Updating Profile...</h3>";

        $nname=strtolower($_REQUEST["name"]);
        $nemail=$_REQUEST["email"];
        $nprofile_info=$_REQUEST["profile_info"];
        $nwebsite=$_REQUEST["website"];

        $x=get_user_data($nname);
        $x["email"]=$nemail;
        $x["profile_info"]=$nprofile_info;
        $x["website"]=$nwebsite;
        set_user_data($nname,$x);

        $npw="";
        if(!empty($_REQUEST["pw"])){
            $pw=$_REQUEST["pw"];
            $cpw=$_REQUEST["cpw"];
            if($pw!=$cpw) {
                warn("PASSWORDS DON'T MATCH");
            }
            else {
                $npw=md5($pw);
                $x=get_user_data($nname);
                $x["pw"]=$npw;
                set_user_data($nname,$x);
            }
        }
        
        $image_file_name = $_FILES["my-file"]["name"];
        $tmp_img = $_FILES["my-file"]["tmp_name"];
        $x=explode(".",$image_file_name);
        $x=array_pop($x);
        $z=getcwd();
        $file=$SITE_JSON_USERS."/$nname/$nname.$x";

        if (move_uploaded_file($tmp_img, "$file")) {
                $profile_pic="$SITE_JSON_USERS_URL/users/$nname/$nname.$x";
                $x=get_user_data($nname);
                $x["profile_pic"]=$profile_pic;
                set_user_data($nname,$x);
            }
            else {
        }
        echo "<meta http-equiv=\"refresh\" content=\"0; url=$SITE_URL/profile.php\">";
    }
}


if($EDIT) {

    $lc=0;
    
    echo "
        <form action=\"profile.php?act=profile_update\" enctype=\"multipart/form-data\" method=post >
        <div id=outtab >
            <table  border=0 cellspacing=0 cellpadding=8>
            ";

            echo "<tr id=tr$lc><td valign=bottom>";

            
            if($USER_DATA["profile_pic"]!="empty") {
                put_avatar($USER_DATA["profile_pic"],$AVATAR_SIZE,$AVATAR_SIZE,"","$SITE_URL/profile.php");
            }
            else {
                put_avatar("$SITE_URL/images/system/user.png",$AVATAR_SIZE,$AVATAR_SIZE,"","$SITE_URL/profile.php");   
            }
            echo "</td><td valign=bottom>";
            echo "Upload new image:<br><input id=longin type=\"file\" name=\"my-file\" accept=\"image/*\">";
            echo "</td> </tr>";
            

    foreach($USER_DATA as $k => $v) {

        if( ($k!="verified") &&
            ($k!="id") &&
            ($k!="access")) {
                $lc++;if($lc>1)$lc=0;
                echo "<tr id=tr$lc>";

            if($k=="pw") {
                echo "<td> new password </td>";
                echo "<td> <input type=password id=longin name=\"$k\" value=\"\"> </td>";
                echo "</tr>";
                $lc++;if($lc>1)$lc=0;
                echo "<tr id=tr$lc>";
                echo "<td> confirm pw </td>";
                echo "<td> <input type=password id=longin name=\"cpw\" value=\"\"> </td>";
            }
            else {
                if($k=="name") {
                    echo "<td> $k </td>";
                    echo "<td> <input type=hidden id=longin name=\"$k\" value=\"$v\">$v </td>";
                }
                else {                
                    echo "<td> $k </td>";
                    echo "<td> <input id=longin name=\"$k\" value=\"$v\"> </td>";
                }
            }


            echo "</tr>";
        }

    }

    echo "<tr><td></td><td>";

    echo "<input type=submit name=\"Go\" value=\"Go\">
            </td></tr>
            </table>
            </div>
        </form>
        ";
}
else {

    echo "<div id=outtab ><table border=0><tr>";
    echo "<td>";
    if($USER_DATA["profile_pic"]!="empty") {
        put_avatar($USER_DATA["profile_pic"],$AVATAR_SIZE,$AVATAR_SIZE,"","$SITE_URL/profile.php");
    }
    else {
        put_avatar("$SITE_URL/images/system/user.png",$AVATAR_SIZE,$AVATAR_SIZE,"","$SITE_URL/profile.php");   
    }

    echo "</td><td valign=bottom>";
    put_icon("$SITE_URL/images/system/user_edit.png",32,32,"","$SITE_URL/profile.php?act=profile_user_edit");
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<hr>";

    $lc=0;
    echo "<table border=0 cellspacing=0 cellpadding=10>";

    foreach($USER_DATA as $k => $v) {

        if(!is_array($v)){
            if( ($k!="pw")&&
                ($k!="id")&&
                ($k!="email")&&
                ($k!="profile_pic") ) {
            $lc++; if($lc>1) $lc=0;
            echo "<tr id=tr$lc>";
            echo "<td>$k</td>";

            if($k=="website") {
                if( (!empty($v)) &&
                    ($v != " "))  {
                    $v=str_replace("http://","",$v);
                    $v=str_replace("https://","",$v);
                    $v="<a href=\"http://$v\" target=\"$v\">$v <img src=$SITE_URL/images/system/link2.png></a>";
                }
            }
            echo "<td>$v</td>";
            echo "</tr>";
            }
        }
    }
    echo "</table></div>";
}

include("$SITE_FOLDER/profile_ext.php");


include("footer.php");
 