<?php

function invalidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }else {
        $result = false;
    }
    return $result;
}

function emailExists($connection, $email) {
    $sql = "SELECT * FROM accounts WHERE email = ?;";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailedexists");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($connection, $id, $email, $pwd, $FName, $MName, $LName, $address, $contact) {
    $sql = "INSERT INTO accounts (employee_id, email, pwd, FName, MName, LName, access, employee_status, employ_address, contact) VALUES (?, ?, ?, ?, ?, ?, '1', 'active', ?, ?);";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../addemployee.php?error=stmtfailedcreate");
        exit();
    }

    $hashedPWD = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssssss", $id, $email, $hashedPWD, $FName, $MName, $LName, $address, $contact);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../addemployee.php?success=added");
    exit();
}

function loginUser($connection, $email, $pwd) {
    $emailExists = emailExists($connection, $email);

    if ($emailExists === false) {
        header("location: ../index.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $emailExists["pwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../index.php?error=wrongloginpassword");
        exit();
    }else if ($checkPwd === true) {
        session_start();
        $_SESSION["access"] = $emailExists["access"];
        if ($_SESSION['access'] == "1") {
            $_SESSION["LName"] = $emailExists["LName"];
            $_SESSION["FName"] = $emailExists["FName"];
            $_SESSION["MName"] = $emailExists["MName"];
            header("location: ../dashboard.php" );
            exit();
        }elseif ($_SESSION['access'] == "0"){
            $_SESSION["admin"] = TRUE;
            $_SESSION["LName"] = $emailExists["LName"];
            $_SESSION["FName"] = $emailExists["FName"];
            $_SESSION["MName"] = $emailExists["MName"];
            $_SESSION["email"] = $emailExists["email"];
            $sql = "SELECT company_name FROM company_info"; $result = mysqli_query($connection, $sql); $column = mysqli_fetch_array($result);
            if ($column['company_name'] == ""){header("location: ../registration1.php");}else {header("location: ../dashboard.php");}
            exit();
        }
    }
}

function fetchcompanyname($connection){
    $sql = "SELECT company_name FROM company_info; ";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($result);
    return $row['company_name'];
}

function timeIn($connection, $id, $time) {
    $sql = "SELECT * FROM accounts";
	$result = mysqli_query($connection, $sql);
	while ($row = mysqli_fetch_assoc($result)){
		$array[] = $row;
	}
	foreach ($array as $data){
		if($id == $data['id']){
			$sql = "SELECT * FROM timeclock WHERE ID='". $id ."';";
			$result = mysqli_query($connection, $sql);
			while ($row = mysqli_fetch_assoc($result)){
				$array[] = $row;
			}
			foreach ($array as $datas){}
				if($datas['verify_status'] == "TimeIn"){
					header("location: ../attendance.php?status=clockinalready");
					exit();
				}else{
					$name = $data['FName'] ." ". $data['LName'];
					$sql = "INSERT INTO timeclock (ID, verify_status, employee_name, time_in) VALUES ('$id', 'TimeIn','$name', '$time');";
					$execute = mysqli_query($connection, $sql);
					session_start();
					$last_id = mysqli_insert_id($connection);
					$_SESSION['user_id'] = $last_id;
                    $_SESSION['status'] = "timeIn";
					header("location: ../attendance.php?success=clockin");
			}
		}else{
			header("location: ../attendance.php?status=error");
		}
	}
}

function timeOut($connection, $id, $time) {
	$sql = "SELECT * FROM accounts";
	$result = mysqli_query($connection, $sql);
	while ($row = mysqli_fetch_assoc($result)){
		$array[] = $row;
	}
	foreach ($array as $data){
		if($id == $data['id']){
			session_start();
			$sql = "SELECT * FROM timeclock WHERE id_key='". $_SESSION['user_id'] ."'";
			$result = mysqli_query($connection, $sql);
			while ($row = mysqli_fetch_assoc($result)){
				$array[] = $row;
			}
			foreach ($array as $datas){
				if($datas['verify_status'] == "TimeOut"){
					header("location: ../attendance.php?status=clockoutalready");
					exit();
				}elseif($datas['verify_status'] == "TimeIn"){
					$name = $data['FName'] ." ". $data['LName'];
					$sql = "UPDATE timeclock SET verify_status='TimeOut', time_out='". $time ."' WHERE id_key='". $_SESSION['user_id'] ."'";
					$execute = mysqli_query($connection, $sql);
                    session_start();
                    $_SESSION['status'] = "timeOut";
					header("location: ../attendance.php?status=clockout");
				}
			}
		}else{
			header("location: ../attendance.php?status=error");
		}
	}	
}

function fetchAccounts($connection) {
    $sql = "SELECT * FROM accounts";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailedexists");
        exit();
    }

    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_array($resultData)) {
        return $row;
    }else {
        $result = false;
        return $result;
    }
}

function fetchLatestAccount($connection) {
    $sql = "SELECT employee_id FROM accounts ORDER BY employee_id DESC LIMIT 1";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailedexists");
        exit();
    }

    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_array($resultData)) {
        return $row;
    }else {
        $result = false;
        return $result;
    }
}

function fetchDataid($connection, $id){
    $sql = "SELECT employee_id,FName, MName, LName, access FROM accounts WHERE employee_id=?;";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../permissions.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);    
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
    exit();

}

function updateAccess($connection, $access, $id){
    $sql = "UPDATE accounts SET access=? WHERE employee_id=?;";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../permissions.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $access, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../permissions.php?success=updated");
    exit();
}

function deleteAccount($connection, $id){
    $sql = "DELETE FROM accounts WHERE employee_id=?";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../accounts.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../accounts.php?success=deleted");
    exit();
}

function addCategory($connection, $cat) {
    $sql = "INSERT INTO category (category_name) VALUES (?);";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../pro-categories.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $cat);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../pro-categories.php?success=added");
    exit();
}

function addStock($connection, $name, $code, $category, $quantity, $supplier, $price) {
    $sql = "INSERT INTO stocks (product_name, product_code, product_category, product_quantity, product_supplier, product_price) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../stock_manager.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $name, $code, $category, $quantity, $supplier, $price);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../stock_manager.php?success=added");
    exit();
}

function fetchStock($connection, $category){
    $sql = "SELECT COUNT(product_category) AS NumberOfProducts FROM stocks WHERE product_category=?;";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailedexists");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $category);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
    exit();
}

function selectProdName($connection, $category) {
    $sql = "SELECT product_name FROM stocks WHERE employee_id=?;";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../permissions.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $category);
    mysqli_stmt_execute($stmt);    
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
    exit();

}

function fetchStockPrice($connection, $category){
    $sql = "SELECT SUM(product_price) FROM stocks WHERE product_category=?;";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailedexists");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $category);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;

    }else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
    exit();
}

function addSupplier($connection, $name) {
    $sql = "INSERT INTO supplier (supplier_name) VALUES (?);";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../suppliers.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../suppliers.php?success=added");
    exit();
}

function fetchSupplier($connection, $supplier) {
    $sql = "SELECT COUNT(product_supplier) AS NumberOfProducts FROM stocks WHERE product_supplier=?;";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailedexists");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $supplier);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
    exit();
}

function fetchStockAll ($connection, $prodname) {
    $sql = "SELECT * FROM stocks WHERE product_name=?";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../stocks.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $prodname);
    mysqli_stmt_execute($stmt);    
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
    exit();
}

function fetchSpecific($connection, $table, $specific, $column) {
    $sql = "SELECT * FROM ".$table." WHERE ".$specific."=?;";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../permissions.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $column);
    mysqli_stmt_execute($stmt);    
    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }

    mysqli_stmt_close($stmt);
    exit();

}

function updateStock($connection, $name, $code, $category, $quantity, $supplier, $price){
    $sql = "UPDATE stocks SET product_name=?, product_code=?, product_category=?, product_quantity=?, product_supplier=?, product_price=? WHERE product_name=?";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../stock_manager.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $name, $code, $category, $quantity, $supplier, $price, $name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../stock_manager.php?success=updated");
    exit();
}

function deleteStock($connection, $id){
    $sql = "DELETE FROM stocks WHERE id=?";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../stock_manager.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../stock_manager.php?success=deleted");
    exit();
}

function updateCategory($connection, $name, $id) {
    $sql = "UPDATE category SET category_name=? WHERE id=?";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../pro-categories.php?error=stmtfailedcreate");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $name, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../pro-categories.php?success=updated");
    exit();
}
