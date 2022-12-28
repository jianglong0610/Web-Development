<?php
session_start();
?>
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
    <link href="css/login.css" rel="stylesheet">


</head>

<body>

    <div class="container-fluid box" style="background-image:url('image/lightblue_bg.jpg')">

        <div class="page-header d-flex justify-content-center">
            <h1 class="mt-5">Login Page</h1>
        </div>

        <?php
        include 'config/database.php';

        if (isset($_POST['Username']) && isset($_POST['Password'])) {

            $Username = ($_POST['Username']);
            $Password = md5($_POST['Password']);

            $select = "SELECT Username, Password, Account_status FROM customers WHERE Username = '$Username'";
            $result = mysqli_query($mysqli, $select);
            $row = mysqli_fetch_assoc($result);

            if (mysqli_num_rows($result) == 1) {
                if ($row['Password'] != $Password) {
                    echo "<div class='alert alert-danger w-25 d-flex justify-content-center align-self-center ms-auto me-auto'>Your password is incorrect.</div>";
                } elseif ($row['Account_status'] != "opened") {
                    echo "<div class='alert alert-danger w-25 d-flex justify-content-center align-self-center ms-auto me-auto'>Your account is closed.</div>";
                } else {
                    header("Location: index.php");
                    $_SESSION["Pass"] = "Pass";
                }
            } else {
                echo "<div class='alert alert-danger w-25 d-flex justify-content-center align-self-center ms-auto me-auto'>Wrong user name.</div>";
            }
        };

        if ($_GET) {
            echo "<div class='alert alert-danger w-25 d-flex justify-content-center align-self-center ms-auto me-auto'>Please make sure you have access.</div>";
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


                    <button class="w-50 btn btn-lg btn-primary mt-3 d-flex justify-content-center align-self-center ms-auto me-auto" type="submit">Login</button>

                </table>
                <div class="d-flex justify-content-center align-self-center">
                    <a href="create_customer.php">Register now</a>
                </div>
            </form>

        </div>

</body>

</html>