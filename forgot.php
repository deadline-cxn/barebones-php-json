<?php
include("header.php");
debug_print(__FILE__."<br>");

echo "<br>";
echo "Forgot password...";

if(!empty($_REQUEST["act"])) {
    if($_REQUEST["act"]=="forgot") {

        $email=$_REQUEST["email"];
        $query = [ "email" => "$email" ];

        // echo $email;
        @$user=get_user_list();
        echo "<br>";
        $email_found="";
        foreach($user as $k => $v) {
            $userdata=get_user_data($k);
            if($userdata["email"]==$email) {
                $email_found=$email;
                $usr=$k;
                echo "$email_found<br>";
            }
        }

        if(!empty($email_found)) {
            $rp=randomPassword();
            echo "<br>GENERATING NEW PASSWORD...<br>";
            $userdata["pw"]=md5($rp);
            set_user_data($usr,$userdata);
            $subject="Forgot Password -> $SITE_NAME";
            $message="
            Your username is: $usr.
            Your new password is:[$rp].
            You should login and change your password.
            $SITE_SEND_EMAIL";
            $mail = new Mail($SITE_SEND_EMAIL, $email, $subject, $message);
            $mail->Send();           
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
