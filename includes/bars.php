<div class="container">
        <div class="sidebar">
            <h2>
                <?php
                    echo fetchcompanyname($connection);
                ?>
            </h2>
            <ul id="categories">
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
            </ul>
            <ul id="categories">
                <li class="categories"><a><i class="fas fa-file-export"></i>Project<i class="arrow right"></i></a></li>
                <a href="adding.php?add=project"><li class="dropdown"><span>Add Project</span></li></a>
                <a href="project.php"><li class="dropdown"><span>Manage Projects</span></li></a>
                <a href="clients.php"><li class="dropdown"><span>Clients</span></li></a>
                <a href="todo.php"><li class="dropdown"><span>To Do List</span></li></a>
            </ul>
            <ul id="categories">
                <li class="categories"><a><i class="fas fa-boxes"></i>Inventory<i class="arrow right"></i></a></li>
                <a href="stock_manager.php"><li class="dropdown"><span>Inventory Manager</span></i></li></a>
                <a href="pro-categories.php"><li class="dropdown"><span>Inventory Categories</span></i></li></a>
                <a href="purchaseorder.php"><li class="dropdown"><span>Restock Inventory</span></i></li></a>
                <a href="suppliers.php"><li class="dropdown"><span>Suppliers</span></i></li></a>
            </ul>
            <ul id="categories">
                <li class="categories"><a><i class="fas fa-user-tie"></i>Account<i class="arrow right"></i></a></li>
                <a href="attendance.php"><li class="dropdown account"><span>Attendance</span></li></a>
                <?php if ($_SESSION["access"] == "0") { ?>
                <a href="permissions.php"><li class="dropdown"><span>Permissions</span></i></li></a>
                <a href="assign.php"><li class="dropdown"><span>Assign Employee</span></li></a>
                <a href="accounts.php"><li class="dropdown"><span>Manage Accounts</span></li></a>
                <a href="addemployee.php"><li class="dropdown"><span>Add Employees</span></li></a>
                <?php }else{} ?>
            </ul>
            <ul id="categories">
                <li class="categories"><a><i class="fas fa-table"></i>Data & Reports<i class="arrow right"></i></a></li>
                <a href="employ_trans.php"><li class="dropdown"><span>Employees Transactions</span></li></a>
            </ul>
            <ul id="categories">
                <li class="categories"><a><i class="fas fa-file-export"></i>Data Export<i class="arrow right"></i></a></li>
                <a href="export.php"><li class="dropdown"><span>Transaction Export</span></li></a>
            </ul>
            <div class="social_media">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="main_content">
            <div class="topbar">
                <i class="fas fa-bell"></i>
                <div class="account">
                    <img src ="images/user-icon.png" class="user-icon"><span class="text"><?php echo $_SESSION['LName'].", ". $_SESSION['FName'];?></span><span class="indicator">^</span>
                </div>
                <div class="popup">
                    <span class="popuptext-account" id="myPopup"><a href="includes/logout.php">Log Out</a></span>
                </div>
            </div>
