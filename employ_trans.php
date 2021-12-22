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
                    <span class="span-header">Employees</span>
                    <select id="search" >
                        <?php
                            $sql = "SELECT * FROM accounts";
                            $stmt = mysqli_stmt_init($connection);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                header("location: ../employ_trans.php?error=stmtfailedexists");
                                exit();
                            }
                            mysqli_stmt_execute($stmt);

                            $resultData = mysqli_stmt_get_result($stmt);

                            while($data = mysqli_fetch_array($resultData)){
                        ?>
                            <option value="<?php echo $data[4] . " ". $data[5] . " " . $data[6]; ?>"><?php echo $data[4] . " ". $data[5] . " " . $data[6]; ?></option>
                        <?php }mysqli_stmt_close($stmt); ?>
                    </select>
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
