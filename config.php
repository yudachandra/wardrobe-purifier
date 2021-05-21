<?php

$db_host = "45.90.230.195";
//$db_host = "srv116.niagahoster.com:2083";
$db_user = "u1427463_userwp";
$db_pass = "userwp123";
$db_name = "u1427463_WardrobePurifierDB";

try {
    //create PDO connection
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch(PDOException $e) {
    //show error
    die("Terjadi masalah: " . $e->getMessage());
}
