<?php
include 'config.php';
$connectionString = "host=" . $config['DB_HOST'] . " port =5432 dbname=" . $config['DB_DATABASE'] . " user=" . $config['DB_USERNAME'] . " password=" . $config['DB_PASSWORD'];
$conn = pg_connect($connectionString);

if (!$conn) {
    echo 'Database Connection Failed!';
    exit();
}

$add = $_POST['add'];
$delete = $_POST['delete'];
$update = $_POST['update'];

// Add a record to database
if ($add) {
    $getName = $_POST['username'];  //get username
    $getAge = $_POST['age'];  //get age value
    $getEmail = $_POST['email'];  //get email value
    $query = "insert into userdata values('$getName',$getAge,'$getEmail')";
    $result = pg_query($conn, $query);  //run query
    if ($result) echo "Record Added Successfully";
    else echo 'failed';
}

// Delete a record from the database
if ($delete) {
    $userId = $_POST['id'];
    $query = "DELETE FROM userdata where id='$userId'";
    $result = pg_query($conn, $query);
    if ($result) echo "Record Deleted Successfully";
    else echo 'Error occured while deleting record';
}

// update record
if ($update) {
    $userId = $_POST['id'];
    $getName = $_POST['updatedUsername'];  //get username
    $getAge = $_POST['updatedAge'];  //get age value
    $getEmail = $_POST['updatedEmail'];  //get email value

    $filename = 'test.txt';

    $contents = "username: " . $getName . " Age: '$getAge' Email: $getEmail ";

    file_put_contents($filename, $contents);

    $query = "UPDATE userdata SET name ='$getName',age='$getAge' ,email='$getEmail'  WHERE id=$userId";
    $result = pg_query($conn, $query);
    if ($result) echo "Record Updated Successfully";
}
