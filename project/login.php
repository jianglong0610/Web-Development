<!DOCTYPE HTML>
<html>

<head>

    <title>Create Product</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body>

    <!-- container -->
    <div class="container">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <a class="navbar-brand" href="home.html">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/web/project/product_create.php#">Create Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/web/project/create_customer.php">Create Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create_new_order.php">Create Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product_read.php">Read Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customer_read.php">Read customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact Us</a>
                    </li>
                </ul>

            </div>
        </nav>
        <div class="page-header d-flex justify-content-center my-3">
            <h1>Login Page</h1>
        </div>

        <?php
        // include database connection
        include 'config/database.php';
        session_start();
        if (isset($_POST['Username']) && isset($_POST['Password'])) {

            $Username = ($_POST['Username']);
            $Password = ($_POST['Password']);

            $select = " SELECT Username, Password, account_status FROM customers WHERE Username = '$Username' && Password = '$Password' ";
            $result = mysqli_query($mysqli, $select);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) == 1) {

                if ($row['Username'] === $Username && $row['Password'] === $Password) {
                    if ($row['account_status'] != "opened") {
                        echo "<div class='alert alert-danger'>Your account is closed.</div>";
                    } else {
                        header("location:home.html");
                    }
                }
            }
            $findname = " SELECT Username FROM customers WHERE Username = '$Username'";
            $result2 = mysqli_query($mysqli, $findname);
            $row = mysqli_fetch_assoc($result2);
            if (mysqli_num_rows($result2) == 0) {
                echo "<div class='alert alert-danger'>Wrong Username.</div>";
            } else {
                $findpass = " SELECT Password FROM customers WHERE Password = '$Password'";
                $result3 = mysqli_query($mysqli, $findpass);
                $row = mysqli_fetch_assoc($result3);
                if (mysqli_num_rows($result3) == 0) {

                    echo "<div class='alert alert-danger'>Wrong Password.</div>";
                }
            }
        }
        ?>

        <div class="container d-flex justify-content-center mt-5">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <table class='table table-hover table-responsive table-bordered '>
                    <div class="form-floating  ">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="Username">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating ">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="Password">
                        <label for="floatingPassword">Password</label>
                    </div>

                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="w-50 btn btn-lg btn-primary" type="submit">Login</button>
                </table>
            </form>
        </div>

</body>

</html>