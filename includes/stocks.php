<?php
    require_once 'connection.php';
    require_once 'function.php';

if(isset($_POST['addcat'])){
    $cat = $_POST['category'];
    $table = "category";
    $column = "category_name";
    $item = $cat;
    if (itemExists($connection, $table,  $column, $item) !== false) {
        header("location: ../adding.php?add=category&error=categoryexists");
        exit();
    }
    addCategory($connection, $cat);
    
}elseif(isset($_POST['update-category'])){
    $name = $_POST['name'];
    $id = $_POST['update-category'];
    updateCategory($connection, $name, $id);
}elseif(isset($_POST['remove-category'])){
    $name = $_POST['name'];
    deleteCategory($connection, $name);
}elseif(isset($_POST['addstock'])){
    $name = $_POST['name'];
    $code = $_POST['code'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $supplier = $_POST['supplier'];
    $price = $_POST['price'];
    $table = "stocks";
    $column = "product_name";
    $item = $name;
    if (itemExists($connection, $table,  $column, $item) !== false) {
        header("location: ../adding.php?add=stock&error=stockexists");
        exit();
    }

    addStock($connection, $name, $code, $category, $quantity, $supplier, $price);
}elseif(isset($_POST['addsupplier'])){
    $name = $_POST['supplier'];
    $price = $_POST['price'];
    $table = "supplier";
    $column = "supplier_name";
    $item = $name;
    if (itemExists($connection, $table,  $column, $item) !== false) {
        header("location: ../adding.php?add=supplier&error=supplierexists");
        exit();
    }

    addSupplier($connection, $name);
}elseif(isset($_POST['update-supplier'])){
    $id = $_POST['update-supplier'];
    $name = $_POST['name'];
    updateSupplier($connection,$name, $id);
}elseif(isset($_POST['remove-supplier'])){
    $name = $_POST['remove-supplier'];
    deleteSupplier($connection,$name);
}elseif(isset($_POST['submit'])){
    session_start();
    $admin = $_POST['admin'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $category = $_POST['category'];
    $quantity  = $_POST['quantity'];
    $supplier = $_POST['supplier'];
    $price = $_POST['price'];
    $custom_name = $_POST['customer_name'];
    $custom_quantity = $_POST['customer_quantity'];
    $custom_quantity = $_POST['customer_quantity'];
    $status = $_POST['status'];
    //echo $admin;
    //echo $code;
    //echo $category;
    //echo $quantity;
    //echo $supplier;
    //echo $price;
    //echo $custom_name;
    //echo $custom_quantity;
    //echo $status;
    date_default_timezone_set('Asia/Manila');
    $transaction_time = date("Y-m-d");
        $sql = "SELECT * FROM stocks WHERE product_name=?";
        $stmt = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../purchaseorder.php?error=stmtfailed");
        exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
                                            
        $resultData = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($resultData);
        $newquantity  = $row['product_quantity'] - $custom_quantity;
        $newproductprice = $price * $custom_quantity;                                
        mysqli_stmt_close($stmt);
        $sql1 = "UPDATE stocks SET product_quantity=? WHERE product_code=?;";
        $stmt1 = mysqli_stmt_init($connection);
        $stmt1 = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt1, $sql1)) {
            header("location: ../purchaseorder.php?error=stmtfailedcreate");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt1, "ss", $newquantity, $code);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);
    orderConfirm($connection, $admin, $custom_name, $code, $name, $category, $custom_quantity, $newproductprice, $transaction_time, $status, $newquantity);

}elseif(isset($_POST['update'])){
    $name = $_POST['name'];
    $code = $_POST['code'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $supplier = $_POST['supplier'];
    $price = $_POST['price'];
    updateStock($connection, $name, $code, $category, $quantity, $supplier, $price);
}else{
    echo "parang may mali";
}
