<?php 
    if(isset($_POST['editproject'])){
        include_once 'includes/header.php';
        require_once 'includes/connection.php';
        require_once 'includes/function.php';
        session_start();
    
        echo '<link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/addstyles.css">
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
        <title>' . fetchcompanyname($connection) . '</title>
    </head>
    <body>';
        include_once 'includes/bars.php';
        $id = $_POST['editproject'];
        $data = fetchProject($connection, $id)
    ?>            <div class="info">
    <form action="includes/project_inc.php" method="POST">
        <div class="row">
            <div class="col-25">
                <label for="fname">Project #</label>
            </div>
            <div class="col-75">
                <input readonly type="text" id="id" name="id" value="<?php echo $id ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="fname">Project Title</label>
            </div>
            <div class="col-75">
                <input type="text" id="title" name="title" placeholder="Title..." value="<?php echo $data['project_name']; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="fname">Progress (in %)</label>
            </div>
            <div class="col-75">
                <input type="range" id="progress" name="progress" value="value="<?php echo $data['project_progress']; ?>" " min="0" max="100" oninput="this.nextElementSibling.value = this.value" required>
                <output name="progress_value"><?php echo $data['project_progress']; ?> </output>%
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="fname">Priority</label>
            </div>
            <div class="col-75">
                <select name="priority" ?>" >
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
                <input list="client" name="client" value="<?php echo $data['project_client']; ?>" required>
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
                <input type="number" id="budget" name="budget" placeholder="Budget..." value="<?php echo $data['project_budget']; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="fname">Start Date</label>
            </div>
            <div class="col-75">
                <input type="date" id="start_date" name="start_date" style="resize:none;" placeholder="Supplier..." value="<?php echo $data['start_time']; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="fname">Due Date</label>
            </div>
            <div class="col-75">
                <input type="date" id="due_date" name="due_date" style="resize:none;" placeholder="Supplier..." value="<?php echo $data['due_date']; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="fname">Assign to</label>
            </div>
            <div class="col-75">
                <input list="account" name="assign" value="<?php echo $data['project_members']; ?>" required>
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
                <input list="group" name="group" value="<?php echo $data['project_group']; ?>" required>
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
                <textarea name="note" style="height: 200px; resize:none"><?php echo $data['project_note']; ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="fname">Status</label>
            </div>
            <div class="col-75">
                <input list="status" name="status" value="<?php echo $data['project_status']; ?>" required>
                <datalist id="status">
                    <option value="Planning">Planning</option>
                    <option value="Executing">Executing</option>
                    <option value="Done">Done</option>
                </datalist>
            </div>
        </div>
        <div class="row">
            <button type="Submit" class="submit" name="updateProject" value="<?php echo $id; ?>">Update Project</button>
        </div>
    </form>
    <a href="project.php"><button type="Submit" class="submit" name="updateProject">Back</button></a>
</div>
    <?php        include_once 'includes/footer.php'; 
    }elseif(isset($_POST['removeProject'])){
        require_once 'includes/connection.php';
        require_once 'includes/function.php';
        session_start();
        
        $id = $_POST['removeProject'];
        echo $id;
        deleteProject($connection, $id);
    }else {
        echo "may male";
    }

