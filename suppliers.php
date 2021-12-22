<?php
    include_once 'includes/header.php';
    require_once 'includes/connection.php';
    require_once 'includes/function.php';
    session_start();
    if(isset($_POST['remove'])){    
        $column = $_POST['remove'];?>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Remove Supplier?</h2>
                </div>
                <div class="modal-body">
                    <form action="includes/stocks.php" method="POST">
                        <?php $table ="supplier"; $specific ="supplier_name";$data = (fetchSpecific($connection, $table, $specific, $column)); ?>
                        <input readonly class="input-table disabled" name="name" value="<?php echo $data['supplier_name'];?>"required>
                        <p class="text margin">Supplier<p>
                        <button type="Submit" class="blue" name="remove-supplier" value="<?php echo $column; ?>">Remove</button>
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
    <?php }elseif(isset($_POST['editsup'])){    
        $column = $_POST['editsup'];?>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Update Supplier</h2>
                </div>
                <div class="modal-body">
                    <form action="includes/stocks.php" method="POST">
                        <?php $table ="supplier"; $specific ="supplier_name";$data = (fetchSpecific($connection, $table, $specific, $column)); ?>
                        <input class="input-table" name="name" value="<?php echo $data['supplier_name'];?>"required>
                        <p class="text margin">Supplier<p>
                        <button type="Submit" class="blue" name="update-supplier" value="<?php echo $data['id']; ?>">Update</button>
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
                        <span class="span-header">Suppliers</span>
                        <a href="adding.php?add=supplier" class="action">Add Supplier</a>
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
                            <th>Quantity of Products</th>
                            <th>Action</th>
                        </thead>
                        <form method="POST">
                            <?php
                                $sql = "SELECT * FROM supplier";
                                $stmt = mysqli_stmt_init($connection);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("location: ../suppliers.php?error=stmtfailedexists");
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
                                        <th><?php echo implode("|",fetchSupplier($connection,$data['1'])); ?></th>
                                        <th><button type="Submit" class="action" name="editsup" id ="myBtn" value="<?php echo $data[1]; ?>"><i class="fas fa-edit"></i></button>
                                        <button type="Submit" class="action" name="remove" id ="myBtn" value="<?php echo $data[1]; ?>"><i class="fas fa-trash-alt"></i></button></th>
                                    </tr>
                                </tbody>
                            <?php }mysqli_stmt_close($stmt); ?>
                        </form>
                    </table>
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

