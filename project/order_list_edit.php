<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


    <!-- custom css -->
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
    <!-- container -->
    <div class="container">
        <?php
        include 'top_nav.php'
        ?>
        <div class="page-header">
            <h1>Edit Order List</h1>
        </div>
        <!-- PHP read record by ID will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT * FROM order_summary INNER JOIN order_details ON order_details.order_id = order_summary.order_id INNER JOIN products ON products.id = order_details.product_id WHERE order_summary.order_id = ?";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $order_id = $row['order_id'];
            $order_date = $row['order_date'];
            $customer_order = $row['customer_order'];
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $product_id = $row['product_id'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>



        <!-- HTML form to update record will be here -->
        <!-- PHP post to update record will be here -->
        <?php
        // check if form was submitted
        if ($_POST) {

            $order_id = $_POST['order_id'];
            $order_date = $_POST['order_date'];
            $customer_order = $_POST['customer_order'];
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $product_id = $_POST['product_id'];
            $error_message = "";

            try {
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE order_summary SET order_id=:order_id, order_date=:order_date, customer_order=:customer_order WHERE order_id = :order_id 
                INNER JOIN order_details ON order_details.order_id = order_summary.order_id SET order_id=:order_id, product_id=:product_id, quantity=:quantity WHERE order_id = :order_id 
                INNER JOIN products ON products.id = order_details.product_id SET id=:id, name=:name, price=:price WHERE order_id = :order_id";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $order_id = htmlspecialchars(strip_tags($_POST['order_id']));
                $order_date = htmlspecialchars(strip_tags($_POST['order_date']));
                $customer_order = htmlspecialchars(strip_tags($_POST['customer_order']));
                $id = htmlspecialchars(strip_tags($_POST['id']));
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $quantity = htmlspecialchars(strip_tags($_POST['quantity']));
                $product_id = htmlspecialchars(strip_tags($_POST['product_id']));
                // bind the parameters
                $stmt->bindParam(':order_id', $order_id);
                $stmt->bindParam(':order_date', $order_date);
                $stmt->bindParam(':customer_order', $customer_order);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':product_id', $product_id);
                // Execute the query
                if ($stmt->execute()) {
                    header("Location: order_summary.php?update={$order_id}");
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        ?>



        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">

            <table class='table table-hover table-responsive table-bordered'>

                <tr>
                    <td>customer_order</td>
                    <td colspan="3">
                        <select class="form-select form-select-lg mb-3" name="customer_order" aria-label=".form-select-lg example">
                            <option><?php echo htmlspecialchars($customer_order, ENT_QUOTES); ?></option>
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
                <?php

                $query = "SELECT * FROM order_summary INNER JOIN order_details ON order_details.order_id = order_summary.order_id INNER JOIN products ON order_details.product_id = products.id WHERE order_details.order_id=:order_id";
                $stmt = $con->prepare($query);
                $stmt->bindParam("order_id", $order_id);
                $stmt->execute();

                $num = $stmt->rowCount();

                if ($num > 0) {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $query1 = "SELECT * FROM products";
                        $stmt1 = $con->prepare($query1);
                        $stmt1->execute();

                        $num1 = $stmt->rowCount();

                        extract($row);
                        echo "<tr class='order'>";
                        echo  "<td>Product</td>";
                        echo "<td class='d-flex'>";
                        echo "<select class='form-select form-select-lg mb-3 col' name='product_id[]' aria-label='.form-select-lg example'>";
                        if ($num1 > 0) {

                            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                                if ($product_id == $id) {
                                    echo "<option value=$id selected>$name</option>";
                                } else {
                                    echo "<option value=$id>$name</option>";
                                }
                            }
                        }
                        echo "<td>Quantity</td>";
                echo "<td><select class='form-select form-select-lg mb-3' name='quantity[]' aria-label='.form-select-lg example'>";
                       echo  "<option>$quantity</option>";
                       echo  "<option value=1>1</option>";
                       echo  "<option value=2>2</option>";
                       echo  "<option value=3>3</option>";
                    echo "</select></td>";
                    }
                } ?>
                </select>


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
                    <a href='order_list.php' class='btn btn-danger'>Back to read order summary</a>
                    <a href='order_details.php' class='btn btn-danger'>Back to read order details</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>