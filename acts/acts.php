<?php
debug_print(__FILE__."<br>");
debug_print("USER DB[$SITE_USER_DB_FOLDER]<BR>");


if(isset($_REQUEST["logout"])) {
    session_destroy();
    echo "<meta http-equiv=\"refresh\" content=\"0; url=$SITE_URL\">";
}

if(isset($_REQUEST["uname"])) { // login request
    $usr=$_REQUEST["uname"];
    $pw=md5($_REQUEST["psw"]); // md5 password
    echo "PASSWORD HASH: $pw<BR>";
    $result=$USER_DB->getSingle($usr);
    if(!empty($result)) if($pw==$result["pw"]) {
         $_SESSION["LOGGED_IN"]=$usr;
    }
    echo "<meta http-equiv=\"refresh\" content=\"0; url=$SITE_URL\">";
}

if(isset($_REQUEST["register"])) {
    
    $usr=$_REQUEST["name"];
    $pw=md5($_REQUEST["psw"]); // md5 password
    $cpw=md5($_REQUEST["cpsw"]); // confirm md5 password
    $em=$_REQUEST["email"];

    $result=$USER_DB->getSingle($usr);

    if(!empty($result)) if($result["name"]!="null") {
        warn("User already exists!<br>");
    }
    else {
        if($pw!=$cpw) {
            warn("Passwords do not match.<br>");
        }
        else {
            $id=time();
            $userdata=Array();
            $userdata["meatloaf"]="1"; // this is needed to have a same key for everyone for lists
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
            $USER_DB->insert($userdata,$usr);


            $message=$SITE_VERIFY_MESSAGE;
            $subject=$SITE_VERIFY_SUBJECT;
            $message=str_replace("ZZID",$id,$message);
            $message=str_replace("ZZNAME",$usr,$message);
            $mail = new Mail($SITE_SEND_EMAIL, $em, $subject, $message);
            $mail->Send();
        }
    }
}
if(isset($_REQUEST["verify"])) {
    // verify=true
    // id=ZZID
    // name=ZZNAME




}



// {"Deadline":{"Deadline":{"pw":"ace88b2ab04c597120ba20e607ad105f"}}}


