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

        <?php
        include 'top_nav.php'
        ?>

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

                <table class='table table-hover table-responsive table-bordered' id='delete_row'>

                    <tr>
                        <td>customer_order</td>
                        <td colspan="4">
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
                    <tr class="pRow">

                        <td>Product</td>
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



                        <td>Quantity</td>
                        <td><input type='number' name='quantity[]' value='$quantity'/
                        <td><input type="button" value="Delete" onclick="deleteRow(this)"></td>
                        </td>

                    </tr>
                    <tr>
                        <td>

                        </td>
                        <td colspan="4">
                            <input type="button" value="Add More Product" class="add_one" />
                        </td>

                    </tr>

                    <td></td>
                    <td colspan="4">
                        <input type='submit' value='Save Changes' class='btn btn-primary' onclick="checkDuplicate(event)" />
                        <a href='order_list.php' class='btn btn-danger'>Back to read order summary</a>
                    </td>
                    </tr>
                </table>
            </form>

        </div>
        <!-- end .container -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">

        </script>

        <script>
            function checkDuplicate(event) {
                var newarray = [];
                var selects = document.getElementsByTagName('select');
                for (var i = 0; i < selects.length; i++) {
                    newarray.push(selects[i].value);
                }
                if (newarray.length !== new Set(newarray).size) {
                    alert("There are duplicate item in the array");
                    event.preventDefault();
                }
            }
        </script>

        <script>
            document.addEventListener('click', function(event) {
                if (event.target.matches('.add_one')) {
                    var element = document.querySelector('.pRow');
                    var clone = element.cloneNode(true);
                    element.after(clone);
                }
            }, false);
        </script>

        <script>
            function deleteRow(r) {
                var total = document.querySelectorAll('.pRow').length;
                if (total > 1) {
                    var i = r.parentNode.parentNode.rowIndex;
                    document.getElementById("delete_row").deleteRow(i);
                }
            }
        </script>
</body>

</html>