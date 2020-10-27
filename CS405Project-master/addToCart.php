<?php
include('dbConnect.php');
$userName = $_COOKIE["CS405_Username"];
$query = "SELECT  * FROM orders WHERE status = 'cart' AND user_name = '";
$query .= $userName . "'";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();

if($total_row == 1){ //if a card exists for the user, grab cart id
        $orderID = $result[0]["id"];
}
else{ //if a cart does not exist for the user, give them a cart
        //inserted new cart
        $queryInsert = "INSERT INTO orders VALUES (NULL, '" . $userName . "', 'cart', NULL, NULL, 0);";
        $statement = $connect->prepare($queryInsert);
        $statement->execute();

        //query for the new cart ID
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $orderID = $result[0]["id"];
}
$name = $_POST['name'];
$quantity = $_POST['quantity'];
$queryInsertCart = "INSERT INTO order_items VALUES (" . $orderID . ", '" . $name . "', " . $quantity . ");";
echo $queryInsertCart;
$statement = $connect->prepare($queryInsertCart);
$statement->execute();
?>