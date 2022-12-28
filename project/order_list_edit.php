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
    <div class="container" style="background-image:url('image/background.jpg')">
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
        if ($_POST) {

            $customer_order = $_POST['customer_order'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $errormsg = "";

            if ($customer_order == "Select Customer") {
                $errormsg .= "<div class='alert alert-danger'>You must to select customer.</div>";
            }
            if ($product_id == ["Please select product"]) {
                $errormsg .= "<div class='alert alert-danger'>You must to select product.</div>";
            }
            if ($quantity <= ["0"]) {
                $errormsg .= "<div class='alert alert-danger'>You must choose 1 or more.</div>";
            }
            if (empty($errormsg)) {

                try {
                    // insert query
                    $query = "UPDATE order_summary SET customer_order=:customer_order, order_date=:order_date WHERE order_id=:order_id";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':customer_order', $customer_order);
                    $order_date = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':order_date', $order_date);
                    $stmt->bindParam(':order_id', $id);

                    // Execute the query
                    if ($stmt->execute()) {
                        $query_delete = "DELETE FROM order_details WHERE order_id=:order_id";
                        $stmt_delete = $con->prepare($query_delete);
                        $stmt_delete->bindParam(':order_id', $id);
                        if ($stmt_delete->execute()) {

                            for ($count = 0; $count < count($product_id); $count++) {
                                try {
                                    // insert query
                                    $query_insert = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                                    // prepare query for execution
                                    $stmt_insert = $con->prepare($query_insert);
                                    // bind the parameters
                                    $stmt_insert->bindParam(':order_id', $id);
                                    $stmt_insert->bindParam(':product_id', $product_id[$count]);
                                    $stmt_insert->bindParam(':quantity', $quantity[$count]);
                                    //echo $product_id[$count];
                                    // Execute the query
                                    $record_number = $count + 1;
                                    if ($stmt_insert->execute()) {
                                        header("Location: order_list.php?update={$id}");
                                    } else {
                                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                                    }
                                }
                                // show errorproduct_id
                                catch (PDOException $exception) {
                                    die('ERROR: ' . $exception->getMessage());
                                }
                            }
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
            } else {
                echo "$errormsg";
            }
        }
        try {
            // prepare select query
            $query = "SELECT * FROM order_summary WHERE order_summary.order_id =:order_id";
            $stmt = $con->prepare($query);
            $stmt->bindParam(":order_id", $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>





        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo $_SERVER["PHP_SELF"] . "?id={$id}"; ?>" method="POST">

            <table class='table table-hover table-responsive table-bordered' id='delete_row'>

                <tr>
                    <td>customer_order</td>
                    <td colspan="4">
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

                $query = "SELECT * FROM order_details WHERE order_id=:order_id";
                $stmt = $con->prepare($query);
                $stmt->bindParam("order_id", $order_id);
                $stmt->execute();

                $num = $stmt->rowCount();

                if ($num > 0) {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                        extract($row);
                        echo "<tr class='pRow'>";
                        echo  "<td>Product</td>";
                        echo "<td class='d-flex'>";
                        echo "<select class='form-select form-select-lg mb-3 col' name='product_id[]' aria-label='.form-select-lg example'>";
                        $query1 = "SELECT * FROM products";
                        $stmt1 = $con->prepare($query1);
                        $stmt1->execute();

                        $num1 = $stmt1->rowCount();
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
                        echo "<td><input type='number' name='quantity[]' value='$quantity'/</td>";
                        echo "</select><td><input type='button' value='Delete' onclick='deleteRow(this)'></td>";
                    }
                } ?>
                </select>


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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('click', function(event) {
            if (event.target.matches('.add_one')) {
                var rows = document.getElementsByClassName('pRow');
                // Get the last row in the table
                var lastRow = rows[rows.length - 1];
                // Clone the last row
                var clone = lastRow.cloneNode(true);
                // Insert the clone after the last row
                lastRow.insertAdjacentElement('afterend', clone);

                // Loop through the rows
                for (var i = 0; i < rows.length; i++) {
                    // Set the inner HTML of the first cell to the current loop iteration number
                    rows[i].cells[0].innerHTML = i + 1;
                }
            }
        }, false);

        function checkDuplicate(event) {
            var newarray = [];
            var selects = document.getElementsByTagName('select');
            for (var i = 0; i < selects.length; i++) {
                newarray.push(selects[i].value);
            }
            if (newarray.length !== new Set(newarray).size) {
                alert("There are duplicate item in the product");
                event.preventDefault();
            }
        }

        function deleteRow(r) {
            var total = document.querySelectorAll('.pRow').length;
            if (total > 1) {
                var i = r.parentNode.parentNode.rowIndex;
                document.getElementById("delete_row").deleteRow(i);
            } else {
                alert("You need at least one item");
            }
        }
    </script>
</body>

</html>