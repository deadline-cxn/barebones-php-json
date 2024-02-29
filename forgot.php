<?php
include("header.php");

echo "<br>";
echo "Forgot password...";

if(isset($_REQUEST["act"])) {
    if($_REQUEST["act"]=="forgot") {

        $user=$_REQUEST["name"];
        $USER_DATA=get_user_data($user);

        if(!empty($USER_DATA["email"])) {

            $rp=randomPassword();
            echo "<br>GENERATING NEW PASSWORD, Please check your email.<br>";
            $USER_DATA["pw"]=md5($rp);
            set_user_data($user,$USER_DATA);

            $subject="Meatloaf.cc new password...";
            $message="Your password was reset on Meatloaf.cc. <br>Please log in with the following credentials:<br>";
            $message.="User [$user]<br> Password [$rp]<br>";

            $mail = new Mail($SITE_SEND_EMAIL, $USER_DATA["email"], $subject, $message);
            $mail->Send();            
        }
    }

}
else {
    echo "
    <form action=forgot.php>
    <input type=hidden name=act value=forgot>
    Enter your site USER NAME: <input type=text name=name>
    <input type=submit name=\"Go\" value=\"Go\">
    </form>
    ";
}




include("footer.php");
