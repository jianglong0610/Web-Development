<!DOCTYPE HTML>
<html>

<head>
    <title>create customer</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <script>
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>

</head>

<body>
    <!-- container -->
    <div class="container">

        <?php
        include 'top_nav.php'
        ?>

        <div class="page-header text-center">
            <h1>Create Customers</h1>
        </div>


        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        $Username = $First_name = $Last_name = $Date_of_birth = "";
        if ($_POST) {
            // include database connection
            $Username = $_POST['Username'];
            $Password = $_POST['Password'];
            $pass = $_POST['pass'];
            $First_name = $_POST['First_name'];
            $Last_name = $_POST['Last_name'];
            $Gender = $_POST['Gender'];
            $Date_of_birth = $_POST['Date_of_birth'];
            $Account_status = $_POST['Account_status'];
            $image = !empty($_FILES["image"]["name"])
                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                :"";
            $image = htmlspecialchars(strip_tags($image));
            $error_message = "";

            $flag = 0;
            if ($Username == "") {
                echo "Please enter your username";
                $flag = 1;
            }
            $space = " ";
            $word = $_POST['Username'];
            if (strpos($word, $space) !== false) {
                echo "Username not cannot have space !";
                $flag = 1;
            } elseif (strlen($Username) < 6) {
                echo "Username need at least 6 characters !";
                $flag = 1;
            }

            if ($Password == "") {
                echo "Please enter your password !";
                $flag = 1;
            } elseif (!preg_match('/[A-Z]/', $Password)) {
                echo "Password must include uppercase !";
                $flag = 1;
            } elseif (!preg_match('/[a-z]/', $Password)) {
                echo "Password must include lowercase !";
                $flag = 1;
            } elseif (!preg_match('/[0-9]/', $Password)) {
                echo "Password must include number !";
                $flag = 1;
            } elseif (strlen($Password) < 8) {
                echo "Password need at least 8 character !";
                $flag = 1;
            }

            if ($pass == "") {
                echo "Please enter to comfirm password !";
                $flag = 1;
            } elseif ($Password != $pass) {
                echo "Password need to same with comfirm password !";
                $flag = 1;
            }

            if ($First_name == "") {
                echo "Please enter your first name !";
                $flag = 1;
            }

            if ($Last_name == "") {
                echo "Please enter your last name !";
                $flag = 1;
            }

            if ($Gender == "") {
                echo "Please select your gender !";
                $flag = 1;
            }

            if ($Date_of_birth == "") {
                echo "Please select your date of birth !";
                $flag = 1;
            }
            $day = $_POST['Date_of_birth'];
            $today = date("Ymd");
            $date1 = date_create($day);
            $date2 = date_create($today);
            $diff = date_diff($date1, $date2);
            if ($diff->format("%y") <= "18") {
                echo "User need 18 years old and above";
                $flag = 1;
            }

            if ($Account_status == "") {
                echo "Please enter your account status";
                $flag = 1;
            }

            if ($_FILES["image"]["name"]) {

                // upload to file to folder
                $target_directory = "uploads/customer/";
                $target_file = $target_directory . $image;
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                // make sure that file is a real image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check === false) {
                    $error_message .= "<div class='alert alert-danger'>Submitted file is not an image.</div>";
                }
                // make sure certain file types are allowed
                $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                if (!in_array($file_type, $allowed_file_types)) {
                    $error_message .= "<div class='alert alert-danger'>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                }
                // make sure file does not exist
                if (file_exists($target_file)) {
                    $error_message .= "<div class='alert alert-danger'>Image already exists. Try to change file name.</div>";
                }
                // make sure submitted file is not too large, can't be larger than 1 MB
                if ($_FILES['image']['size'] > (1024000)) {
                    $error_message .= "<div class='alert alert-danger'>Image must be less than 1 MB in size.</div>";
                }
                // make sure the 'uploads' folder exists
                // if not, create it
                if (!is_dir($target_directory)) {
                    mkdir($target_directory, 0777, true);
                }
                // if $file_upload_error_messages is still empty
                if (empty($error_message)) {
                    // it means there are no errors, so try to upload the file
                    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $error_message .= "<div class='alert alert-danger>Unable to upload photo.</div>";
                        $error_message .= "<div class='alert alert-danger>Update the record to upload photo.</div>";
                    }
                }
            }

            if($image == null){
                $image = "profile.jpg";
            }

            if (!empty($error_message)) {
                echo "<div class='alert alert-danger'>{$error_message}</div>";
            }

            if ($flag == 0) {

                include 'config/database.php';
                try {
                    // insert query
                    $query = "INSERT INTO customers SET Username=:Username, Password=:Password, First_name=:First_name, Last_name=:Last_name, Gender=:Gender, Date_of_birth=:Date_of_birth, Account_status=:Account_status, image=:image";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':Username', $Username);
                    $stmt->bindParam(':Password', $Password);
                    $stmt->bindParam(':First_name', $First_name);
                    $stmt->bindParam(':Last_name', $Last_name);
                    $stmt->bindParam(':Gender', $Gender);
                    $stmt->bindParam(':Date_of_birth', $Date_of_birth);
                    $stmt->bindParam(':Account_status', $Account_status);
                    $stmt->bindParam(':image', $image);
                    // Execute the query
                    if ($stmt->execute()) {
                        header("Location: customer_read.php?update");
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }

                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            }
        }
        ?>

        <!-- html form here where the product information will be entered -->

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='Username' value='<?php echo $Username ?>' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='Password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Comfirm Password</td>
                    <td><input type='password' name='pass' class='form-control' /></td>
                </tr>
                <tr>
                    <td>First_name</td>
                    <td><input type='text' name='First_name' value='<?php echo $First_name ?>' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last_name</td>
                    <td><input type='text' name='Last_name' value='<?php echo $Last_name ?>' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="female" name="Gender" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Female
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="male" name="Gender">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Male
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Date of birth</td>
                    <td><input type='date' name='Date_of_birth' value='<?php echo $Date_of_birth ?>' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account status</td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="opened" name="Account_status" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Opened
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="closed" name="Account_status">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Closed
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td><input type="file" name="image" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>