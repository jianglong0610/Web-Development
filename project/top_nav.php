<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="home.php">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Customer
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="create_customer.php">create customer</a></li>
                    <li><a class="dropdown-item" href="customer_read.php">read customer</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Order
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="create_new_order.php">create order</a></li>
                    <li><a class="dropdown-item" href="order_list.php">order list</a></li>
                    <li><a class="dropdown-item" href="order_details.php">order details</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Product
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="product_create.php">create product</a></li>
                    <li><a class="dropdown-item" href="product_read.php">read product</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact Us</a>
            </li>

        </ul>
    </div>
    <div class="pe-3">
        <a href="log_out.php">Log Out</a>
    </div>
</nav>