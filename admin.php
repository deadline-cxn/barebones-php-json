<?php
include("header.php");
debug_print(__FILE__."<br>");

$access=access("admin");
if($access) {

    if(isset($_REQUEST["toggle_debug"])) {
        if(isset($_SESSION["DEBUG"])) unset($_SESSION["DEBUG"]);
        else $_SESSION["DEBUG"]="true";
        echo "<meta http-equiv=\"refresh\" content=\"0; url=$SITE_URL/admin.php\">";
    }

    if(isset($_REQUEST["toggle_debug_v"])) {
        if(isset($_SESSION["DEBUG_VARS"])) unset($_SESSION["DEBUG_VARS"]);
        else $_SESSION["DEBUG_VARS"]="true";
        echo "<meta http-equiv=\"refresh\" content=\"0; url=$SITE_URL/admin.php\">";
    }

    if(isset($_REQUEST["act"])) {
        $act=$_REQUEST["act"];

        switch($act) {
            

            case "user_edit_i":

                $usr=$_REQUEST["user"];
                echo "<h1>ADMINISTRATION PANEL >> ";
                echo "EDITING USER: $usr";
                echo "</h1>";
                
                $result=$USER_DB->getSingle($usr);
                

                echo "<form action=\"admin.php\" method=\"post\">";
                $output="<input type=hidden name=act value=user_edit_go>";

                echo "<table border=0>";

                foreach($result as $k => $v) {

                    if( ($k!="meatloaf") && 
                        ($k!="id") 
                     ) {

                        $output.="<tr><td> ";
                        $output.="<a href=\"admin.php?act=remove_user_key&user=$usr&key=$k\"><img src=\"images/system/x-button.png\" width=16 height=16 alt=\"Delete key\"></a>";
                        $output.="$k</td><td><input type=text name=\"$k\" value=\"";

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
                echo "</table>";                
                echo "</form>";

                echo "<form action=\"admin.php\" method=\"post\">";
                
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
                
                // predump($USER_DATA);

                $act="user_edit";
                $USER_DB->update($USER_DATA,$usr);


                echo "<meta http-equiv=\"refresh\" content=\"0; url=$SITE_URL/admin.php?act=user_edit\">";
                
                

                break;


            case "user_edit_d":
                echo "<h1>ADMINISTRATION PANEL >> ";
                $usr=$_REQUEST["user"];
                echo "DELETE USER: $usr";
                echo "</h1>";
                are_you_sure("admin.php?act=user_edit_dg&user=$usr");
                break;

            case "user_edit_dg":
                $usr=$_REQUEST["user"];
                if(!empty($_REQUEST["Yes"])) {
                    warn("<h2>DELETING USER: $usr</h2>");
                    $USER_DB->delete($usr);

                }               
            
            case "user_edit":

                echo "<h1>ADMINISTRATION PANEL >> ";
                echo "EDIT USERS";
                echo "</h1><br>";

                $query = [
                    "meatloaf" => "1"
                ];
                $result2 = $USER_DB->getList($query);

                $lc=0;

                echo "<table border=0 cellspacing=0 cellpadding=10>";
                echo"<tr id=tr$lc><td></td><td></td><td>USER</td><td>EMAIL</td><td>ACCESS</td></tr>";
                
                foreach($result2 as $k => $v) {
                    $lc++; if($lc>1) $lc=0;
                    echo "<tr id=tr$lc><td>";
                    echo "<a href=\"admin.php?act=user_edit_i&user=$k\"><img src=\"images/system/pen.png\" width=16 height=16></a>";
                    echo "</td><td>";
                    echo "<a href=\"admin.php?act=user_edit_d&user=$k\"><img src=\"images/system/x-button.png\" width=16 height=16></a>";
                    echo "</td><td>";
                    echo "$k";
                    echo"</td><td>";
                    echo $v["email"];
                    echo"</td><td>";
                    foreach($v["access"] as $kk => $vv)
                        echo "$vv ";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";


                echo "<form action=\"admin.php\" method=\"post\">";
                
                echo "<input type=hidden name=act value=edit_user_aka>";
                echo "<table border=0>";

                echo "<tr><td>New Key (All)</td><td><input type=text name=\"new_key\" value=\"\"> </td></tr>";

                echo "<tr><td>Value</td><td><input type=text name=\"new_value\" value=\"\"></td></tr>";
                
                echo "<tr><td></td><td><input type=submit name=\"Add Key\"  value=\"Add Key\"></td></tr>";
                echo "</table>";                
                
                break;

            case "sc_edit":

                break;

            default:
            
                warn("<h2>$act >> UNFINISHED</h2>");
        }


    }
    else {

        echo "<h1>ADMINISTRATION PANEL</h1>";

        echo "<table border=0 cellspacing=10 cellpadding=10>";
        echo "<tr><td id=tda>";

        echo "</td><td id=tda>";

        put_icon("images/system/user_edit.png",64,64,"USER<br>EDIT","admin.php?act=user_edit");

        echo "</td><td id=tda>";
        put_icon("images/system/sc_edit.png",64,64,"SHORT<br>CODE EDIT","admin.php?act=sc_edit");

        echo "</td><td id=tda>";
        put_icon("images/system/admin_debug.png",64,64,"Toggle<br>DEBUG","admin.php?toggle_debug=1");

        echo "</td><td id=tda>";
        put_icon("images/system/admin_debug.png",64,64,"Toggle<br>DEBUG VARS","admin.php?toggle_debug_v=1");

        echo "</td></tr>";
        echo "</table>";
   
    }
    
        
}
else{
    echo "Get out of here!";
}

include("footer.php");