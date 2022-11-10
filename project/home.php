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

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
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

        <div class="d-flex justify-content-center mt-5">
            <h1>Home</h1>
        </div>

        <div class="row m-5">
            <div class="col">
                Picture
            </div>
            <div class="col">
                Picture
            </div>
            <div class="col">
                Picture
            </div>
        </div>

        <div class="row m-5">
            <div class="col">
                Content
            </div>
            <div class="col">
                Content
            </div>
            <div class="col">
                Content
            </div>
        </div>


        <div class="d-flex justify-content-center mt-5">
            <a href="log_out.php">Log Out</a>
        </div>

    </div>
</body>

</html>