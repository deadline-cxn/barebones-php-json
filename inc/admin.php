<?php
chdir("..");
include("header.php");
debug_print(__FILE__."<br>");

$access=access("admin");
if($access) {

    if(isset($_REQUEST["toggle_debug"])) {
        if(isset($_SESSION["DEBUG"])) unset($_SESSION["DEBUG"]);
        else $_SESSION["DEBUG"]="true";
        echo "<meta http-equiv=\"refresh\" content=\"0; url=$SITE_URL/inc/admin.php\">";
    }

    if(isset($_REQUEST["toggle_debug_v"])) {
        if(isset($_SESSION["DEBUG_VARS"])) unset($_SESSION["DEBUG_VARS"]);
        else $_SESSION["DEBUG_VARS"]="true";
        echo "<meta http-equiv=\"refresh\" content=\"0; url=$SITE_URL/inc/admin.php\">";
    }

    if(isset($_REQUEST["act"])) {
        $act=$_REQUEST["act"];

        switch($act) {

            case "gitlog":
                echo "GIT Log... <hr>";
                echo "<pre>";

                $x=file_get_contents(".git/logs/HEAD");

                $x=str_replace("<","&lt;",$x);
                $x=str_replace(">","&gt;",$x);

                echo $x;

                echo "</pre><hr>";

                break;

            case "gitpull":

                echo "Updating site... <hr>";
                $cmd="git pull";
                exec($cmd,$x);
                foreach($x as $k => $v) {
                    echo "$v<br>";
                }
                echo "<hr>Complete<br>";

                break;
            

            case "user_edit_i":

                $usr=$_REQUEST["user"];
                echo "<h1>ADMINISTRATION PANEL >> ";
                echo "EDITING USER: $usr";
                echo "</h1>";
                
                $result=get_user_data($usr);
                
                echo "<form action=\"$SITE_URL/inc/admin.php\" method=\"post\">";
                $output="<input type=hidden name=act value=user_edit_go>";

                echo "<div id=outtab ><table border=0 cellspacing=0 cellpadding=8>";

                $lc=0;

                foreach($result as $k => $v) {

                    if( ($k!="meatloaf") && 
                        ($k!="id") 
                     ) {

                        $lc++; if($lc>1) $lc=0;

                        $output.="<tr id=tr$lc><td> ";
                        $output.="<a href=\"$SITE_URL/inc/admin.php?act=remove_user_key&user=$usr&key=$k\"><img src=\"$SITE_URL/images/system/x-button.png\" width=16 height=16 alt=\"Delete key\"></a>";
                        $output.="$k</td><td><input id=longin type=text name=\"$k\" value=\"";

                        if(is_array($v)) {
                            $o="";
                            foreach($v as $kk => $vv) {
                                $o.=$vv.",";
                            }
                            $o=substr($o,0,strlen($o)-1);
                            $output.="$o\">";
                        }
                        else {

                            if($k!="pw") {
                                $output.="$v\">";
                            }
                            else $output.="\">
                            <input type=hidden name=opwmd5 value=\"$v\">";
                            
                            $output.="</td></tr>";
                        }
                    }
                }
                echo "$output";
                echo "<tr><td></td><td><input type=submit name=Go value=Go></td></tr>";
                echo "</table></div>";                
                echo "</form>";

                echo "<form action=\"$SITE_URL/inc/admin.php\" method=\"post\">";
                
                echo "<input type=hidden name=act value=edit_user_ak>";
                echo "<table border=0>";

                echo "<tr><td>New Key</td><td><input type=text name=\"new_key\" value=\"\"> </td></tr>";

                echo "<tr><td>Value</td><td><input type=text name=\"new_value\" value=\"\"></td></tr>";
                
                echo "<tr><td></td><td><input type=submit name=\"Add Key\"  value=\"Add Key\"></td></tr>";
                echo "</table>";

                echo "</form>";
                break;


            case "user_edit_go":
                $usr=$_REQUEST["name"];
                echo "<h1>ADMINISTRATION PANEL >> ";
                echo "EDITING USER (GO): $usr";
                echo "</h1>";

                
                $act=$_REQUEST["act"];
                $act=$_REQUEST["Go"];
                $opwmd5=$_REQUEST["opwmd5"];
                unset($_REQUEST["opwmd5"]);
                
                foreach($_REQUEST as $k => $v) {
                    if($k=="access") {
                        $v=explode(",",$v);
                        $USER_DATA[$k]=$v;
                    }
                    else {
                        if( ($k!="act") &&
                            ($k!="Go") )
                            $USER_DATA[$k]=$v;
                        if($k=="pw") {
                            if(!empty($v)) {
                                $USER_DATA[$k]=md5($v);
                            }
                            else{
                                $USER_DATA[$k]=$opwmd5;
                            }
                        }
                    }
                }

                $act="user_edit";
                set_user_data($usr,$USER_DATA);
                echo "<meta http-equiv=\"refresh\" content=\"0; url=$SITE_URL/inc/admin.php?act=user_edit\">";
                break;


            case "user_edit_d":
                echo "<h1>ADMINISTRATION PANEL >> ";
                $usr=$_REQUEST["user"];
                echo "DELETE USER: $usr";
                echo "</h1>";
                are_you_sure("$SITE_URL/inc/admin.php?act=user_edit_dg&user=$usr");
                break;

            case "user_edit_dg":
                $usr=$_REQUEST["user"];
                if(!empty($_REQUEST["Yes"])) {
                    warn("<h2>DELETING USER: $usr</h2>");
                    $p=$GLOBALS["SITE_JSON_USERS"];
                    $f="$p/$usr";
                    $cmd="rm -rf $f";
                    
                    //warn("<h2>FOLDER: $f</h2><h2>cmd: $cmd</h2>");
                    exec($cmd);

                }               
            
            case "user_edit":

                echo "<h1>ADMINISTRATION PANEL >> ";
                echo "EDIT USERS";
                echo "</h1><br>";

                $lc=0;

                echo "<div id=outtab ><table border=0 cellspacing=0 cellpadding=10>";
                echo"<tr id=tr$lc><td></td><td></td><td>USER</td><td>EMAIL</td><td>ACCESS</td></tr>";
                
                $users=get_user_list();

                foreach($users as $k => $u) {
                    $user=get_user_data($u);
                    if(!empty($user)) {
                        $lc++; if($lc>1) $lc=0;
                        echo "<tr id=tr$lc><td>";
                        echo "<a href=\"$SITE_URL/inc/admin.php?act=user_edit_i&user=$u\"><img src=\"$SITE_URL/images/system/pen.png\" width=16 height=16></a>";
                        echo "</td><td>";
                        echo "<a href=\"$SITE_URL/inc/admin.php?act=user_edit_d&user=$u\"><img src=\"$SITE_URL/images/system/x-button.png\" width=16 height=16></a>";
                        echo "</td><td>";
                        $u = strtolower($user["name"]);
                        if( (empty($user["profile_pic"])) || 
                            ($user["profile_pic"]=="empty") 
                        ){
                            $img_url = get_gravatar($USER_DATA["email"], $AVATAR_SIZE);
                            put_avatar($img_url,$AVATAR_SIZE,$AVATAR_SIZE,"","$SITE_URL/profile.php");
                            //put_avatar("$SITE_URL/images/system/user.png",64,64,"","https://meatloaf.cc/@".$u);
                        }
                        else {
                            put_avatar($user["profile_pic"],64,64,"","https://meatloaf.cc/@".$u);
                        }
                        echo "</td><td>";
                        echo $user["name"];
                        echo"</td><td>";
                        echo $user["email"];
                        echo"</td><td>";
                        foreach($user["access"] as $kk => $vv)
                            echo "$vv ";
                        echo "</td>";
                        echo "</tr>";
                    }
                    
                }
                echo "</table></div>";


                echo "<form action=\"$SITE_URL/inc/admin.php\" method=\"post\">";
                
                echo "<input type=hidden name=act value=edit_user_aka>";
                echo "<table border=0>";

                echo "<tr><td>New Key (All)</td><td><input type=text name=\"new_key\" value=\"\"> </td></tr>";

                echo "<tr><td>Value</td><td><input type=text name=\"new_value\" value=\"\"></td></tr>";
                
                echo "<tr><td></td><td><input type=submit name=\"Add Key\"  value=\"Add Key\"></td></tr>";
                echo "</table>";                
                
                break;

            case "top_menu_edit":
                echo "<h1>ADMINISTRATION PANEL >> ";
                echo "TOP MENU";
                echo "</h1><br>";

                warn("THIS IS UNDER CONSTRUCTION... DO NOT USE. (MANUALLY EDIT s/top_menu.php)");

                echo "<form action=\"$SITE_URL/inc/admin.php\" method=\"post\">";
                
                echo "<input type=hidden name=act value=top_menu_edit_go>";
                echo "<table border=0>";

                foreach($SITE_TOP_MENU as $k => $v) {                
                    echo "<tr>";
                    echo "<td>";
                    echo "<a href=\"$SITE_URL/inc/admin.php?act=top_menu_edit_r&i=$k\"><img src=\"$SITE_URL/images/system/x-button.png\" width=16 height=16></a>";
                    echo "</td>";
                    echo "<td>$k</td>";
                    
                    echo "<td><input type=text name=\"var[$k][name]\" value=\"$k\"></td>";
                    echo "<td><input type=text name=\"var[$k][url]\" value=\"".$v["URL"]."\"></td>";
                    echo "<td><input type=text name=\"var[$k][pri]\" value=\"".$v["PRI"]."\"></td>";
                    echo "</tr>";
                }
                
                
                echo "<tr><td></td><td><td></td></td><td></td><td><input type=submit name=\"UPDATE\"  value=\"UPDATE\"></td></tr>";
                echo "</table>";                
                                

                break;

            case "top_menu_edit_go":

                echo "<h1>ADMINISTRATION PANEL >> ";
                echo "TOP MENU >> UPDATE";
                echo "</h1><br>";

                foreach($SITE_TOP_MENU as $k => $v) {
                    $x=$_REQUEST["var"][$k];
                    if( $x["name"] != $k) {
                        echo "FOUND ".$x['name']." != ".$k."<br>";
                        $SITE_TOP_MENU[$x['name']]=Array(); // $k;
                        $SITE_TOP_MENU[$x['name']]["NAME"]=$k;
                        $SITE_TOP_MENU[$x['name']]["URL"]=$x['url'];
                        $SITE_TOP_MENU[$x['name']]["PRI"]=$x['pri'];
                        
                    }
                }
                $file="$SITE_FOLDER/top_menu.php";
                
                file_put_contents($file,"<?php\n\$SITE_TOP_MENU = ".var_export($SITE_TOP_MENU, true).";\n ");

                break;

            case "top_menu_edit_r":
                echo "<h1>ADMINISTRATION PANEL >> ";
                echo "TOP MENU >> REMOVE ITEM";
                echo "</h1><br>";
                $i=$_REQUEST["i"];
                $file="$SITE_FOLDER/top_menu.php";
                echo "rm $i from $file<br>";
                unset($SITE_TOP_MENU[$i]);
                file_put_contents($file,"<?php\n\$SITE_TOP_MENU = ".var_export($SITE_TOP_MENU, true).";\n ");
                break;

            case "left_menu_edit":
                echo "<h1>ADMINISTRATION PANEL >> ";
                echo "LEFT MENU";
                echo "</h1><br>";

                warn("THIS IS UNDER CONSTRUCTION... DO NOT USE. (MANUALLY EDIT s/left_menu.php)");

                echo "<form action=\"$SITE_URL/inc/admin.php\" method=\"post\">";
                
                echo "<input type=hidden name=act value=left_menu_edit_go>";
                echo "<table border=0>";

                // echo "<tr><td>New Key (All)</td><td><input type=text name=\"new_key\" value=\"\"> </td></tr>";
                // echo "<tr><td>Value</td><td><input type=text name=\"new_value\" value=\"\"></td></tr>";
                
                echo "<tr><td></td><td><input type=submit name=\"Add Item\"  value=\"Add Item\"></td></tr>";
                echo "</table>";                                

                break;

            default:
            
                warn("<h2>$act >> UNFINISHED</h2>");
        }


    }
    else {
        if(!isset($_REQUEST["act_ext"])) {

        echo "<h1>ADMINISTRATION PANEL</h1>";

        echo "<table border=0 cellspacing=10 cellpadding=10>";
        echo "<tr><td id=tda>";

        echo "</td><td id=tda>";
        put_icon("$SITE_URL/images/system/user_edit.png",64,64,"USER<br>EDIT","$SITE_URL/inc/admin.php?act=user_edit");

        echo "</td><td id=tda>";
        put_icon("$SITE_URL/images/system/menu.png",64,64,"TOP<br>MENU","$SITE_URL/inc/admin.php?act=top_menu_edit");

        echo "</td><td id=tda>";
        put_icon("$SITE_URL/images/system/menu.png",64,64,"LEFT<br>MENU","$SITE_URL/inc/admin.php?act=left_menu_edit");

        echo "</td><td id=tda>";
        put_icon("$SITE_URL/images/system/admin_debug.png",64,64,"Toggle<br>DEBUG","$SITE_URL/inc/admin.php?toggle_debug=1");

        echo "</td><td id=tda>";
        put_icon("$SITE_URL/images/system/admin_debug.png",64,64,"Toggle<br>DEBUG VARS","$SITE_URL/inc/admin.php?toggle_debug_v=1");

        echo "</td></tr>";

        echo "<tr><td id=tda>";

        echo "</td><td id=tda>";
        put_icon("$SITE_URL/images/system/git.png",64,64,"GIT<br>PULL<br>UPDATE","$SITE_URL/inc/admin.php?act=gitpull");

        echo "</td><td id=tda>";
        put_icon("$SITE_URL/images/system/git.png",64,64,"GIT<br>LOG","$SITE_URL/inc/admin.php?act=gitlog");
        

        echo "</td><td id=tda>";
        

        echo "</td><td id=tda>";
        

        echo "</td><td id=tda>";
        

        echo "</td></tr>";

        echo "</table>";
        // echo "<hr>";
        }

        

        if(file_exists("$SITE_FOLDER/admin_extension.php")) {
            // warn("<h1>$SITE_NAME >> ADMIN</h1>");
            include("$SITE_FOLDER/admin_extension.php");
        }
       }
    
        
}
else{
    echo "Get out of here!";
}

include("footer.php");
