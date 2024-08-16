<?php 


$host='localhost';
$dbname='mysql';
$user='root';
$password='';
$mydb='furniture';


require_once "db.php";
$con = new Connection($host, $dbname, $user, $password);
$pdo = $con->getConnection();

if($pdo){
    // echo "Connection Successful.";
    $connect_sql = "CREATE DATABASE IF NOT EXISTS $mydb";
    $pdo->exec($connect_sql);
    $pdo->exec("USE $mydb");
    // echo "Database Created";
}