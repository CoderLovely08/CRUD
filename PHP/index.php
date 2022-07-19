<?php
include 'config.php';
$connectionString = "host=" . $config['DB_HOST'] . " port =5432 dbname=" . $config['DB_DATABASE'] . " user=" . $config['DB_USERNAME'] . " password=" . $config['DB_PASSWORD'];
$conn = pg_connect($connectionString);

if (!$conn) {
    echo 'Database Connection Failed!' ;
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        .left-col,
        .right-col {
            padding: 2%;
            border: 2px solid;
            border-radius: 2%;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 style="text-align: center;"> PHP CRUD</h1>
        <div class="row">
            <div class="left-col col-lg-6 col-md-6">
                <form action="" method="post">
                    <label for="username" class="form-label">Enter Name</label>
                    <input type="text" name="username" id="username" class="form-control col-lg-6" placeholder="Enter your Name" >
                    <label for="age" class="form-label">Enter Age</label>
                    <input type="number" name="age" max="100" id="age" class="form-control col-lg-6" placeholder="Enter your Age" >
                    <label for="email" class="form-label">Enter Email</label>
                    <input type="email" name="email" id="email" class="form-control col-lg-6" placeholder="Enter your Email" >
                    <br>
                    <input type="submit" value="Create" name="create" class="btn btn-outline-primary col-lg-2">
                    <input type="submit" value="Read" name="read" class="btn btn-outline-warning col-lg-2">
                    <input type="submit" value="Update" name="update" class="btn btn-outline-dark col-lg-2">
                    <input type="submit" value="Delete" name="delete" class="btn btn-outline-danger col-lg-2">
                </form>
            </div>
            <div class="right-col col-lg-6 col-md-6">
                <h2>Table Will be Displayed here</h2>
                <?php
                if (isset($_POST['create'])) {
                    $getName = $_POST['username'];  //get username
                    $getAge = $_POST['age'];  //get age value
                    $getEmail = $_POST['email'];  //get email value
                    $query = "insert into userdata values('$getName',$getAge,'$getEmail')";
                    $result = pg_query($conn, $query);  //run query
                    if ($result) echo "Record Added Successfully";
                    else echo 'failed';
                };

                if (isset($_POST['read'])) {
                    $query = 'SELECT * FROM userdata';
                    $results = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());
                    $row = pg_fetch_all($results);
                ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                    <?php
                    for ($i = 0; $i < count($row); $i++) {
                        echo '
                        <tr>
                        <td>' . $row[$i]['name'] . '</td>
                        <td>' . $row[$i]['age'] . '</td>
                        <td>' . $row[$i]['email'] . '</td>                                                    
                        </tr>';
                        echo "\n";
                    }
                }
                if (isset($_POST['update'])) {
                    $getName = $_POST['username'];  //get username
                    $getAge = $_POST['age'];  //get age value
                    $getEmail = $_POST['email'];  //get email value
                    $query = "update userdata set email='$getEmail' where name='$getName'";
                    $result = pg_query($conn, $query);
                    if ($result) echo "Record Updated Successfully";
                    else echo 'Error occured while updating record';
                }
                if (isset($_POST['delete'])) {
                    $getName = $_POST['username'];  //get username
                    $getAge = $_POST['age'];  //get age value
                    $getEmail = $_POST['email'];  //get email value
                    $query = "DELETE FROM userdata where name='$getName'";
                    $result = pg_query($conn, $query);
                    if ($result) echo "Record Deleted Successfully";
                    else echo 'Error occured while deleting record';
                }
                    ?>
            </div>
        </div>
    </div>
    <?php
    pg_close($conn);
    ?>
</body>

</html>