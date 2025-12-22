<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "listings";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn -> connect_error )                     
    die("<html><body> Could not connect to database. </body></html>");

?>