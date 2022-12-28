<?php
// include database connection
include 'config/database.php';
try {     
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');
    $select ="SELECT Username AS customername, image FROM customers where id=:id";
    $stmt = $con->prepare($select);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

    // delete query
    $check ="SELECT customer_order FROM order_summary WHERE customer_order=:customer_order";
    $stmt = $con->prepare($check);
    $stmt->bindParam(":customer_order", $customername);
    $stmt->execute();
    $count = $stmt->rowCount();
    
    if($count > 0){
        header("Location: customer_read.php?action=nodelete");
    }else{
        $query = "DELETE FROM customers WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);
         
        if($stmt->execute()){
            unlink("uploads/customer/" . $row['image']);
            // redirect to read records page and
            // tell the user record was deleted
            header('Location: customer_read.php?action=deleted');
        }else{
            die('Unable to delete record.');
        }
    }
    
}
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}