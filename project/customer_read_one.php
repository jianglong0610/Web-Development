<?php
include 'check.php'
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>

<body>

    <!-- container -->
    <div class="container" style="background-image:url('image/background.jpg')">
        <?php
        include 'top_nav.php'
        ?>
        <div class="page-header">
            <h1>Read Customers</h1>
        </div>

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }
        if ($action == 'nodelete') {
            echo "<div class='alert alert-danger'>This customer cant be delete.</div>";
        }

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT * FROM customers WHERE id = :id ";
            $stmt = $con->prepare($query);

            // Bind the parameter
            $stmt->bindParam(":id", $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $Username = $row['Username'];
            $First_name = $row['First_name'];
            $Last_name = $row['Last_name'];
            $Gender = $row['Gender'];
            $Date_of_birth = $row['Date_of_birth'];
            $Account_status = $row['Account_status'];
            $image = $row['image'];

            // shorter way to do that is extract($row)
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>



        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Username</td>
                <td><?php echo htmlspecialchars($Username, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>First_name</td>
                <td><?php echo htmlspecialchars($First_name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Last_name</td>
                <td><?php echo htmlspecialchars($Last_name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td><?php echo htmlspecialchars($Gender, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Date_of_birth</td>
                <td><?php echo htmlspecialchars($Date_of_birth, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Account_status</td>
                <td><?php echo htmlspecialchars($Account_status, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Images</td>
                <td><img src="uploads/customer/<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php echo "<a href='customer_edit_details.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>"; ?>
                    <a href='customer_read.php' class='btn btn-danger'>Back to read customers</a>
                    <?php echo "<a href='customer_delete.php?id={$id}' onclick='delete_customers({$id});'  class='btn btn-danger'>Delete</a>"; ?>
                </td>
            </tr>
        </table>


    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>