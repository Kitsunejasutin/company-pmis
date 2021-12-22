<?php 
    if(isset($_GET['add'])){
        include_once 'includes/header.php';
        require_once 'includes/connection.php';
        require_once 'includes/function.php';
        session_start();
    
        echo '<link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/stocks.css">
        <link rel="stylesheet" href="styles/addstyles.css">
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
        <title>' . fetchcompanyname($connection) . '</title>
    </head>
    <body>';
        include_once 'includes/bars.php';
    
        if($_GET['add'] == 'stock'){?>
            <div class="info">
                <form action="includes/stocks.php" method="POST">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Product Code</label>
                        </div>
                        <div class="col-75">
                            <input readonly type="text" id="code" name="code" value="<?php $data = fetchLatestStocks($connection); if (!$data == false) {$id = $data['product_code'];for ($x = 0; $x <= $id; $x++){}echo $x;}else{echo "1";} ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Product Name</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="name" name="name" placeholder="Name..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Product Category</label>
                        </div>
                        <div class="col-75">
                            <select name="category">
                                <?php 
                                    $sql = "SELECT * FROM category";
                                    $stmt = mysqli_stmt_init($connection);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header("location: ../addbook.php?error=stmtfailedexists");
                                        exit();
                                    }
                                    mysqli_stmt_execute($stmt);
                                    
                                    $resultData = mysqli_stmt_get_result($stmt);

                                    while($row = mysqli_fetch_array($resultData)){?>
                                        <option value="<?php echo $row[1]; ?>"><?php echo $row[1]; ?></option>
                                    <?php }
                                    mysqli_stmt_close($stmt);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Product Quantity</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="quantity" name="quantity" placeholder="Quantity..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Product Supplier</label>
                        </div>
                        <div class="col-75">
                        <select name="supplier">
                                <?php 
                                    $sql = "SELECT * FROM supplier";
                                    $stmt = mysqli_stmt_init($connection);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header("location: ../addbook.php?error=stmtfailedexists");
                                        exit();
                                    }
                                    mysqli_stmt_execute($stmt);
                                    
                                    $resultData = mysqli_stmt_get_result($stmt);

                                    while($row = mysqli_fetch_array($resultData)){?>
                                        <option value="<?php echo $row[1]; ?>"><?php echo $row[1]; ?></option>
                                    <?php }
                                    mysqli_stmt_close($stmt);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Product Price</label>
                        </div>
                        <div class="col-75">
                        <input type="text" id="price" name="price" placeholder="Price..." required>
                        <?php include_once 'includes/status_messages.php'; ?>
                        </div>
                    </div>
                    <div class="row">
                        <button type="Submit" class="submit" name="addstock">Add Stock</button>
                    </div>
                </form>
                <a href="stock_manager.php"><button type="Submit" class="submit" name="submit">Back</button></a>
            </div>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<?php 
	include_once 'includes/footer.php';

    }elseif ($_GET['add'] == 'category'){?>  
        <div class="info">
            <form action="includes/stocks.php" method="POST">
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Product Category</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="category" name="category" placeholder="Category..." required>
                    </div>
                </div>
                <div class="row">
                    <button type="Submit" class="submit" name="addcat">Add Category</button>
                </div>
            </form>
            <a href="pro-categories.php"><button type="Submit" class="submit" name="submit">Back</button></a>
        </div>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<?php 
	include_once 'includes/footer.php';

        }elseif ($_GET['add'] == 'supplier'){?>  
            <div class="info">
                <form action="includes/stocks.php" method="POST">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Product Supplier</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="supplier" name="supplier" placeholder="Supplier..." required>
                        </div>
                    </div>
                    <div class="row">
                        <button type="Submit" class="submit" name="addsupplier">Add Supplier</button>
                    </div>
                </form>
                <a href="suppliers.php"><button type="Submit" class="submit" name="submit">Back</button></a>
            </div>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    
    <?php 
        include_once 'includes/footer.php';
        }
    }else {
        echo "may male";
    }

