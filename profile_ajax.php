<?php
include("inc/funcs.php");
$arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];

file_put_contents("FILES_DEBUG",get_vars($_FILES));
 
if(isset($_FILES))
if(isset($_FILES['file']))
if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
    echo "error";
    die;
}

if(isset($_FILES))
    if(isset($_FILES['file'])) {
        $filename = time().'_'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$filename);
        echo 'uploads/'.$filename;
}




die;