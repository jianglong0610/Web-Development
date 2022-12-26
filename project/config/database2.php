
    <?php
    // used to connect to the database
    $host = "sql202.epizy.com";
    $db_name = "epiz_33245255_eshop";
    $username = "epiz_33245255";
    $password = "TuE5YBsPWPzoTeM";
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

