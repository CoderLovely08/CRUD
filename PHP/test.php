<?php
include 'config.php';
$connectionString = "host=" . $config['DB_HOST'] . " port =5432 dbname=" . $config['DB_DATABASE'] . " user=" . $config['DB_USERNAME'] . " password=" . $config['DB_PASSWORD'];
$conn = pg_connect($connectionString);

if (!$conn) {
    echo 'Database Connection Failed!';
    exit();
}
$userId = $_POST['id'];
$getName = $_POST['username'];  //get username
$getAge = $_POST['age'];  //get age value
$getEmail = $_POST['email'];  //get email value

$query = "UPDATE userdata SET name ='$getName' WHERE id=$userId";
$result = pg_query($conn, $query);
$query = "UPDATE userdata SET age='$getAge' WHERE id=$userId";
$result = pg_query($conn, $query);
$query = "UPDATE userdata SET email='$getEmail' WHERE id=$userId";
$result = pg_query($conn, $query);
if ($result) echo "Record Updated Successfully";
else echo 'rr';
