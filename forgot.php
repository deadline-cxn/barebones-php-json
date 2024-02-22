<?php
include("header.php");
debug_print(__FILE__."<br>");

echo "<br>";
echo "Forgot password...";

if(!empty($_REQUEST["act"])) {
    if($_REQUEST["act"]=="forgot") {

        $email=$_REQUEST["email"];
        $query = [
            "email" => "$email"
        ];
        @$user=$USER_DB->getList($query);
        $email_found="";
        foreach($user as $k => $v) {
            echo "$k<br>";
            if(is_array($v)) {
                foreach($v as $kk => $vv) {
                    if($kk=="email") {
                        $email_found=$vv;
                        $usr=$k;
                        echo "emf $email_found<br>";
                    }
                }
            }
        }

        if(!empty($email_found)) {
            $rp=randomPassword();
            echo "<br>GENERATING RANDOM PASSWORD: [$rp] <br>";

            $user[$usr]["pw"]=md5($rp);



            $USER_DB->update($user[$usr],$user[$usr]["name"]);


            if(!empty($user["email"])) {
                echo "FETCHING ".$user["name"]."...<br>";
                echo " ".$user["email"]."...<br>";
            }
        }
    }

}
else {
    echo "
    <form action=forgot.php>
    <input type=hidden name=act value=forgot>
    Enter your email address: <input type=text name=email>
    <input type=submit name=\"Go\" value=\"Go\">
    </form>
    ";
}




include("footer.php");
