<?php

if (isset($_GET["export"])) {
    if ($_GET["export"] == "transaction") {?>
        <?php
    include_once 'includes/header.php';
    require_once 'includes/connection.php';
    require_once 'includes/function.php';
    session_start();
?>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/accounts.css">
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
                    <span class="span-header">Transaction</span>
                    <select id="search" >
                        <?php
                            $sql = "SELECT * FROM accounts";
                            $stmt = mysqli_stmt_init($connection);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                header("location: ../export.php?error=stmtfailedexists");
                                exit();
                            }
                            mysqli_stmt_execute($stmt);

                            $resultData = mysqli_stmt_get_result($stmt);

                            while($data = mysqli_fetch_array($resultData)){
                        ?>
                            <option value="<?php echo $data[4] . " ". $data[5] . " " . $data[6]; ?>"><?php echo $data[4] . " ". $data[5] . " " . $data[6]; ?></option>
                        <?php }mysqli_stmt_close($stmt); ?>
                    </select>
                    <form method="POST" action="includes/exportData.php">
                        <button class="action" name="transaction"><a class="action">Export Transaction</a></button>
                    </form>
                </div>
                    <table id = "tableData" class="onetable">
                        <thead>
                            <th class="header"><b>Employee Name</th>
                            <th class="header"><b>Product Name</th>
                            <th class="header"><b>Customer Quantity</th>
                            <th class="header"><b>Product Price</th>
                        </thead>
                        <tbody id="result">
                        </tbody>
                    </table>
                </div>
            </div>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php 
	include_once 'includes/footer.php';
?>
    <?php }else if ($_GET["export"] == "supplier") {?>
        <?php
    include_once 'includes/header.php';
    require_once 'includes/connection.php';
    require_once 'includes/function.php';
    session_start();
    ?>
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
                        <span class="span-header">Supplier Export</span>
                        <form action="includes/exportData.php" method="POST">
                        <button class="action" name="supplier"><a class="action">Export Supplier</a></button>
                        </form>
                    </div>
                    <table id = "tableData" class="onetable">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </thead>
                        <form method="POST">
                            <?php
                                $sql = "SELECT * FROM category";
                                $stmt = mysqli_stmt_init($connection);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("location: ../export.php?error=stmtfailedexists");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);

                                $resultData = mysqli_stmt_get_result($stmt);
                                $x = 1;
                                while($data = mysqli_fetch_array($resultData)){
                            ?>
                                <tbody>
                                    <tr>
                                        <th><?php echo $x; $x++; ?></th>
                                        <th><?php echo $data[1];?></th>
                                        <th><?php echo implode("|",fetchStock($connection,$data['1'])); ?></th>
                                        <th><?php echo implode("|",fetchStockPrice($connection,$data['1'])); ?></th>
                                        <th><button type="Submit" class="action" name="editcat" id ="myBtn" value="<?php echo $data[1]; ?>"><i class="fas fa-edit"></i></button></th>
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
    <?php }else{
        header('location: dashboard.php');
    }
}
