<?php
    include_once 'includes/header.php';
    require_once 'includes/connection.php';
    require_once 'includes/function.php';
    session_start();
    if(isset($_POST['editstock'])){    
        $name = $_POST['editstock'];?>
        <div id="myModal" class="modal">
            <div class="modal-content table">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Edit Stock</h2>
                </div>
                <div class="modal-body">
                    <form action="includes/stocks.php" method="POST">
                        <?php $data1 = (fetchStockAll($connection, $name)); ?>
                        <input class="input-table" name="name" value="<?php echo $data1['product_name'];?>"required>
                        <p class="text margin">Product Name<p>
                        <input class="input-table" name="code" value="<?php echo $data1['product_code'];?>"required>
                        <p class="text margin">Product Code<p>
                        <select name="category" class="supplier">
                                <?php
                                    $sql = "SELECT * FROM category";
                                    $stmt = mysqli_stmt_init($connection);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header("location: ../stock_manager.php?error=stmtfailed");
                                        exit();
                                    }
                                    mysqli_stmt_execute($stmt);

                                    $resultData = mysqli_stmt_get_result($stmt);

                                    while($data = mysqli_fetch_array($resultData)){
                                ?>
                                    <option name="category" value="<?php echo $data['category_name']; ?>"><?php echo $data['category_name']; ?></option>
                                <?php }mysqli_stmt_close($stmt); ?>
                            </select></br><p class="text margin">Product Supplier<p>
                        <input name="quantity" class="input-table"value="<?php echo $data1['product_quantity'];?>"required>
                        <p class="text margin">Product Quantity<p>
                        <select name="supplier" class="category">
                                <?php
                                    $sql = "SELECT * FROM supplier";
                                    $stmt = mysqli_stmt_init($connection);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header("location: ../stock_manager.php?error=stmtfailed");
                                        exit();
                                    }
                                    mysqli_stmt_execute($stmt);

                                    $resultData = mysqli_stmt_get_result($stmt);

                                    while($data = mysqli_fetch_array($resultData)){
                                ?>
                                    <option value="<?php echo $data['supplier_name']; ?>"><?php echo $data['supplier_name']; ?></option>
                                <?php }mysqli_stmt_close($stmt); ?>
                            </select><p class="text margin">Product Supplier<p>
                        <input name="price" class="input-table"value="<?php echo $data1['product_price'];?>" required>
                        <p class="text margin">Product Price<p><br>
                        <button type="Submit" class="blue" name="update" value="<?php echo $data1['product_code']; ?>">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <script>        
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        $(function() {
         $('#myModal').css('display','block');
        });</script>
        <?php }elseif(isset($_POST['removestock'])){
            $name = $_POST['removestock'];?>
            <div id="myModal" class="modal">
                <div class="modal-content table">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                        <h2>Remove Stock</h2>
                    </div>
                    <div class="modal-body">
                        <form action="includes/stocks.php" method="POST">
                        <?php $data = (fetchStockAll($connection, $name)); ?>
                        <input readonly class="input-table disabled" name="name" value="<?php echo $data['product_name'];?>"required>
                        <p class="text margin">Product Name<p>
                        <input readonly class="input-table disabled" name="code" value="<?php echo $data['product_code'];?>"required>
                        <p class="text margin">Product Code<p>
                        <input readonly class="input-table disabled" name="code" value="<?php echo $data['product_supplier'];?>"required>
                        <p class="text margin">Product Supplier<p>
                        <input readonly name="quantity" class="input-table disabled"value="<?php echo $data['product_quantity'];?>"required>
                        <p class="text margin">Product Quantity<p>
                        <input readonly name="supplier" class="input-table disabled"value="<?php echo $data['product_supplier'];?>"required>
                        <p class="text margin">Product Supplier<p>
                        <input readonly name="price" class="input-table disabled"value="<?php echo $data['product_price'];?>" required>
                        <p class="text margin">Product Price<p><br>
                        <button type="Submit" class="blue" name="remove" value="<?php echo $data['id']; ?>">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
        <script>        
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        $(function() {
         $('#myModal').css('display','block');
        });</script>

    <?php } ?>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/stocks.css">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	<title><?php echo fetchcompanyname($connection); ?></title>
</head>
<body>
<?php
    include_once 'includes/bars.php';
?>
            <div class="info">
                <div class="card">
                    <div class="header">
                        <span class="span-header">Stocks</span>
                        <a href="adding.php?add=stock" class="action">Add Stock</a>
                        <select class  ="form-control" name="state" id="maxRows">
                            <option value="5000">Show ALL Rows</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="70">70</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <table id = "tableData" class="onetable">
                        <thead>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Supplier</th>
                            <th>Price</th>
                            <th>Action</th>
                        </thead>
                        <form action="" method="POST">
                            <?php
                                $sql = "SELECT * FROM stocks";
                                $stmt = mysqli_stmt_init($connection);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("location: ../stock_manager.php?error=stmtfailed");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);

                                $resultData = mysqli_stmt_get_result($stmt);
                                $x = 1;
                                while($data = mysqli_fetch_array($resultData)){
                            ?>
                                <tbody>
                                    <tr>
                                        <th><?php echo $data[1];?></th>
                                        <th><?php echo $data[2];?></th>
                                        <th><?php echo $data[3];?></th>
                                        <th><?php echo $data[4];?></th>
                                        <th><?php echo $data[5];?></th>
                                        <th><?php echo $data[6];?></th>
                                        <th><button type="Submit" class="action" name="editstock" id ="myBtn" value="<?php echo $data[1]; ?>"><i class="fas fa-edit"></i></button>
                                        <button type="Submit" class="action" name="removestock" id ="myBtn" value="<?php echo $data[1]; ?>"><i class="fas fa-trash-alt"></i></button></th>
                                    </tr>
                                </tbody>
                            <?php }mysqli_stmt_close($stmt); ?>
                        </form>
                    </table>
			        <div class='pagination-container' >
				        <nav>
				            <ul class="pagination">
                                <li data-page="prev" >
								     <span> < <span class="sr-only">(current)</span></span>
								</li>
                                <li data-page="next" id="prev">
								    <span> > <span class="sr-only">(current)</span></span>
								</li>
				            </ul>
				        </nav>
			        </div>
                </div>
            </div>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<?php 
	include_once 'includes/footer.php';
?>
