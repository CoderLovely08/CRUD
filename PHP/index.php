<?php
include 'config.php';
$connectionString = "host=" . $config['DB_HOST'] . " port =5432 dbname=" . $config['DB_DATABASE'] . " user=" . $config['DB_USERNAME'] . " password=" . $config['DB_PASSWORD'];
$conn = pg_connect($connectionString);

if (!$conn) {
    echo 'Database Connection Failed!';
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

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

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
        <div class="row d-flex justify-content-center">
            <div class="left-col  col-lg-6">
                <form action="" method="post">
                    <label for="username" class="form-label">Enter Name</label>
                    <input type="text" name="username" id="username" class="form-control col-lg-6" placeholder="Enter your Name" required>
                    <label for="age" class="form-label">Enter Age</label>
                    <input type="number" name="age" max="100" id="age" class="form-control col-lg-6" placeholder="Enter your Age" required>
                    <label for="email" class="form-label">Enter Email</label>
                    <input type="email" name="email" id="email" class="form-control col-lg-6" placeholder="Enter your Email" required>
                    <br>
                    <input type="submit" id="insert" value="Create" name="create" class="btn btn-outline-primary col-lg-2">
                </form>
            </div>
            <div class="right-col col-lg-12">
                <h2>Table Will be Displayed here</h2>
                <?php
                $query = 'SELECT * FROM userdata';
                $results = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());
                $row = pg_fetch_all($results);
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Email</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <?php
                    for ($i = 0; $i < count($row); $i++) {
                        echo '
                        <tr>
                        <td class=id-"' . $row[$i]['id'] . '">' . $row[$i]['id'] . '</td>
                        <td class=name-"' . $row[$i]['id'] . '">' . $row[$i]['name'] . '</td>
                        <td class=age-"' . $row[$i]['id'] . '">' . $row[$i]['age'] . '</td>
                        <td class=email-"' . $row[$i]['id'] . '">'  . $row[$i]['email'] . '</td>
                        <td><input type="submit" data-toggle="modal" data-target="#modalLoginForm" value="Update" id="update" name="update-' . $row[$i]['id'] . '" class="btn btn-outline-dark col-lg-4">
                        <input type="submit" value="Delete" id=delete name="delete-' . $row[$i]['id'] . '" class="btn btn-outline-danger col-lg-4"></td>
                        </tr>';
                        echo "\n";
                    }

                    ?>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

    <script>
        $(document).ready(function() {
            // ----------------------------------------------------
            //              To add a record
            // ----------------------------------------------------
            $("input[value='Create']").click(function() {
                var username = $('#username').val();
                var age = $('#age').val();
                var email = $('#email').val();
                var add = true;
                $.ajax({
                    url: 'process.php',
                    type: 'post',
                    data: {
                        add: add,
                        username: username,
                        age: age,
                        email: email
                    },
                    success: function(response) {
                        alert("Record Inserted Successfully!");
                        location.reload(true);
                    },
                    error: function(response) {
                        alert("Some error");
                    }
                }).fail(function(status) {
                    alert("error");
                });
                add = false;
            })

            // ----------------------------------------------------
            //              To update a record
            // ----------------------------------------------------
            $("input[value='Update']").click(function() {
                var id = $(this).attr("name");
                id = id.split('-');
                id = id[id.length - 1];
                var currentRow = $(this).closest("tr");
                var col1 = currentRow.find("td:eq(1)").text();
                var col2 = currentRow.find("td:eq(2)").text();
                var col3 = currentRow.find("td:eq(3)").text();
                populateModalData(id, col1, col2, col3);


            })

            function populateModalData(id, username, age, email) {
                $('#defaultForm-name').val(username);
                $('#defaultForm-age').val(age);
                $('#defaultForm-email').val(email);

                var updatedUsername;
                var updatedAge;
                var updatedEmail;
                $('input').on('change', function() {
                    updatedUsername = $('#defaultForm-name').val();
                    updatedAge = $('#defaultForm-age').val();
                    updatedEmail = $('#defaultForm-email').val();
                });
                var update = true;
                $('#updateRecord').click(function() {
                    $.ajax({
                        url: 'process.php',
                        type: 'post',
                        data: {
                            update: update,
                            id: id,
                            updatedUsername: updatedUsername,
                            updatedAge: updatedAge,
                            updatedEmail: updatedEmail
                        },
                        success: function(response) {
                            alert("Record Updated Successfully! with id: " + id);
                            location.reload(true);
                        }
                    });
                });
                update = false;
            }

            // ----------------------------------------------------
            //              To delete a record
            // ----------------------------------------------------
            $("input[value='Delete']").click(function() {
                var id = $(this).attr("name");
                id = id.split('-');
                id = id[id.length - 1];
                var isdelete = true;
                $.ajax({
                    url: 'process.php',
                    type: 'post',
                    data: {
                        delete: isdelete,
                        id: id
                    },
                    success: function(response) {
                        alert("Record deleted Successfully! with id: " + id);
                        location.reload(true);
                    }
                });
            })
            isdelete = false;
        });
    </script>

    <?php
    pg_close($conn);
    ?>

    <div class=" modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Sign in</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-3">
                        <i class="fas fa-envelope prefix grey-text"></i>
                        <input type="text" id="defaultForm-name" class="form-control validate" required>
                    </div>
                    <div class="md-form mb-3">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <input type="number" id="defaultForm-age" class="form-control validate" required>
                    </div>
                    <div class="md-form mb-3">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <input type="email" id="defaultForm-email" class="form-control validate" required>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button id="updateRecord" data-dismiss="modal" class="btn btn-default">Update</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>