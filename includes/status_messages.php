<?php
    if (isset($_GET["status"])) {
        if ($_GET["status"] == "incorrecttype"){
            echo "<span class='error'>You cannot upload files of this type!</span>";
        }else if ($_GET["status"] == "imagetoobig") {
            echo "<span class='error'>Your file is too big!</span>";
        }else if ($_GET["status"] == "error") {
            echo "<span class='error'>There was an error uploading your file!</span>";
        }else if ($_GET["status"] == "emailtaken") {
            echo "<span class='error'>Email is already taken!</span>";
        }
    }elseif (isset($_GET["error"])){
        if ($_GET["error"] == "stmtfailed"){
            echo "<span class='error'>Something went wrong!</span>";
        }else if ($_GET["error"] == "stmtfailedcreate") {
            echo "<span class='error'>Query is not written, something went wrong!</span>";
        }else if ($_GET["error"] == "error") {
            echo "<span class='error'>There was an error uploading your file!</span>";
        }else if ($_GET["error"] == "emailtaken") {
            echo "<span class='error'>Email is already taken!</span>";
        }
    }
