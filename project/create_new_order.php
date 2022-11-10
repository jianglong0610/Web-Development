<?php
include 'check.php'
?>
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
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $flag = true;

            if ($customer_order == 'Select Customer Order') {
                echo "<div class='alert alert-danger'>Please choose your order.</div>";
                $flag = false;
            }
            if ($product_id == 'Please select product') {
                echo "<div class='alert alert-danger'>Please choose your product.</div>";
                $flag = false;
            }
            if ($quantity == 0) {
                echo "<div class='alert alert-danger'>The quantity cannot be 0</div>";
                $flag = false;
            }

            if ($flag == true) {


                try {

                    // insert query
                    $query = "INSERT INTO order_summary SET customer_order=:customer_order , order_date=:order_date";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':customer_order', $customer_order);
                    $order_date = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':order_date', $order_date);


                    // Execute the query
                    if ($stmt->execute()) {
                        $query = "SELECT MAX(order_id) as order_id FROM order_summary";
                        $stmt = $con->prepare($query);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $order_id = $row['order_id'];
                        echo $order_id;
                        echo "<div class='alert alert-success'>Record Save</div>";
                        for ($star = 0; $star < count($product_id); $star++) {

                            try {
                                // insert query
                                $query = "INSERT INTO order_details SET order_id=:order_id , product_id=:product_id , quantity=:quantity ";
                                // prepare query for execution
                                $stmt = $con->prepare($query);
                                // bind the parameters  
                                $stmt->bindParam(':order_id', $order_id);
                                $stmt->bindParam(':product_id', $product_id[$star]);
                                $stmt->bindParam(':quantity', $quantity[$star]);



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
                <tr class="order">

                    <td>Product 1</td>
                    <td class="d-flex">
                        <select class="form-select form-select-lg mb-3 col" name="product_id[]" aria-label=".form-select-lg example">
                            <option>Please select product</option>
                            <?php
                            $query = "SELECT id, name, price FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();

                            $num = $stmt->rowCount();

                            if ($num > 0) {

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                    extract($row);

                                    echo "<option value=$id>$name</option>";
                                }
                            } ?>
                        </select>


                    </td>
                    <td>Quantity</td>
                    <td><select class="form-select form-select-lg mb-3" name="quantity[]" aria-label=".form-select-lg example">
                            <option value=0>0</option>
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                        </select></td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td colspan="3">
                        <input type="button" value="Add More Product" class="add_one" />
                        <input type="button" value="Delete" class="delete_one" />
                    </td>

                </tr>

                <td></td>
                <td colspan="3">
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='order_read.php' class='btn btn-danger'>Back to read order summary</a>
                    <a href='order_details_read.php' class='btn btn-danger'>Back to read order details</a>
                </td>
                </tr>
            </table>
        </form>

        <script>
            document.addEventListener('click', function(event) {
                if (event.target.matches('.add_one')) {
                    var element = document.querySelector('.order');
                    var clone = element.cloneNode(true);
                    element.after(clone);
                }
                if (event.target.matches('.delete_one')) {
                    var total = document.querySelectorAll('.order').length;
                    if (total > 1) {
                        var element = document.querySelector('.order');
                        element.remove(element);
                    }
                }
                var total = document.querySelectorAll('.order').length;

                var row = document.getElementById('.order').rows;
                for (var i = 1; i <= total; i++) {
                    row[i].cells[0].innerHTML = i;

                }
            }, false);
        </script>
    </div>
    <!-- end .container -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">

    </script>
</body>

</html>