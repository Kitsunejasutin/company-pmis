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
                            <label for="fname">Stock Code</label>
                        </div>
                        <div class="col-75">
                            <input readonly type="text" id="code" name="code" value="<?php $data = fetchLatestStocks($connection); if (!$data == false) {$id = $data['product_code'];for ($x = 0; $x <= $id; $x++){}echo $x;}else{echo "1";} ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Stock Name</label>
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
                            <label for="lname">Stock Quantity</label>
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
                            <label for="lname">Stock Price</label>
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
                        <label for="fname">Stock Category</label>
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
                            <label for="fname">Stock Supplier</label>
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
        }elseif ($_GET['add'] == 'project'){?>  
            <div class="info">
                <form action="includes/project_inc.php" method="POST">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Project #</label>
                        </div>
                        <div class="col-75">
                            <input readonly type="text" id="id" name="id" value="<?php $data = fetchLatestProject($connection); if ($data === false) { echo "1";}else {$id = $data['project_id']; for ($x = 0; $x <= $id; $x++){}echo $x; } ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Project Title</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="title" name="title" placeholder="Title..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Progress (in %)</label>
                        </div>
                        <div class="col-75">
                            <input type="range" id="progress" name="progress" value="0" min="0" max="100" oninput="this.nextElementSibling.value = this.value" required>
                            <output name="progress_value">0</output>%
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Priority</label>
                        </div>
                        <div class="col-75">
                            <select name="priority">
                                <option value="Low">Low</option>
                                <option value="Meduim">Meduim</option>
                                <option value="High">High</option>
                                <option value="Urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Client</label>
                        </div>
                        <div class="col-75">
                            <input list="client" name="client" required>
                                <datalist id="client">
                                    <?php 
                                        $sql = "SELECT * FROM clients";
                                        $stmt = mysqli_stmt_init($connection);
                                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                                            header("location: ../adding.php?add=project?error=stmtfailedexists");
                                            exit();
                                        }
                                        mysqli_stmt_execute($stmt);
                                                    
                                        $resultData = mysqli_stmt_get_result($stmt);

                                        while($row = mysqli_fetch_array($resultData)){?>
                                            <option value="<?php echo $row[2];?>"></option>
                                        <?php }
                                                    
                                        mysqli_stmt_close($stmt);
                                    ?>
                                </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Budget</label>
                        </div>
                        <div class="col-75">
                            <input type="number" id="budget" name="budget" placeholder="Budget..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Start Date</label>
                        </div>
                        <div class="col-75">
                            <input type="date" id="start_date" name="start_date" style="resize:none;" placeholder="Supplier..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Due Date</label>
                        </div>
                        <div class="col-75">
                            <input type="date" id="due_date" name="due_date" style="resize:none;" placeholder="Supplier..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Assign to</label>
                        </div>
                        <div class="col-75">
                            <input list="account" name="assign" required>
                            <datalist id="account">
                                <?php 
                                    $sql = "SELECT * FROM accounts";
                                    $stmt = mysqli_stmt_init($connection);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header("location: ../adding.php?add=project?error=stmtfailedexists");
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Group</label>
                        </div>
                        <div class="col-75">
                            <input list="group" name="group" required>
                            <datalist id="group">
                                <?php 
                                    $sql = "SELECT * FROM groups";
                                    $stmt = mysqli_stmt_init($connection);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header("location: ../adding.php?add=project?error=stmtfailedexists");
                                        exit();
                                    }
                                    mysqli_stmt_execute($stmt);
                                                
                                    $resultData = mysqli_stmt_get_result($stmt);

                                    while($row = mysqli_fetch_array($resultData)){?>
                                        <option value="<?php echo $row[3];?>"></option>
                                    <?php }
                                                
                                    mysqli_stmt_close($stmt);
                                ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Note</label>
                        </div>
                        <div class="col-75">
                            <textarea name="note" style="height: 200px; resize:none"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Status</label>
                        </div>
                        <div class="col-75">
                            <input list="status" name="status" required>
                            <datalist id="status">
                                <option value="Planning">Planning</option>
                                <option value="Executing">Executing</option>
                                <option value="Done">Done</option>
                            </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <button type="Submit" class="submit" name="addproject">Add Project</button>
                    </div>
                </form>
                <a href="project.php"><button type="Submit" class="submit" name="submit">Back</button></a>
            </div>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    
    <?php 
        include_once 'includes/footer.php';
        }elseif ($_GET['add'] == 'client'){?>  
            <div class="info">
                <form action="includes/project_inc.php" method="POST">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Client #</label>
                        </div>
                        <div class="col-75">
                            <input readonly type="text" id="id" name="id" value="<?php $data = fetchLatestClient($connection); if ($data === false) { echo "1";}else {$id = $data['client_id']; for ($x = 0; $x <= $id; $x++){}echo $x; } ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Client Name</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="client_name" name="client_name" placeholder="Name..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Email</label>
                        </div>
                        <div class="col-75">
                            <input type="email" id="email" name="email" placeholder="Email..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Password</label>
                        </div>
                        <div class="col-75">
                            <input type="password" id="password" name="password" placeholder="Password..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Phone</label>
                        </div>
                        <div class="col-75">
                            <input type="number" id="phone" name="phone" placeholder="Contact Phone..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Address</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="address" name="address" placeholder="Address..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Group</label>
                        </div>
                        <div class="col-75">
                        <input list="group" name="group">
                            <datalist id="group">
                                <?php 
                                    $sql = "SELECT * FROM groups";
                                    $stmt = mysqli_stmt_init($connection);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header("location: ../adding.php?add=project?error=stmtfailedexists");
                                        exit();
                                    }
                                    mysqli_stmt_execute($stmt);
                                                
                                    $resultData = mysqli_stmt_get_result($stmt);

                                    while($row = mysqli_fetch_array($resultData)){?>
                                        <option value="<?php echo $row[2];?>"></option>
                                    <?php }
                                                
                                    mysqli_stmt_close($stmt);
                                ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <button type="Submit" class="submit" name="addclient">Add Client</button>
                    </div>
                </form>
                <a href="clients.php"><button type="Submit" class="submit" name="submit">Back</button></a>
            </div>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    
    <?php 
        include_once 'includes/footer.php';
        }
    }else {
        echo "may male";
    }

