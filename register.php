<?php
include("header.php");
debug_print(__FILE__."<br>");

dump_vars();

if(isset($_REQUEST["verify"])) {
    // verify=true
    // id=ZZID
    // name=ZZNAME
}


if(isset($_REQUEST["register"])) {
    echo "<hr>";
    echo "REGISTERING...<BR>";
    $usr=$_REQUEST["name"];
    $pw=md5($_REQUEST["psw"]); // md5 password
    $cpw=md5($_REQUEST["cpsw"]); // confirm md5 password
    $em=$_REQUEST["email"];
    $result=get_user_data($usr);

    if(!empty($result)) if($result["name"]!="null") {
        echo "User already exists!<br>";
		exit();
    }

    echo "Wut";
    if($pw!=$cpw) {
        echo "Passwords do not match.<br>";
        exit();
    }
    else {
        echo "Doing it...<br>";
        $id=time();
        $userdata=Array();
        $userdata["id"]=$id;
        $userdata["name"]=$usr;
        $userdata["pw"]=$pw;
        $userdata["email"]=$em;
        $userdata["profile_pic"]="empty";
        $userdata["profile_info"]="empty";
        $userdata["verified"]="false";            
        $userdata["website"]=" ";

        $arr=array('0'=>"new");
        $userdata["access"]=$arr;
        
        debug_print("inserted: $usr<br>");
        
        var_dump($userdata);

        echo"<br>";

        set_user_data($usr,$userdata);

        $message=$SITE_VERIFY_MESSAGE;
        $subject=$SITE_VERIFY_SUBJECT;
        $message=str_replace("ZZID",$id,$message);
        $message=str_replace("ZZNAME",$usr,$message);
        $mail = new Mail($SITE_SEND_EMAIL, $em, $subject, $message);
        $mail->Send();
    }

}


echo"<BR> Enter your details to register an account on $SITE_NAME<BR><BR>";

echo "
        <form action=\"register.php\" method=\"post\">
        
        <table border=0>
        <tr><td>Username</td><td><input type=\"text\" placeholder=\"Enter Username\" name=\"name\" required>
            <input type=\"hidden\" name=\"register\" value=\"true\"></td></tr>
            <tr><td>Email</td><td><input type=\"text\" placeholder=\"Email\" name=\"email\" required></td></tr>
            <tr><td>Password</td><td><input type=\"password\" placeholder=\"Enter Password\" name=\"psw\" required></td></tr>
            <tr><td>Confirm PW</td><td><input type=\"password\" placeholder=\"Enter Password\" name=\"cpsw\" required></td></tr>
            <tr><td></td><td><input type=\"submit\" value=Register></td></tr>
            
        </table>
       
        </form>
        ";




?>