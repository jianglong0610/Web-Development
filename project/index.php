<?php
include 'check.php'
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <div class="container">

        <?php
        include 'top_nav.php'
        ?>

        <div class="d-flex justify-content-center mt-5">
            <h1>Home</h1>
        </div>

        <div class="container-fluid row m-0 bg-danger d-flex justify-content-between align-items-center">
            <div class="col-5">
                <?php
                include 'config/database.php';

                $query = "SELECT * FROM customers";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $customer = $stmt->rowCount();

                $query = "SELECT * FROM products";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $products = $stmt->rowCount();

                $query = "SELECT * FROM order_summary";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $order = $stmt->rowCount();

                echo "<h1 class=\"text-center\">Summary</h1>";
                echo "<table class='table table-dark table-hover table-bordered text-center'>";
                echo "<tr class='table-light'>";
                echo "<th>Total Number of Customer</th>";
                echo "<th>Total Number of Products</th>";
                echo "<th>Total Number of Order</th>";
                echo "</tr>";
                echo "<tr class='table-dark'>";
                echo "<td>$customer</td>";
                echo "<td>$products</td>";
                echo "<td>$order</td>";
                echo "</tr>";
                echo "</table>";
                ?>
            </div>

            <div class="col-5">
                <?php
                include 'config/database.php';

                $query = "SELECT MAX(order_id) as order_id FROM order_summary";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id = $row['order_id'];

                isset($id);
                // read current record's data
                try {
                    // prepare select query
                    $query = "SELECT * FROM order_summary WHERE order_id = ? ";
                    $stmt = $con->prepare($query);

                    // Bind the parameter
                    $stmt->bindParam(1, $id);

                    // execute our query
                    $stmt->execute();

                    // store retrieved row to a variable
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // values to fill up our form
                    extract($row);
                }

                // show error
                catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }
                ?>

                <!-- HTML read one record table will be here -->
                <!--we have our html table here where the record will be displayed-->
                <h1 class="text-center">Latest Order</h1>
                <table class='table table-dark table-hover table-responsive table-bordered text-center'>
                    <tr class="table table-light">
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Username</th>
                    </tr>
                    <tr class='table-dark'>
                        <td><?php echo htmlspecialchars($order_id, ENT_QUOTES);  ?></td>
                        <td><?php echo htmlspecialchars($order_date, ENT_QUOTES);  ?></td>
                        <td><?php echo htmlspecialchars($customer_order, ENT_QUOTES);  ?></td>
                    </tr>
                </table>
            </div>

            <div class="container my-3">
                <div class="my-3">
                    <?php
                    $query = "SELECT *,sum(price*quantity) AS HIGHEST FROM order_summary INNER JOIN order_details ON order_details.order_id = order_summary.order_id INNER JOIN products ON products.id = order_details.product_id GROUP BY order_summary.order_id ORDER BY HIGHEST DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);

                    ?>
                    <h1 class="text-center">Highest Purchased Amount Order</h1>
                    <table class='table table-dark table-hover table-responsive table-bordered text-center'>
                        <tr class='table-light'>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Username</th>
                            <th>Highest Amount</th>
                        </tr>
                        <tr class='table-dark'>
                            <td><?php echo htmlspecialchars($order_id, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($order_date, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($customer_order, ENT_QUOTES);  ?></td>
                            <td><?php $amount = htmlspecialchars(round($HIGHEST), ENT_QUOTES);
                                echo "RM $HIGHEST";
                                ?></td>
                        </tr>
                    </table>
                </div>

                <div class="my-3">
                    <?php
                    $query = "SELECT name, sum(quantity) AS popular FROM products INNER JOIN order_details ON order_details.product_id = products.id group by name order by sum(quantity) desc limit 5;";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        echo "<h1 class=\"text-center\">Top 5 Selling Product</h1>";
                        echo "<table class='table table-dark table-hover table-responsive table-bordered text-center'>";
                        echo "<tr class='table-light'><th>Product Name</th>
                 <th>Quantity</th></tr>";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<tr class='table-dark'>";
                            echo "<td>{$name}</td>";
                            echo "<td>{$popular}</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } ?>
                </div>

                <div class="my-3">
                    <?php
                    $nobuyitem = "SELECT * FROM products left JOIN order_details ON order_details.product_id = products.id WHERE product_id is NULL limit 3";
                    $stmt = $con->prepare($nobuyitem);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        echo "<h1 class=\"text-center\">TOP 3 No Popularity Products</h1>";
                        echo "<table class='table table-dark table-hover table-responsive table-bordered text-center'>";
                        echo "<tr class='table-light'>
                            <th>Product Name</th>";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<tr class='table-dark'>";
                            echo "<td>{$name}</td>";
                            echo "</tr>";
                        }
                        echo "
                    </table>";
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

    </div>
</body>

</html>