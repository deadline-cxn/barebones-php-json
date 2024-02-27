<?php
include("inc/funcs.php");
$arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];

file_put_contents("FILES_DEBUG",get_vars($_REQUEST));
echo(get_vars($_REQUEST));
// if(isset($_FILES)) if(isset($_FILES['filez'])) if (!(in_array($_FILES['filez']['type'], $arr_file_types))) {     echo "error";     die; }

if(isset($_FILES))
    if(isset($_FILES['files'])) {
        $filename = time().'_'.$_FILES['files']['name'];
        move_uploaded_file($_FILES['files']['tmp_name'], 'uploads/'.$filename);
        echo 'uploads/'.$filename;
}
