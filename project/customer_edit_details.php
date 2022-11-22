<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <a class="navbar-brand" href="home.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Customer
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="create_customer.php">create customer</a></li>
                            <li><a class="dropdown-item" href="customer_read.php">read customer</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Order
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="create_new_order.php">create order</a></li>
                            <li><a class="dropdown-item" href="order_list.php">order list</a></li>
                            <li><a class="dropdown-item" href="order_details.php">order details</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Product
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="product_create.php">create product</a></li>
                            <li><a class="dropdown-item" href="product_read.php">read product</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact Us</a>
                    </li>
                </ul>
            </div>

        </nav>
        <div class="page-header">
            <h1>Update Customers</h1>
        </div>
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT * FROM customers WHERE id = :id";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(":id", $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            extract($row);
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!-- HTML form to update record will be here -->

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='Username' value="<?php echo htmlspecialchars($Username, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Old Password</td>
                    <td><input type='text' name='passw' class='form-control' /></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td><input type='text' name='new_pass' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Comfirm Password</td>
                    <td><input type='text' name='comfirm_password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='First_name' value="<?php echo htmlspecialchars($First_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='Last_name' value="<?php echo htmlspecialchars($Last_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <div><input disabled type='text' name="Gender" value="<?php echo htmlspecialchars($Gender, ENT_QUOTES);  ?>" /></div>
                        <div class="ms-4 col-2 form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="Gender" id="inlineRadio1" value="male" checked>
                            <label class="form-check-label" for="inlineRadio1">Male</label>
                        </div>
                        <div class="col-2 form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="Gender" id="inlineRadio2" value="female">
                            <label class="form-check-label" for="inlineRadio2">Female</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Birthday</td>
                    <td><input placeholder="Select birthday" type='date' name='Date_of_birth' value="<?php echo htmlspecialchars($Date_of_birth, ENT_QUOTES);  ?>" class='form-control ' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td>
                        <div><input disabled type='text' name="Account_status" value="<?php echo htmlspecialchars($Account_status, ENT_QUOTES);  ?>" /></div>
                        <div class="ms-4 col-2 form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="Account_status" id="inlineRadio3" value="active" checked>
                            <label class="form-check-label" for="inlineRadio3">Active</label>
                        </div>
                        <div class="col-2 form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="Account_status" id="inlineRadio4" value="closed">
                            <label class="form-check-label" for="inlineRadio4">Closed</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customers_read.php' class='btn btn-danger'>Back to read customers</a>
                    </td>
                </tr>
            </table>
        </form>
        <!-- PHP post to update record will be here -->
        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                $today = date("Y-m-d");
                $date1 = date_create($Date_of_birth);
                $date2 = date_create($today);
                $diff = date_diff($date1, $date2);
                $result = $diff->format("%a");
                $pass = true;
                $passw = $_POST['passw'];
                $new_pass = $_POST['new_pass'];
                $comfirm_password = $_POST['comfirm_password'];
                $select = "SELECT Password FROM customers WHERE id = :id ";
                $stmt = $con->prepare($select);

                // Bind the parameter
                $stmt->bindParam(":id", $id);
                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                }
                // values to fill up our form
                $space = " ";
                if (strlen($Username) < 6) {
                    echo "<div class='alert alert-danger'>Username should have at least 6 character.</div>";
                    $pass = false;
                }

                if (strpos($Username, $space) !== false) {
                    echo "<div class='alert alert-danger'>Username cannot space.</div>";
                    $pass = false;
                }
                $keeppass = false;
                if ($passw == "" && $new_pass == "" && $comfirm_password == "") {
                    $keeppass = true;
                } else {
                    if ($row['Password'] == $passw) {
                        $uppercase = preg_match('@[A-Z]@', $new_pass);
                        $lowercase = preg_match('@[a-z]@', $new_pass);
                        $number    = preg_match('@[0-9]@', $new_pass);
                        if (!$uppercase || !$lowercase || !$number || strlen($new_pass) < 8) {
                            echo "<div class='alert alert-danger'>Password should be at least 8 characters in length and should include at least one upper case letter, one number.</div>";
                            $pass = false;
                        }
                        if ($passw == $new_pass) {
                            echo "<div class='alert alert-danger'>Old Password cannot same with New Password.</div>";
                            $pass = false;
                        }
                        if ($new_pass != $comfirm_password) {
                            echo "<div class='alert alert-danger'>New Password and Comfirm Password not same.</div>";
                            $pass = false;
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Wrong Old Password</div>";
                        $pass = false;
                    }
                }


                if ($result < 6570) {
                    echo "<div class='alert alert-danger'>Only above 18 years old can save.</div>";
                    $pass = false;
                }
                if ($Date_of_birth > $today) {
                    echo "<div class='alert alert-danger'>You cannot input the future date</div>";
                    $pass = false;
                }
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                if ($pass == true) {
                    $query = "UPDATE customers
                  SET Username=:Username, Password=:new_pass, First_name=:First_name, Last_name=:Last_name, Gender=:Gender, Date_of_birth=:Date_of_birth, Account_status=:Account_status WHERE id = :id";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);
                    // posted values
                    $Username = htmlspecialchars(strip_tags($_POST['Username']));
                    if ($keeppass == true) {
                        $new_pass = $row['Password'];
                    } else {
                        $new_pass = htmlspecialchars(strip_tags($_POST['new_pass']));
                    }
                    $first_name = htmlspecialchars(strip_tags($_POST['First_name']));
                    $last_name = htmlspecialchars(strip_tags($_POST['Last_name']));
                    $gender = htmlspecialchars(strip_tags($_POST['Gender']));
                    $date_of_birth = htmlspecialchars(strip_tags($_POST['Date_of_birth']));
                    $account_status = htmlspecialchars(strip_tags($_POST['Account_status']));
                    // bind the parameters
                    $stmt->bindParam(':Username', $Username);
                    $stmt->bindParam(':new_pass', $new_pass);
                    $stmt->bindParam(':First_name', $First_name);
                    $stmt->bindParam(':Last_name', $Last_name);
                    $stmt->bindParam(':Gender', $Gender);
                    $stmt->bindParam(':Date_of_birth', $Date_of_birth);
                    $stmt->bindParam(':Account_status', $Account_status);
                    $stmt->bindParam(':id', $id);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } ?>

        <!--we have our html form here where new record information can be updated-->


    </div>
    <!-- end .container -->
</body>

</html>