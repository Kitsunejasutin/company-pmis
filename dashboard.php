<?php
    include_once 'includes/header.php';
    require_once 'includes/connection.php';
    require_once 'includes/function.php';
    session_start();
    
?>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/dashboard.css">
	<title><?php echo fetchcompanyname($connection); ?></title>
</head>
<body>
<?php
    include_once 'includes/bars.php';
?>
            <div class="info">
                <div class="header">
                    <div class="row">
                        <div class="column first">
                            <div class=""><i class="fas fa-cubes"></i><p class="text">Stocks</p></div>
                            <p class="align-right"><?php 
                            $column = "product_name";
                            $table = "stocks";
                            echo implode("|",countAll($connection, $column, $table)); ?></p>
                        </div>
                        <div class="column second">
                            <div class=""><i class="fas fa-user-check"></i><p class="text">Employees</p></div>
                            <p class="align-right"><?php 
                            $column = "employee_id";
                            $table = "accounts";
                            echo implode("|",countAll($connection, $column, $table)); ?></p>
                        </div>
                        <div class="column third">
                            <div class=""><i class="fas fa-parachute-box"></i><p class="text">Suppliers</p></div>
                            <p class="align-right"><?php 
                            $column = "supplier_name";
                            $table = "supplier";
                            echo implode("|",countAll($connection, $column, $table)); ?></p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="fourth">
                        <p class="header">Time Clock</p>
                        <table class="tableone">
                            <thead>
                                <th>Employee</th>
                                <th>Status</th>
                                <th>Time In</th>
                            </thead>
                            <?php
                                $sql = "SELECT * FROM timeclock";
                                $stmt = mysqli_stmt_init($connection);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("location: ../dashboard.php?error=stmtfailedexists");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);

                                $resultData = mysqli_stmt_get_result($stmt);

                                while($data = mysqli_fetch_array($resultData)){
                            ?>
                                <tbody>
                                    <tr class="one">
                                        <th><?php echo $data[3]?></th>
                                        <th><?php echo $data[2]?></th>
                                        <th><?php echo $data[4]?></th>
                                    </tr>
                                </tbody>
                            <?php }mysqli_stmt_close($stmt); ?>
                        </table>
                    </div>
                    <div class="fifth">
                        <p class="header">Orders</p>
                        <table class="tabletwo">
                            <thead>
                                <th>Customer Name</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Status</th>
                            </thead>
                            <?php
                                $sql = "SELECT * FROM order_list";
                                $stmt = mysqli_stmt_init($connection);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("location: ../dashboard.php?error=stmtfailedexists");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);

                                $resultData = mysqli_stmt_get_result($stmt);

                                while($data = mysqli_fetch_array($resultData)){
                            ?>
                                <tbody>
                                    <tr>
                                        <th><?php echo $data[2]?></th>
                                        <th><?php echo $data[3]?></th>
                                        <th><?php echo $data[6]?></th>
                                        <th><?php echo $data[7]?></th>
                                        <th><?php echo $data[8]?></th>
                                    </tr>
                                </tbody>
                            <?php }mysqli_stmt_close($stmt); ?>
                        </table>
                    </div>
                </div>
            </div>
<?php 
	include_once 'includes/footer.php';
?>
