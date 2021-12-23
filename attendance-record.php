<?php
    include_once 'includes/header.php';
    require_once 'includes/connection.php';
    require_once 'includes/function.php';
    session_start();
    
?>
	<link rel="stylesheet" href="styles/header.css">
	<title><?php echo fetchcompanyname($connection); ?></title>
</head>
<body onload="startTime()">
<?php
    include_once 'includes/bars.php';
?>

<div class="info">
<div class="card">
                    <div class="header">
                        <span class="span-header">Attendance</span>
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
                            <th>Status</th>
                            <th>Time-In</th>
                            <th>Time-Out</th>
                        </thead>
                        <form method="POST">
                            <?php
                                $name = $_SESSION['FName']. " " . $_SESSION['LName'];
                                $sql = "SELECT * FROM timeclock_history WHERE employee_name=?";
                                $stmt = mysqli_stmt_init($connection);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("location: ../attendance-record.php?error=stmtfailedexists");
                                    exit();
                                }
                                mysqli_stmt_bind_param($stmt, "s", $name);
                                mysqli_stmt_execute($stmt);

                                $resultData = mysqli_stmt_get_result($stmt);
                                while($data = mysqli_fetch_array($resultData)){
                            ?>
                                <tbody>
                                    <tr>
                                        <th><?php echo $data[3]; ?></th>
                                        <th><?php echo $data[2]; ?></th>
                                        <th><?php echo $data[4]; ?></th>
                                        <th><?php echo $data[5]; ?></th>
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
<?php 
	include_once 'includes/footer.php';
?>
