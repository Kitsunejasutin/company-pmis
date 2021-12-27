<?php
    include_once 'includes/header.php';
    require_once 'includes/connection.php';
    require_once 'includes/function.php';
    session_start();
    if(isset($_POST['editclient'])){    
        $id = $_POST['editclient'];?>
        <div id="myModal" class="modal">
            <div class="modal-content table">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Edit Stock</h2>
                </div>
                <div class="modal-body">
                    <form action="includes/project_inc.php" method="POST">
                        <?php $data1 = (fetchClientid($connection, $id)); ?>
                        <input class="input-table" name="client_name" value="<?php echo $data1['client_name'];?>"required>
                        <p class="text margin">Client Name<p>
                        <input class="input-table" name="email" value="<?php echo $data1['client_email'];?>"required>
                        <p class="text margin">Client Email<p>
                        <input name="phone" class="input-table"value="<?php echo $data1['client_contact'];?>"required>
                        <p class="text margin">Client Contact<p>
                        <input name="address" class="input-table"value="<?php echo $data1['client_address'];?>" required>
                        <p class="text margin">Client Address<p><br>
                        <input class="input-table" list="group" name="group"required>
                            <datalist id="group">
                                <?php 
                                    $sql = "SELECT * FROM groups";
                                    $stmt = mysqli_stmt_init($connection);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header("location: ../clients.php?error=stmtfailedexists");
                                        exit();
                                    }
                                    mysqli_stmt_execute($stmt);
                                                
                                    $resultData = mysqli_stmt_get_result($stmt);

                                    while($row = mysqli_fetch_array($resultData)){?>
                                        <option value="<?php echo $row[4]." ".$row[6];?>"></option>
                                    <?php }
                                                
                                    mysqli_stmt_close($stmt);
                                ?>
                            </datalist>
                        <p class="text margin">Client Group<p><br>
                        <button type="Submit" class="blue" name="updateclient" value="<?php echo $id; ?>">Update</button>
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
    <?php }elseif(isset($_POST['removeclient'])){    
        $id = $_POST['removeclient'];?>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Remove Employee?</h2>
                </div>
                <div class="modal-body">
                    <form action="includes/project_inc.php" method="POST">
                        <?php $data = (fetchClientid($connection,$id)); $client_name = $data['client_name'];?>
                        <p class="text">Remove the following Client?</p><br>
                        <p class="text"><?php echo $id;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $client_name; ?></p><br>
                        <button type="Submit" class="blue" name="removeclient" value="<?php echo $id; ?>">Remove</button>
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
    <link rel="stylesheet" href="styles/project.css">
	<title><?php echo fetchcompanyname($connection); ?></title>
</head>
<body>
<?php
    include_once 'includes/bars.php';
?>
            <div class="info">
                <div class="card">
                    <div class="headertwo">
                        <p class="header">Clients</p>
                        <a href="adding.php?add=client" class="action">Add Client</a>
                    </div>
                    <table class="tableone">
                        <thead>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Group</th>
                            <th>Settings</th>
                        </thead>
                        <form method="POST">
                            <?php
                                $sql = "SELECT * FROM clients";
                                $stmt = mysqli_stmt_init($connection);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("location: ../project.php?error=stmtfailedexists");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);

                                $resultData = mysqli_stmt_get_result($stmt);
                                while($data = mysqli_fetch_array($resultData)){ ?>
                                    <tbody>
                                        <tr class="one">
                                            <th><?php echo $data[2]?></th>
                                            <th><?php echo $data[6]?></th>
                                            <th><?php echo $data[3]?></th>
                                            <th><?php echo $data[5]?></th>
                                            <th><?php echo $data[7]?></th>
                                            <th><button type="Submit" class="action" name="editclient" id ="myBtn" value="<?php echo $data[1]; ?>"><i class="fas fa-edit"></i></button>
                                            <button type="Submit" class="action" name="removeclient" id ="myBtn" value="<?php echo $data[1]; ?>"><i class="fas fa-trash-alt"></i></button></th>
                                        </tr>
                                    </tbody>
                            <?php }mysqli_stmt_close($stmt);?>
                        </form>
                    </table>
                </div>
            </div>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<?php 
	include_once 'includes/footer.php';
?>
