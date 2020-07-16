<?php
$dsn = "mysql:host=localhost;dbname=quiz";
$user = "root";
$pass = '';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);
try{
  $connect  = new PDO($dsn, $user, $pass, $option);
  $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
  echo "Failed to Connect " . $e -> getMessage();
}
