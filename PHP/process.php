<?php
include 'config.php';
$connectionString = "host=" . $config['DB_HOST'] . " port =5432 dbname=" . $config['DB_DATABASE'] . " user=" . $config['DB_USERNAME'] . " password=" . $config['DB_PASSWORD'];
$conn = pg_connect($connectionString);

if (!$conn) {
    echo 'Database Connection Failed!';
    exit();
}

// Add a record to database
if (isset($_POST['username'])) {
    $getName = $_POST['username'];  //get username
    $getAge = $_POST['age'];  //get age value
    $getEmail = $_POST['email'];  //get email value
    $query = "insert into userdata values('$getName',$getAge,'$getEmail')";
    $result = pg_query($conn, $query);  //run query
    if ($result) echo "Record Added Successfully";
    else echo 'failed';
}

// Delete a record from the database
if (isset($_POST['id'])) {
    $userId = $_POST['id'];
    $query = "DELETE FROM userdata where id='$userId'";
    $result = pg_query($conn, $query);
    if ($result) echo "Record Deleted Successfully";
    else echo 'Error occured while deleting record';
}
