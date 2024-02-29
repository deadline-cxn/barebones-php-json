<?php

function get_user_list() {
  $users=Array();
  $p=$GLOBALS["SITE_JSON_USERS"];
  $x=scandir("$p");
  foreach($x as $k => $v) {
    if(($v!=".") && ($v!=".."))
      $users[$v]=$v;
  }
  return $users;
}

function get_user_data($user) {
  $p=$GLOBALS["SITE_JSON_USERS"];
  $user=strtolower($user);
  $file="$p/$user/$user.json";
  $USER_DATA = @json_decode(file_get_contents($file), true);
  return $USER_DATA;
}

function set_user_data($user,$USER_DATA) {
  $p=$GLOBALS["SITE_JSON_USERS"];
  $user=strtolower($user);
  @mkdir("$p/$user");
  $file="$p/$user/$user.json";
  
  
  foreach($USER_DATA as $k => $v) {
    if(!is_array($v)) {
      $USER_DATA[$k]=str_ireplace("<?php","*YOU CAN NOT USE PHP FOR THIS*", $USER_DATA[$k]);
      $USER_DATA[$k]=str_ireplace("?>","*YOU CAN NOT USE PHP FOR THIS*", $USER_DATA[$k]);
      $USER_DATA[$k]=str_ireplace("<","&lt;", $USER_DATA[$k]);
      $USER_DATA[$k]=str_ireplace(">","&gt;", $USER_DATA[$k]);
    }
    else {

    }
  }

  $x=json_encode($USER_DATA, JSON_PRETTY_PRINT);
  file_put_contents($file,$x);
}

function access($ax) {
  if(!isset($_SESSION["LOGGED_IN"])) return false;
  $user=$_SESSION["LOGGED_IN"];
  $USER_DATA = get_user_data($user);
  foreach($USER_DATA["access"] as $k => $v) {
      debug_print("[$k]=[$v]");
      if($v==$ax)
          return true;
  }
  return false;
}


