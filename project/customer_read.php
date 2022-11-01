<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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

        <div class="page-header">
            <h1>Read Customer</h1>
        </div>

        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here

        // select all data
        $query = "SELECT id, Username, First_name, Last_name, Gender , Date_of_birth , Account_status FROM customers ORDER BY id DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='create_customer.php' class='btn btn-primary m-b-1em'>Create New Customers</a>";

        //check if more than 0 record found
        if ($num > 0) {

            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Username</th>";
            echo "<th>First name</th>";
            echo "<th>Last name</th>";
            echo "<th>Gender</th>";
            echo "<th>Date of birth</th>";
            echo "<th>Account status</th>";
            echo "</tr>";

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$Username}</td>";
                echo "<td>{$First_name}</td>";
                echo "<td>{$Last_name}</td>";
                echo "<td>{$Gender}</td>";
                echo "<td>{$Date_of_birth}</td>";
                echo "<td>{$Account_status}</td>";
                echo "<td>";
                // read one record
                echo "<a href='customer_read_one.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='product_update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_product({$id});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }


            // end table
            echo "</table>";
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>


    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>