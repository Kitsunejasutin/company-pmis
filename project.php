<?php
    include_once 'includes/header.php';
    require_once 'includes/connection.php';
    require_once 'includes/function.php';
    session_start();
    
?>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/project.css">
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
                            <div><i class="fas fa-tasks"></i><p class="textone">Progress</p></div>
                            <p class="align-right"><?php 
                            $column = "id";
                            $table = "projects";
                            echo implode("|",countAll($connection, $column, $table)); ?></p>
                        </div>
                        <div class="column second">
                            <div><i class="fas fa-check-circle"></i><p class="texttwo">Finished</p></div>
                            <p class="align-right"><?php 
                            $column = "id";
                            $table = "projects";
                            $column_value = "project_status";
                            $verify_value = "finished";
                            echo implode("|",countSpecific($connection, $column, $table, $column_value, $verify_value)); ?></p>
                        </div>
                        <div class="column third">
                            <div><i class="far fa-dot-circle"></i><p class="textthree">Total</p></div>
                            <p class="align-right"><?php 
                            $column = "id";
                            $table = "projects";
                            echo implode("|",countAll($connection, $column, $table)); ?></p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <select class="form-control hidden" name="state" id="maxRows">
                        <option value="5000">Show ALL Rows</option>
                        <option value="5">5</option>
                    </select>
                    <div class="headertwo">
                        <p class="header">Projects</p>
                        <a href="adding.php?add=project" class="action">Add Project</a>
                    </div>
                    <table class="tableone">
                        <thead>
                            <th>Name</th>
                            <th>Assigned</th>
                            <th>Start Date</th>
                            <th>Due Date</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>
                        <form action="editproject.php" method="POST">
                            <?php
                                $sql = "SELECT * FROM projects";
                                $stmt = mysqli_stmt_init($connection);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("location: ../project.php?error=stmtfailedexists");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);

                                $resultData = mysqli_stmt_get_result($stmt);
                                    while($data = mysqli_fetch_array($resultData)){
                                ?>
                                <tbody>
                                    <tr class="one">
                                        <th><?php echo $data[2]?></th>
                                        <th><?php echo $data[9]?></th>
                                        <th><?php echo $data[7]?></th>
                                        <th><?php echo $data[8]?></th>
                                        <th><?php echo $data[5]?></th>
                                        <th><?php echo $data[12]?></th>
                                        <th><button type="Submit" class="action" name="editproject" value="<?php echo $data[1]; ?>"><i class="fas fa-edit"></i></button>
                                        <button type="Submit" class="action" name="removeProject" value="<?php echo $data[1]; ?>"><i class="fas fa-trash-alt"></i></button></th>
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
