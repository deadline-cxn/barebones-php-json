<?php
include("header.php");
debug_print(__FILE__."<br>");

echo"<BR> Enter your details to register an account on $SITE_NAME<BR><BR>";

echo "
        <form action=\"index.php\" method=\"post\">
        
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