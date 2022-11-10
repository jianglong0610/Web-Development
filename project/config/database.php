
    <?php
    // used to connect to the database
    $host = "localhost";
    $db_name = "eshop";
    $username = "eshop";
    $password = "C(zF(05LN17mfxnn";
    $mysqli = new mysqli($host, $username, $password, $db_name);

    try {
        $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // show error
        echo "";
    }
    // show error
    catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
    }
    ?>

