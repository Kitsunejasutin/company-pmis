<?php
    include_once 'includes/header.php';
    require_once 'includes/connection.php';

    session_start();
    if (isset($_POST['submitImg'])) {
        foreach ($_POST as $key => $value) {
            $_SESSION['info'][$key] = $value;
        }

        extract($_SESSION['info']);

        $fileName = $_FILES['img']['name'];
        $fileTmpName = addslashes(file_get_contents($_FILES['img']['tmp_name']));
        $fileSize = $_FILES['img']['size'];
        $fileError = $_FILES['img']['error'];
        $fileType = $_FILES['img']['type'];
        $fileNameTrue = $_SESSION['info']['company'];

        $fileExt = explode('.', $fileName);
        $fileActualExt =strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileNameNew = $fileNameTrue.".".$fileActualExt;
                    $sql = "INSERT INTO company_info (company_name, images) VALUES ('$company','". $fileTmpName . "')";
                    mysqli_query($connection, $sql);
                    
                    $keys = array_keys($_SESSION['info']);

                    if (in_array('submitImg', $keys)) {
                        unset($_SESSION['info']['submitImg']);
                    }
            
                    if ($sql) {
                        unset($_SESSION['info']);
                        header("Location: dashboard.php");
                    }
                }else {
                    header("Location: registration2.php?status=imagetoobig");
                }
            }else {
                header("Location: registration2.php?status=error");
            }
        }else{
            header("Location: registration2.php?status=incorrecttype");
        }

    }else{
    }

?>
    <link rel="stylesheet" href="styles/registration-1.css">
    <title>Registration</title>
</head>
<body>
    <div class="container">
        <div class="front-card">
            <div class="card-header">
                <div class="group-name">
                    Welcome to the website
                </div>
                <h6 class="line-on-side text-muted font-small-3"></h6>
                <span>Looks like you're new</span><br>

            </div>
            <div class="card-body">
                <span>Please upload your Company Picture</span>
                <span class="spacing-2">(Leave it blank to set a default picture)</span>
                <form method="POST" accept-charset="utf-8" enctype='multipart/form-data'>
                    <fieldset class="form-group fieldset-border">
                        <i class="fas fa-images"></i>
                        <input type="file" name="img" class="uploadImg">
                    </fieldset>
                    <?php include_once 'includes/registration_errors.php'; ?>
                    <button type="submit" class="btn grey" name="submitImg"><span>Done</span></button>
                </form>
                <a href="registration1.php"><button class="btn grey"><span>Previous</span></button></a>
            </div>
        </div>
    </div>
