<!DOCTYPE HTML>
<html>

<head>
    <title>Order</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <div class="container">
        <!-- container -->
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
    </div>
    </nav>
    <div class="container">

        <div class="page-header d-flex justify-content-center my-3">
            <h1>Create Order</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        include 'config/database.php';
        if ($_POST) {
            $customer_order = $_POST['customer_order'];
            $product_1 = $_POST['product_1'];
            $product_2 = $_POST['product_2'];
            $product_3 = $_POST['product_3'];
            $quantity_1 = $_POST['quantity_1'];
            $quantity_2 = $_POST['quantity_2'];
            $quantity_3 = $_POST['quantity_3'];
            $pass = true;
            $price_1 = 0;
            $price_2 = 0;
            $price_3 = 0;
            $total_amount = 0;
            if ($customer_order == "Select Customer") {
                echo "<div class='alert alert-danger'>You must to select customer.</div>";
                $pass = false;
            }
            if ($product_1 == "Please select product") {
                echo "<div class='alert alert-danger'>You must to select at least 1 product.</div>";
                $pass = false;
            }
            if ($product_1 == "Earphone") {
                $price_1 = 7;
            } else if ($product_1 == "Mouse") {
                $price_1 = 11.35;
            } else if ($product_1 == "Basketball") {
                $price_1 = 49.99;
            }
            if ($product_2 == "Earphone") {
                $price_2 = 7;
            } else if ($product_2 == "Mouse") {
                $price_2 = 11.35;
            } else if ($product_2 == "Basketball") {
                $price_2 = 49.99;
            } else if ($product_2 == "Please select product") {
                $product_2 = null;
                $price_2 = 0;
            }
            if ($product_3 == "Earphone") {
                $price_3 = 7;
            } else if ($product_3 == "Mouse") {
                $price_3 = 11.35;
            } else if ($product_3 == "Basketball") {
                $price_3 = 49.99;
            } else if ($product_3 == "Please select product") {
                $product_3 = null;
                $price_3 = 0;
            }

            $total_amount += (((int)$price_1 * (int)$quantity_1) + ((int)$price_2 * (int)$quantity_2) + ((int)$price_3 * (int)$quantity_3));

            if ($pass == true) {
                try {

                    // insert query
                    $query = "INSERT INTO order_summary SET customer_order=:customer_order, total_amount=:total_amount, order_date=:order_date";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':customer_order', $customer_order);
                    $stmt->bindParam(':total_amount', $total_amount);
                    $order_date = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':order_date', $order_date);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Your product total price is RM$total_amount</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
                try {
                    // insert query
                    $query = "INSERT INTO order_details SET product_1=:product_1, product_2=:product_2, product_3=:product_3, quantity_1=:quantity_1, quantity_2=:quantity_2, quantity_3=:quantity_3, price_1=:price_1, price_2=:price_2, price_3=:price_3";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':product_1', $product_1);
                    $stmt->bindParam(':product_2', $product_2);
                    $stmt->bindParam(':product_3', $product_3);
                    $stmt->bindParam(':quantity_1', $quantity_1);
                    $stmt->bindParam(':quantity_2', $quantity_2);
                    $stmt->bindParam(':quantity_3', $quantity_3);
                    $stmt->bindParam(':price_1', $price_1);
                    $stmt->bindParam(':price_2', $price_2);
                    $stmt->bindParam(':price_3', $price_3);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
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
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <?php
            $query = "SELECT id, name, description, price FROM products ORDER BY id DESC";
            $stmt = $con->prepare($query);
            $stmt->execute();

            // this is how to get number of rows returned
            $num = $stmt->rowCount();
            //check if more than 0 record found
            if ($num > 0) {

                // data from database will be here
                echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

                //creating our table heading
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Price</th>";
                echo "</tr>";

                // table body will be here
                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // extract row
                    // this will make $row['firstname'] to just $firstname only
                    extract($row);
                    // creating new table row per record
                    echo "<tr>";
                    echo "<td>{$name}</td>";
                    echo "<td>{$price}</td>";
                    echo "</tr>";
                }


                // end table
                echo "</table>";
            } else {
                echo "<div class='alert alert-danger'>No records found.</div>";
            }
            ?>
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>customer_order</td>
                    <td colspan="3">
                        <select class="form-select form-select-lg mb-3" name="customer_order" aria-label=".form-select-lg example">
                            <option>Select Customer Order</option>
                            <?php
                            // include database connection
                            include 'config/database.php';
                            $query = "SELECT id, username FROM customers ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();

                            $num = $stmt->rowCount();
                            if ($num > 0) {


                                // table body will be here
                                // retrieve our table contents
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    // extract row
                                    // this will make $row['firstname'] to just $firstname only
                                    extract($row);
                                    // creating new table row per record

                                    echo "<option value=\"$username\">$username</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Product 1</td>
                    <td class="d-flex">
                        <select class="form-select form-select-lg mb-3 col" name="product_1" aria-label=".form-select-lg example">
                            <option>Please select product</option>
                            <?php
                            // include database connection
                            include 'config/database.php';
                            $query = "SELECT id, name, price FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();

                            $num = $stmt->rowCount();

                            if ($num > 0) {


                                // table body will be here
                                // retrieve our table contents
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    // extract row
                                    // this will make $row['firstname'] to just $firstname only
                                    extract($row);
                                    // creating new table row per record

                                    echo "<option value=\"$name\">$name</option>";
                                }
                            }
                            ?>
                        </select>


                    </td>
                    <td>Quantity</td>
                    <td><select class="form-select form-select-lg mb-3" name="quantity_1" aria-label=".form-select-lg example">
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Product 2</td>
                    <td class="d-flex justify-content-between">
                        <select class="form-select form-select-lg mb-3 col" name="product_2" aria-label=".form-select-lg example">
                            <option>Please select product</option>
                            <?php
                            // include database connection
                            include 'config/database.php';
                            $query = "SELECT id, name, price FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();

                            $num = $stmt->rowCount();
                            if ($num > 0) {


                                // table body will be here
                                // retrieve our table contents
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    // extract row
                                    // this will make $row['firstname'] to just $firstname only
                                    extract($row);
                                    // creating new table row per record

                                    echo "<option value=\"$name\">$name</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>Quantity</td>
                    <td><select class="form-select form-select-lg mb-3" name="quantity_2" aria-label=".form-select-lg example">
                            <option value=0>0</option>
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Product 3</td>
                    <td class="d-flex justify-content-between">
                        <select class="form-select form-select-lg mb-3 col" name="product_3" aria-label=".form-select-lg example">
                            <option>Please select product</option>
                            <?php
                            // include database connection
                            include 'config/database.php';
                            $query = "SELECT id, name, price FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();

                            $num = $stmt->rowCount();
                            if ($num > 0) {


                                // table body will be here
                                // retrieve our table contents
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    // extract row
                                    // this will make $row['firstname'] to just $firstname only
                                    extract($row);
                                    // creating new table row per record

                                    echo "<option value=\"$name\">$name</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>Quantity</td>
                    <td><select class="form-select form-select-lg mb-3" name="quantity_3" aria-label=".form-select-lg example">
                            <option value=0>0</option>
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                        </select></td>
                </tr>
                <td></td>
                <td colspan="3">
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='order_read.php' class='btn btn-danger'>Back to read order summary</a>
                    <a href='details_read.php' class='btn btn-danger'>Back to read order details</a>
                </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">

    </script>
</body>

</html>