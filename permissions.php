<?php
    include_once 'includes/header.php';
    require_once 'includes/connection.php';
    require_once 'includes/function.php';
    session_start();
    if(isset($_POST['change'])){
        $id = $_POST['change'];?>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Update Permission</h2>
                </div>
                <div class="modal-body">
                    <form action="includes/perms.php" method="POST">
                        <?php $data = (fetchDataid($connection,$id)); $id = $data['employee_id']; $name = $data['FName']." ".$data['MName']." ".$data['LName']; $access=$data['access'];?>
                        <p class="text">Update Permission to the following Employee?</p><br>
                        <p class="text"><?php echo $id;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $name;?></p><br>
                        <p class="text">Current Access: <?php echo $access;?></p>
                        <p class="text">Updated Access: <?php if($access == "1"){echo "0";}else{echo "1";} ?></p>
                        <button type="Submit" class="blue" name="update" value="<?php echo $id; ?>">Update</button>
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
                    <span class="span-header">Permissions</span>
                    <select class="form-control" name="state" id="maxRows">
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
                            <th class="header"><b>Full Name</th>
                            <th class="header"><b>Email</th>
                            <th class="header"><b>Permission</th>
                            <th class="header"><b>Address</th>
                            <th class="header"><b>Contact</th>
                            <th class="header"><b>Action</th>
                        </thead>
                        <form method="POST">
                            <?php
                                $sql = "SELECT * FROM accounts";
                                $stmt = mysqli_stmt_init($connection);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("location: ../permissions.php?error=stmtfailedexists");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);

                                $resultData = mysqli_stmt_get_result($stmt);

                                while($data = mysqli_fetch_array($resultData)){
                            ?>
                                <tbody>
                                    <tr>
                                        <th><?php echo $data[4] ." ". $data[5] ." ". $data[6]; ?></th>
                                        <th><?php echo $data[2]?></th>
                                        <th><?php echo $data[7]?></th>
                                        <th><?php echo $data[9]?></th>
                                        <th><?php echo $data[10]?></th>
                                        <th><button type="Submit" class="action" name="change" id ="myBtn" value="<?php echo $data[1]; ?>"><i class="fas fa-chevron-circle-up"></i></button></th>
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

