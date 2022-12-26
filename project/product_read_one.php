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
    <div class="container">
        <?php
        include 'top_nav.php'
        ?>
        <div class="page-header">
            <h1>Read Product</h1>
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
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT * FROM products WHERE id = :id ";
            $stmt = $con->prepare($query);

            // Bind the parameter
            $stmt->bindParam(":id", $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $image = $row['image'];
            $manufacture_date = $row['manufacture_date'];
            $expired_date = $row['expired_date'];
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
                <td>Name</td>
                <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><?php echo htmlspecialchars($price, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Promotion Price</td>
                <td><?php echo htmlspecialchars($promotion_price, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Images</td>
                <td><img src="uploads/product/<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" /></td>
            </tr>
            <tr>
                <td>Manufacture date</td>
                <td><?php echo htmlspecialchars($manufacture_date, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>expired date</td>
                <td><?php echo htmlspecialchars($expired_date, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php echo "<a href='product_edit.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>"; ?>
                    <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    <?php echo "<a href='product_delete.php?id={$id}' onclick='delete_product({$id});'  class='btn btn-danger'>Delete</a>"; ?>
                </td>
            </tr>
        </table>


    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>