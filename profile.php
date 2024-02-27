<?php
include("header.php");
if(isset($_SESSION["LOGGED_IN"])) $USER_DATA=get_user_data($_SESSION["LOGGED_IN"]);
if(isset($_REQUEST["other_profile"])) $USER_DATA=get_user_data($_REQUEST["other_profile"]);

echo "<link rel=\"stylesheet\" href=\"profile.css\" /> ";

$AVATAR_SIZE=128;

$EDIT=false;
if(isset($_REQUEST["act"])) {
    if($_REQUEST["act"]=="user_edit"){
        $EDIT=true;
    } 
}


echo "<hr>";

if($EDIT) {
    echo "<h1>PROFILE</h1>";
    echo "

    <form>
  <input type=\"file\" name=\"my-file\" multiple>
</form>
        
    ";
    /*
    
    <div id=\"drop_file_zone\" ondrop=\"upload_file(event)\" ondragover=\"return false\">
        <div id=\"drag_upload_file\">
            <p>Drop file here</p>
            <p>or</p>
            <p><input type=\"button\" value=\"Select File\" onclick=\"file_explorer();\" /></p>
            <input type=\"file\" name=\"filez\" id=\"selectfile\" />
        </div>
    </div>
    <div class=\"img-content\"></div>
    <script src=\"$SITE_URL/profile.js\"></script>
    */
}
echo "<table border=0><tr>";
echo "<td>";
if($USER_DATA["profile_pic"]!="empty") {
    put_avatar($USER_DATA["profile_pic"],$AVATAR_SIZE,$AVATAR_SIZE,"","$SITE_URL/profile.php");

       
       

}
else {
    put_avatar("$SITE_URL/images/system/user.png",$AVATAR_SIZE,$AVATAR_SIZE,"","$SITE_URL/profile.php");
    
}

echo "</td><td valign=bottom>";
put_icon("$SITE_URL/images/system/user_edit.png",32,32,"","$SITE_URL/profile.php?act=user_edit");
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<hr>";
$lc=0;
echo "<table border=0 cellspacing=0 cellpadding=10>";

foreach($USER_DATA as $k => $v) {

    if(!is_array($v)){
        if( ($k!="pw")&&
            ($k!="id") ) {
        $lc++; if($lc>1) $lc=0;
        echo "<tr id=tr$lc>";
        echo "<td>$k</td>";
        if($k=="website") {
            if( (!empty($v)) &&
                ($v != " "))  {
                $v=str_replace("http://","",$v);
                $v=str_replace("https://","",$v);
                $v="<a href=\"http://$v\" target=\"$v\">$v <img src=images/system/link2.png></a>";
            }
        }
        echo "<td>$v</td>";
        echo "</tr>";
        }
    }
}
echo "</table>";

include("footer.php");
 