<?php 

require_once 'connection.php';
require_once 'function.php';

session_start();
$code = $_POST['product-code'];
$product_name = $_POST['search_text'];
$category = $_POST['product-category'];
$quantity = $_POST['product-quantity'];
$userQuantity = $_POST['user-quantity'];
$price = $_POST['product-price'];
$employee_name = $_SESSION['FName']." ".$_SESSION['MName']." ".$_SESSION['LName']; 

if(isset($_POST['confirm'])) {
    $sql = "INSERT INTO order_list (employee_name, product_name, product_code, product_category, userquantity, product_price) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../purchaseorder.php?error=stmtfailedcreate");
    exit();
}

    mysqli_stmt_bind_param($stmt, "ssssss", $employee_name, $product_name, $code, $category, $userQuantity, $price);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../purchaseorder.php?status=added");
    exit();
}else{
    header("location: ../purchaseorder.php");
}
